<?php

namespace AltezzaTravelBundle\Controller\Tour;

use AltezzaTravelBundle\Controller\AbstractController;
use AltezzaTravelBundle\Entity\Calculation;
use AltezzaTravelBundle\Entity\Hotel;
use AltezzaTravelBundle\Entity\HotelRoom;
use AltezzaTravelBundle\Entity\TerritorialPark;
use AltezzaTravelBundle\Entity\TypeAccommodation;
use AltezzaTravelBundle\Entity\TypeMealPlan;
use AltezzaTravelBundle\Entity\TypeRoom;
use AltezzaTravelBundle\Form\Tour\CalculationStepOneForm;
use AltezzaTravelBundle\Form\Tour\CalculationStepThirdOurCommissionPopupForm;
use AltezzaTravelBundle\Form\Tour\CalculationStepThirdPopupForm;
use AltezzaTravelBundle\Form\Tour\CalculationStepTwoForm;
use AltezzaTravelBundle\Helper\CalculationHelper;
use AltezzaTravelBundle\Helper\HotelRoomHelper;
use AltezzaTravelBundle\Service\CalculationService;
use AltezzaTravelBundle\Service\ChromiumService;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\OptimisticLockException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Class CalculatorController
 * @package AltezzaTravelBundle\Controller\Tour
 */
class CalculatorController extends AbstractController
{
    const ZANZIBAR_LOCATION = 'Zanzibar';

    /** @var CalculationService $calculationService */
    private $calculationService;

    /** @var CalculationHelper $calculationHelper */
    private $calculationHelper;

    /** @var HotelRoomHelper $hotelRoomHelper */
    private $hotelRoomHelper;

    /** @var ChromiumService $chromiumService */
    private $chromiumService;

    /**
     * CalculatorController constructor.
     * @param CalculationService $calculationService
     * @param CalculationHelper  $calculationHelper
     * @param HotelRoomHelper    $hotelRoomHelper
     * @param ChromiumService    $chromiumService
     */
    public function __construct(
        CalculationService $calculationService,
        CalculationHelper $calculationHelper,
        HotelRoomHelper $hotelRoomHelper,
        ChromiumService $chromiumService
    ) {
        $this->calculationService = $calculationService;
        $this->calculationHelper = $calculationHelper;
        $this->hotelRoomHelper = $hotelRoomHelper;
        $this->chromiumService = $chromiumService;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function draftListAction(Request $request)
    {
        $qb = $this->getEm()->getRepository(Calculation::class)
            ->createQueryBuilder('calculation')
            ->where('calculation.status = :status')
            ->orderBy('calculation.createdAt', 'asc')
            ->setParameter('status', Calculation::CALCULATION_STATUS_DRAFT)
        ;

        if ($search = $request->get('search', null)) {
            $qb
                ->andWhere($qb->expr()->like('calculation.title', ':search'))
                ->setParameter('search', "%{$search}%")
            ;
        }

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $qb,
            $request->query->getInt('page', 1),
            $this->getParameter('page_range')
        );

        return $this->render('@AltezzaTravel/tour/calculation/list.draft.html.twig', [
            'pagination' => $pagination,
            'search' => $search,
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function templateListAction(Request $request)
    {
        $qb = $this->getEm()->getRepository(Calculation::class)
            ->createQueryBuilder('calculation')
            ->where('calculation.status = :status')
            ->orderBy('calculation.createdAt', 'asc')
            ->setParameter('status', Calculation::CALCULATION_STATUS_TEMPLATE)
        ;

        if ($search = $request->get('search', null)) {
            $qb
                ->andWhere($qb->expr()->like('calculation.title', ':search'))
                ->setParameter('search', "%{$search}%")
            ;
        }

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $qb,
            $request->query->getInt('page', 1),
            $this->getParameter('page_range')
        );

        return $this->render('@AltezzaTravel/tour/calculation/list.template.html.twig', [
            'pagination' => $pagination,
            'search' => $search,
        ]);
    }

    /**
     * @param Request          $request
     * @param Calculation|null $calculation
     * @return RedirectResponse|Response
     * @throws \Exception
     */
    public function stepFirstAction(Request $request, Calculation $calculation = null)
    {
        if (!$calculation) {
            $calculation = new Calculation();
        }

        $form = $this->createForm(CalculationStepOneForm::class, $calculation);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                try {
                    if (!$calculation->getId()) {
                        $this->getEm()->persist($calculation);
                    }

                    $this->getEm()->flush();
                    $this->addFlash('form_success', 'success');

                    return $this->redirectToRoute('tour_calculation_step_two', [
                        'calculation' => $calculation->getId(),
                    ]);
                } catch (\Exception $exception) {
                    $this->getLogger()->error($exception->getMessage(), ['exception' => $exception]);
                    $this->addFlash('form_success', 'error');
                }
            } else {
                $this->addFlash('form_success', 'error');
            }
        }

        return $this->render('@AltezzaTravel/tour/calculation/step_first.html.twig', [
            'form' => $form->createView(),
            'calculation' => $calculation,
        ]);
    }

