<?php

namespace AltezzaTravelBundle\Controller\Tour;

use AltezzaTravelBundle\Controller\AbstractController;
use AltezzaTravelBundle\Entity\CalculationSettings\CalculationSettingCarRental;
use AltezzaTravelBundle\Entity\CalculationSettings\CalculationSettingCurrencyRate;
use AltezzaTravelBundle\Entity\CalculationSettings\CalculationSettingDomesticFlight;
use AltezzaTravelBundle\Entity\CalculationSettings\CalculationSettingFeeCrater;
use AltezzaTravelBundle\Entity\CalculationSettings\CalculationSettingFeeParkEastAfrican;
use AltezzaTravelBundle\Entity\CalculationSettings\CalculationSettingFeeParkForeigner;
use AltezzaTravelBundle\Entity\CalculationSettings\CalculationSettingOther;
use AltezzaTravelBundle\Entity\CalculationSettings\CalculationSettingTransfer;
use AltezzaTravelBundle\Form\Tour\CalculationSettingDomesticFlightForm;
use AltezzaTravelBundle\Form\Tour\CalculationSettingsForm;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\OptimisticLockException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CalculationSettingsController
 * @package AltezzaTravelBundle\Controller\Tour
 */
class CalculationSettingsController extends AbstractController
{
    /**
     * @param Request $request
     * @return Response
     */
    public function settingsAction(Request $request)
    {
        $feeParkEastAfrican = $this->getEm()->getRepository(CalculationSettingFeeParkEastAfrican::class)->findAll();
        $feeParkForeigner = $this->getEm()->getRepository(CalculationSettingFeeParkForeigner::class)->findAll();
        $feeCrater = $this->getEm()->getRepository(CalculationSettingFeeCrater::class)->findAll();
        $carRental = $this->getEm()->getRepository(CalculationSettingCarRental::class)->findAll();
        $transfers = $this->getEm()->getRepository(CalculationSettingTransfer::class)->findAll();
        $others = $this->getEm()->getRepository(CalculationSettingOther::class)->findAll();

        $previousCollectionData = [
            'feeParkEastAfrican' => $feeParkEastAfrican,
            'feeParkForeigner' => $feeParkForeigner,
            'feeCrater' => $feeCrater,
            'carRental' => $carRental,
            'transfers' => $transfers,
            'others' => $others,
        ];

        $tshToUsd = $this->getEm()->getRepository(CalculationSettingCurrencyRate::class)->getLastRate(CalculationSettingCurrencyRate::CURRENCY_TSH, CalculationSettingCurrencyRate::CURRENCY_USD);
        if (!$tshToUsd) {
            $tshToUsd = new CalculationSettingCurrencyRate();
            $tshToUsd
                ->setCurrencyFrom(CalculationSettingCurrencyRate::CURRENCY_TSH)
                ->setCurrencyTo(CalculationSettingCurrencyRate::CURRENCY_USD)
            ;
        }
        $previousCurrencyData = [
            'tshToUsd' => clone $tshToUsd,
        ];
        $currencyRates = [
            'currencyRates' => [
                'tshToUsd' => $tshToUsd,
            ],
        ];

        $data = array_merge_recursive($previousCollectionData, $currencyRates);
        $form = $this->createForm(CalculationSettingsForm::class, null, $data);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                try {
                    foreach ($form->getData() as $name => $collection) {
                        if (\array_key_exists($name, $previousCollectionData)) {
                            $this->refreshCollection($previousCollectionData[$name], $collection);
                        }
                    }
                    foreach ($form->get('currencyRates')->getData() as $name => $currencyRate) {
                        if (\array_key_exists($name, $previousCurrencyData)) {
                            $this->refreshCurrencyRate($previousCurrencyData[$name], $currencyRate);
                        }
                    }

                    $this->getEm()->flush();
                    $this->addFlash('form_success', 'success');
                } catch (\Exception $exception) {
                    $this->getLogger()->error($exception->getMessage(), ['exception' => $exception]);
                    $this->addFlash('form_success', 'error');
                }
            } else {
                $this->addFlash('form_success', 'error');
            }
        }

        return $this->render('@AltezzaTravel/tour/calculation/settings.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function domesticFlightListAction(Request $request)
    {
        $qb = $this->getEm()->getRepository(CalculationSettingDomesticFlight::class)
            ->createQueryBuilder('calculationSettingDomesticFlight')
            ->orderBy('calculationSettingDomesticFlight.createdAt', 'asc')
        ;

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $qb,
            $request->query->getInt('page', 1),
            $this->getParameter('page_range')
        );

        return $this->render('@AltezzaTravel/tour/calculation/settings.domesticFlight.list.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * @param Request                               $request
     * @param CalculationSettingDomesticFlight|null $flight
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @throws OptimisticLockException
     */
    public function domesticFlightEditAction(Request $request, CalculationSettingDomesticFlight $flight = null)
    {
        if (!$flight) {
            $flight = new CalculationSettingDomesticFlight();
        }

        $form = $this->createForm(CalculationSettingDomesticFlightForm::class, $flight);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                if (!$flight->getId()) {
                    $this->getEm()->persist($flight);
                }

                $this->getEm()->flush();
                $this->addFlash('form_success', 'success');

                return $this->redirectToRoute('tour_calculation_settings_domestic_flight_edit', [
                    'flight' => $flight->getId(),
                ]);
            }

            $this->addFlash('form_success', 'error');
        }

        return $this->render('@AltezzaTravel/tour/calculation/settings.domesticFlight.edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param CalculationSettingDomesticFlight $flight
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Exception
     */
    public function domesticFlightRemoveAction(CalculationSettingDomesticFlight $flight)
    {
        try {
            $this->getEm()->remove($flight);
            $this->getEm()->flush();
        } catch (\Exception $exception) {
            $this->getLogger()->error($exception->getMessage(), ['exception' => $exception]);
            $this->addFlash('error', 'Error! Try remove domestic flight again.');
        }

        return $this->redirect($this->generateUrl('tour_calculation_settings_domestic_flight_list'));
    }

    /**
     * @param CalculationSettingCurrencyRate $previousCurrencyRate
     * @param CalculationSettingCurrencyRate $submittedCurrencyRate
     */
    private function refreshCurrencyRate(CalculationSettingCurrencyRate $previousCurrencyRate, CalculationSettingCurrencyRate $submittedCurrencyRate)
    {
        if ($previousCurrencyRate->getHash() !== $submittedCurrencyRate->getHash()) {
            $currencyRate = new CalculationSettingCurrencyRate();
            $currencyRate
                ->setCurrencyFrom($submittedCurrencyRate->getCurrencyFrom())
                ->setValueFrom($submittedCurrencyRate->getValueFrom())
                ->setCurrencyTo($submittedCurrencyRate->getCurrencyTo())
                ->setValueTo($submittedCurrencyRate->getValueTo())
                ->setRate($currencyRate->getValueTo()/$currencyRate->getValueFrom())
            ;

            $this->getEm()->refresh($submittedCurrencyRate);
            $this->getEm()->persist($currencyRate);
        }
    }

    /**
     * @param array $previous
     * @param array $submitted
     */
    private function refreshCollection($previous, $submitted)
    {
        $previousCollection = new ArrayCollection($previous);
        $submittedCollection = new ArrayCollection($submitted);

        foreach ($previous as $entity) {
            if (!$submittedCollection->contains($entity)) {
                $this->getEm()->remove($entity);
            }
        }

        foreach ($submitted as $entity) {
            if (!$previousCollection->contains($entity)) {
                $this->getEm()->persist($entity);
            }
        }
    }
}
