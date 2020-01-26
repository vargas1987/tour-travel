<?php

namespace AltezzaTravelBundle\Controller\Tour;

use AltezzaTravelBundle\Controller\AbstractController;
use AltezzaTravelBundle\Entity\CalculationSettings\CalculationSettingCurrencyRate;
use AltezzaTravelBundle\Entity\Settings\TransferTerritorial;
use AltezzaTravelBundle\Form\Tour\CalculationSettingsForm;
use AltezzaTravelBundle\Form\Tour\SettingsTransferTerritorialForm;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CalculationSettingsController
 * @package AltezzaTravelBundle\Controller\Tour
 */
class SettingsController extends AbstractController
{
    /**
     * @param Request $request
     * @return Response
     */
    public function transferTerritorialAction(Request $request)
    {
        $transfersTerritorial = $this->getEm()->getRepository(TransferTerritorial::class)->findAll();

        $previousCollectionData = [
            'transferTerritorial' => $transfersTerritorial,
        ];

        $form = $this->createForm(SettingsTransferTerritorialForm::class, null, $previousCollectionData);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                try {
                    foreach ($form->getData() as $name => $collection) {
                        if (\array_key_exists($name, $previousCollectionData)) {
                            $this->refreshCollection($previousCollectionData[$name], $collection);
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

        return $this->render('@AltezzaTravel/tour/settings/transfer_territorial.html.twig', [
            'form' => $form->createView(),
        ]);
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