    /**
     * @param Request     $request
     * @param Calculation $calculation
     * @return RedirectResponse|Response
     * @throws \Exception
     */
    public function stepSecondAction(Request $request, Calculation $calculation)
    {
        $form = $this->createForm(CalculationStepTwoForm::class, $calculation);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                try {
                    $this->getEm()->flush();
                    $this->addFlash('form_success', 'success');

                    return $this->redirectToRoute('tour_calculation_step_three', [
                        'calculation' => $calculation->getId(),
                    ]);
                } catch (\Exception $exception) {
                    $this->getLogger()->error($exception->getMessage(), ['exception' => $exception]);
                    $this->addFlash('form_success', 'error');
                }
            } else {
                $this->addFlash('form_success', 'error');
            }
        }

        $hotels = $this->getEm()->getRepository(Hotel::class)->getEnabledListQB('hotel')
            ->select('hotel.id', 'hotel.title', 'location.title as locationTitle')
            ->innerJoin('hotel.location', 'location')
            ->getQuery()
            ->getScalarResult();

        $safariHotels = array_filter($hotels, function ($hotel) {
            return $hotel['locationTitle'] !== self::ZANZIBAR_LOCATION;
        });
        $zanzibarHotels = array_filter($hotels, function ($hotel) {
            return $hotel['locationTitle'] === self::ZANZIBAR_LOCATION;
        });

        $safariParks = $this->getEm()->getRepository(TerritorialPark::class)
            ->createQueryBuilder('tp')
            ->select('tp.id', 'tp.title')
            ->getQuery()
            ->getScalarResult();

        $nightsCount = $calculation->getDateInterval()->format('%a');
        $nights = array_keys(array_fill(1, $nightsCount, true));

        $safariDays = $this->calculationHelper->transformSafariDays($calculation);
        $safariNights = $this->calculationHelper->transformSafariNights($calculation);
        $zanzibarNights = $this->calculationHelper->transformZanzibarNights($calculation);

        return $this->render('@AltezzaTravel/tour/calculation/step_second.html.twig', [
            'calculation' => $calculation,
            'form' => $form->createView(),
            'hotels' => $hotels,
            'safariHotels' => $safariHotels,
            'zanzibarHotels' => $zanzibarHotels,
            'nights' => $nights,
            'safariParks' => $safariParks,
            'safariDays' => $safariDays,
            'safariNights' => $safariNights,
            'zanzibarNights' => array_values($zanzibarNights),
        ]);
    }

    /**
     * @param Request     $request
     * @param Calculation $calculation
     * @return Response
     */
    public function stepThirdAction(Request $request, Calculation $calculation)
    {
        $popupTemplateNameForm = $this->createForm(CalculationStepThirdPopupForm::class, $calculation);
        $popupOurCommissionForm = $this->createForm(CalculationStepThirdOurCommissionPopupForm::class, $calculation);

        $popupTemplateNameForm->handleRequest($request);
        $popupOurCommissionForm->handleRequest($request);

        $forms = [
            $popupTemplateNameForm,
            $popupOurCommissionForm,
        ];

        foreach ($forms as $form) {
            if ($form->isSubmitted()) {
                if ($form->isValid()) {
                    try {
                        $this->getEm()->flush();

                        return $this->redirectToRoute('tour_calculation_step_three', [
                            'calculation' => $calculation->getId(),
                        ]);
                    } catch (\Exception $exception) {
                        $this->getLogger()->error($exception->getMessage(), ['exception' => $exception]);
                        $this->addFlash('form_success', 'error');

                        return $this->redirectToRoute('tour_calculation_step_three', [
                            'calculation' => $calculation->getId(),
                        ]);
                    }
                } else {
                    $this->addFlash('form_success', 'error');
                }
            }
        }

        $summary = $this->calculationService->calculateSummary($calculation);

        return $this->render('@AltezzaTravel/tour/calculation/step_third.html.twig', [
            'calculation' => $calculation,
            'popupTemplateNameForm' => $popupTemplateNameForm->createView(),
            'popupOurCommissionForm' => $popupOurCommissionForm->createView(),
            'summary' => $summary,
        ]);
    }


    /**
     * @param Request     $request
     * @param Calculation $calculation
     * @return Response
     */
    public function pdfAction(Request $request, Calculation $calculation)
    {
        if ($this->container->has('profiler')) {
            $this->container->get('profiler')->disable();
        }

        $summary = $this->calculationService->calculateSummary($calculation);


        if ($request->get('print', false)) {
            return $this->render('@AltezzaTravel/tour/calculation/step_third.pdf.twig', [
                'calculation' => $calculation,
                'summary' => $summary,
            ]);
        }

        try {
            $pdf = $this->chromiumService->generatePdf($this->generateUrl('tour_calculation_generate_pdf', [
                'calculation' => $calculation->getId(),
                'print' => true,
            ], UrlGeneratorInterface::ABSOLUTE_URL));

            return new Response(
                $pdf,
                200,
                [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => sprintf('attachment; filename="calculation-%s.pdf"', $calculation->getId()),
                ]
            );
        } catch (\Exception $exception) {
            $this->getLogger()->error($exception->getMessage(), ['exception' => $exception]);
            throw $exception;
        }
    }

    /**
     * @param Calculation $calculation
     * @return RedirectResponse
     */
    public function removeAction(Calculation $calculation)
    {
        switch ($calculation->getStatus()) {
            case Calculation::CALCULATION_STATUS_DRAFT:
                $referer = $this->generateUrl('tour_calculation_drafts');
                break;
            case Calculation::CALCULATION_STATUS_TEMPLATE:
            default:
                $referer = $this->generateUrl('tour_calculation_templates');
        }

        try {
            $this->getEm()->remove($calculation);
            $this->getEm()->flush();
        } catch (OptimisticLockException $exception) {
            $this->getLogger()->error($exception->getMessage(), ['exception' => $exception]);
            $this->addFlash('error', 'Error! Try remove calculation again.');
        }

        return $this->redirect($referer);
    }

    /**
     * @param Request     $request
     * @param Calculation $calculation
     * @return JsonResponse
     */
    public function ajaxRequestAction(Request $request, Calculation $calculation)
    {
        $result = [];

        $hotel = $request->get('hotel', null);
        $mealPlan = $request->get('mealPlan', null);
        $roomType = $request->get('roomType', null);
        $accommodations = $request->get('roomAccommodations', null);
        $roomSlug = $request->get('roomSlug', null);

        $result = [
            'success' => true,
            'data' => [],
        ];

        try {
            /** @var Hotel $hotel */
            $hotel = $this->getEm()->getRepository(Hotel::class)->find($hotel);

            $adultCount = $calculation->getAdultPersons()->first()->getCount();
            $teenagerCount = 0;
            $childCount = 0;

            foreach ($calculation->getChildPersons() as $person) {
                if ($hotel->getChildTo() >= $person->getAge()) {
                    $childCount++;
                    continue;
                }
                if ($hotel->getTeenagerFrom() <= $person->getAge() && $hotel->getTeenagerTo() >= $person->getAge()) {
                    $teenagerCount++;
                    continue;
                }
                $adultCount++;
            }

            $mealPlans = $hotel->getMealPlans();
            $result['data']['mealPlans'] = $mealPlans->map(function (TypeMealPlan $mealPlan) {
                return [
                    'type' => $mealPlan->getType(),
                    'title' => $mealPlan->getTitle(),
                ];
            })->toArray();

            $roomTypes = $hotel->getRoomTypes();
            $result['data']['roomTypes'] = $roomTypes->map(function (TypeRoom $roomType) {
                return [
                    'type' => $roomType->getType(),
                    'shortName' => $roomType->getShortName(),
                ];
            })->toArray();

            /** @var TypeRoom $roomType */
            $roomType = $this->getEm()->getRepository(TypeRoom::class)->find($roomType);
            if (!$roomType || !$roomTypes->contains($roomType)) {
                $roomType = !$hotel->getRooms()->isEmpty() ? $hotel->getRooms()->first()->getRoomType() : null;
            }

            $rooms = new ArrayCollection();
            $accommodations = new ArrayCollection();

            if ($roomSlug) {
                $roomSlug = $this->getEm()->getRepository(HotelRoom::class)->find($roomSlug)->getSlug(true);
            }

            if ($roomType) {
                $rooms = $hotel->getRoomsByType($roomType);
                if (!$roomSlug && !$rooms->isEmpty()) {
                    $roomSlug = $rooms->first()->getSlug(true);
                }

                $roomsBySlug = $rooms->filter(function (HotelRoom $room) use ($roomSlug) {
                    if (!$roomSlug) {
                        return true;
                    }

                    return $room->getSlug(true) === $roomSlug;
                });

                /** @var HotelRoom $room */
                foreach ($roomsBySlug as $room) {
                    $roomAccommodations = $room->getAccommodations()->filter(function (TypeAccommodation $typeAccommodation) use (
                        $adultCount, $teenagerCount, $childCount
                    ) {
                        return true;

                        // @TODO check count pax
                        if ($typeAccommodation->getCountAdult() >= $adultCount
                            && $typeAccommodation->getCountTeenager() >= $teenagerCount
                            && $typeAccommodation->getCountChild() >= $childCount
                        ) {
                            return true;
                        }

                        if ($typeAccommodation->getCountAdult() >= $adultCount
                            && $typeAccommodation->getCountTeenager() >= ($teenagerCount + $childCount)
                        ) {
                            return true;
                        }
                        if ($typeAccommodation->getCountAdult() >= ($adultCount + $teenagerCount + $childCount)) {
                            return true;
                        }

                        return false;
                    });

                    foreach ($roomAccommodations as $roomAccommodation) {
                        if (!$accommodations->contains($roomAccommodation)) {
                            $accommodations->add($roomAccommodation);
                        }
                    }
                }
            }

            $result['data']['roomAccommodations'] = $accommodations->map(function (TypeAccommodation $accommodation) {
                return [
                    'type' => $accommodation->getType(),
                    'child' => $accommodation->getCountChild(),
                    'teenager' => $accommodation->getCountTeenager(),
                    'adult' => $accommodation->getCountAdult(),
                ];
            })->toArray();

            $result['data']['roomSlugs'] = $this->hotelRoomHelper->getRoomSlugs($rooms, false, true, true);
        } catch (\Exception $exception) {
            $this->getLogger()->error($exception->getMessage(), ['exception' => $exception]);

            $result = [
                'success' => false,
                'message' => 'Something error.',
                'error' => $exception->getMessage(),
            ];
        }

        return new JsonResponse($result);
    }
}
