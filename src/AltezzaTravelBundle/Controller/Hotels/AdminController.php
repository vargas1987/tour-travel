<?php

namespace AltezzaTravelBundle\Controller\Hotels;

use AltezzaTravelBundle\Controller\AbstractController;
use AltezzaTravelBundle\Entity\Hotel;
use AltezzaTravelBundle\Entity\HotelPrice;
use AltezzaTravelBundle\Entity\HotelRoom;
use AltezzaTravelBundle\Entity\HotelSeason;
use AltezzaTravelBundle\Entity\HotelSeasonType;
use AltezzaTravelBundle\Entity\HotelYearsOptions;
use AltezzaTravelBundle\Entity\TerritorialAirstrip;
use AltezzaTravelBundle\Entity\TerritorialArea;
use AltezzaTravelBundle\Entity\TerritorialLocation;
use AltezzaTravelBundle\Entity\TypeRoom;
use AltezzaTravelBundle\Exception\HotelCopyException;
use AltezzaTravelBundle\Form\Hotels\HotelForm;
use AltezzaTravelBundle\Form\Hotels\HotelPricesCopyRatesForm;
use AltezzaTravelBundle\Form\Hotels\HotelPricesForm;
use AltezzaTravelBundle\Form\Hotels\HotelRoomsForm;
use AltezzaTravelBundle\Form\Hotels\HotelSeasonsForm;
use AltezzaTravelBundle\Form\Hotels\HotelSeasonTypeForm;
use AltezzaTravelBundle\Service\HotelService;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\OptimisticLockException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AdminController extends AbstractController
{
    /**
     * @param Request $request
     * @return Response
     */
    public function listHotelAction(Request $request)
    {
        $select_location = $request->get('select_location', false);
        $search = $request->get('search', false);

        $options = $this->getEm()->getRepository(TerritorialLocation::class)->findAll();
        $repository = $this->getDoctrine()->getRepository(Hotel::class);
        $queryBuilder = $repository->createQueryBuilder('h');

        if ($search || $select_location) {
            $queryBuilder = $repository->searchHotel($select_location, $search);
        }

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $queryBuilder,
            $request->query->getInt('page', 1),
            $this->getParameter('page_range'),
            [
                'defaultSortFieldName' => ['h.title'],
                'defaultSortDirection' => 'asc',
            ]
        );

        return $this->render('@AltezzaTravel/hotels/list.html.twig', [
            'options' => $options,
            'select_location' => $select_location,
            'search' => $search,
            'pagination' => $pagination,
            'filter' => !empty($search) || !empty($select_location),
        ]);
    }

    /**
     * @param Request    $request
     * @return RedirectResponse|Response
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function addHotelAction(Request $request)
    {
        $hotel = new Hotel();

        $form = $this->createForm(HotelForm::class, $hotel);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $this->getEm()->persist($hotel);
                $this->getEm()->flush();
                $this->addFlash('form_success', 'success');

                return $this->redirectToRoute('hotels_edit', [
                    'hotel' => $hotel->getId(),
                ]);
            }

            $this->addFlash('form_success', 'error');
        }

        return $this->render('@AltezzaTravel/hotels/add.html.twig', [
            'hotel' => $hotel,
            'form' => $form->createView(),
            'errors' => $form->getErrors(),
        ]);
    }

    /**
     * @param Request    $request
     * @param Hotel|null $hotel
     * @return RedirectResponse|Response
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function editHotelAction(Request $request, Hotel $hotel)
    {
        $form = $this->createForm(HotelForm::class, $hotel);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $this->getEm()->flush();
                $this->addFlash('form_success', 'success');

                return $this->redirectToRoute('hotels_edit', [
                    'hotel' => $hotel->getId(),
                ]);
            }

            $this->addFlash('form_success', 'error');
        }

        return $this->render('@AltezzaTravel/hotels/add.html.twig', [
            'hotel' => $hotel,
            'form' => $form->createView(),
            'errors' => $form->getErrors(),
        ]);
    }

    /**
     * @param Request $request
     * @param Hotel   $hotel
     * @return RedirectResponse
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function removeHotelAction(Request $request, Hotel $hotel)
    {
        try {
            $this->getEm()->remove($hotel);
            $this->getEm()->flush();
        } catch (OptimisticLockException $exception) {
            $this->addFlash('error', 'Error! Try remove hotel again.');

            $this->redirectToRoute('hotels_edit', [
                'hotel' => $hotel->getId(),
            ]);
        }

        return $this->redirectToRoute('hotels_list');
    }

    /**
     * @param Request $request
     * @param Hotel   $hotel
     * @return RedirectResponse|Response|\Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function editRoomAction(Request $request, Hotel $hotel)
    {
        $roomTypes = $this->getEm()->getRepository(TypeRoom::class)->findBy([], ['sort' => 'ASC']);

        $formRoomTypes = [];
        foreach ($roomTypes as $roomType) {
            /** @var TypeRoom $roomType */
            $roomTypeSlug = preg_replace_callback('/_([a-z])/', function ($part) {
                return strtoupper($part[1]);
            }, sprintf('%s_rooms', $roomType->getType()));

            $formRoomTypes[$roomTypeSlug] = $roomType;
        }

        $form = $this->createForm(HotelRoomsForm::class, $hotel, [
            'room_types' => $formRoomTypes,
        ]);

        /** @var HotelRoom[]|ArrayCollection $preSubmittedRooms */
        $preSubmittedRooms = [];
        foreach ($formRoomTypes as $roomTypeSlug => $roomType) {
            $preSubmittedRooms = array_merge_recursive(
                $preSubmittedRooms,
                $form->get($roomTypeSlug)->getData()->toArray()
            );
        }
        $preSubmittedRooms = new ArrayCollection($preSubmittedRooms);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {

                $postSubmittedRooms = [];
                foreach ($formRoomTypes as $roomTypeSlug => $roomType) {
                    $postSubmittedRooms = array_merge_recursive(
                        $postSubmittedRooms,
                        $form->get($roomTypeSlug)->getData()->toArray()
                    );
                }
                $postSubmittedRooms = new ArrayCollection($postSubmittedRooms);

                foreach ($preSubmittedRooms as $formRoom) {
                    $hotel->removeRoom($formRoom);
                    if (!$postSubmittedRooms->contains($formRoom)) {
                        $this->getEm()->remove($formRoom);
                    }
                }

                foreach ($postSubmittedRooms as $formRoom) {
                    $hotel->addRoom($formRoom);
                }

                $this->getEm()->flush();
                $this->addFlash('form_success', 'success');

                return $this->redirectToRoute('hotels_rooms_edit', [
                    'hotel' => $hotel->getId(),
                ]);
            }

            $this->addFlash('form_success', 'error');
        }

        return $this->render('@AltezzaTravel/hotels/rooms.html.twig', [
            'hotel' => $hotel,
            'formRoomTypes' => $formRoomTypes,
            'form' => $form->createView(),
            'errors' => $form->getErrors(),
        ]);
    }

    /**
     * @param Request $request
     * @param Hotel   $hotel
     * @param integer $year
     * @return RedirectResponse|Response|\Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function editSeasonAction(Request $request, Hotel $hotel)
    {
        $seasonTypeForm = $this->createForm(HotelSeasonTypeForm::class, $hotel, []);

        /** @var HotelSeasonType[]|ArrayCollection $formSeasons */
        $formSeasonTypes = $seasonTypeForm->get('hotelSeasonTypes')->getData()->toArray();

        if ($request->isXmlHttpRequest()) {
            $seasonTypeForm->handleRequest($request);

            $status = 'error';
            if ($seasonTypeForm->isSubmitted() && $seasonTypeForm->isValid()) {
                /** @var HotelSeasonType[]|ArrayCollection $submittedSeasonTypes */
                $submittedSeasonTypes = $seasonTypeForm->get('hotelSeasonTypes')->getData();

                foreach ($formSeasonTypes as $formSeasonType) {
                    $hotel->removeHotelSeasonType($formSeasonType);
                    if (!$submittedSeasonTypes->contains($formSeasonType)) {
                        $this->getEm()->remove($formSeasonType);
                    }
                }

                foreach ($submittedSeasonTypes as $submittedSeasonType) {
                    $hotel->addHotelSeasonType($submittedSeasonType);
                }

                $this->getEm()->flush();
                $status = 'ok';
            }

            $seasonTypes = $hotel->getHotelSeasonTypes()->map(function ($hotelSeasonType) {
                /** @var HotelSeasonType $hotelSeasonType */
                return [
                    'type' => $hotelSeasonType->getSeasonType()->getType(),
                    'title' => $hotelSeasonType->getSeasonType()->getTitle()
                ];
            });

            $seasonForm = $this->createForm(HotelSeasonsForm::class, $hotel, []);

            return new JsonResponse([
                'errors' => $seasonTypeForm->getErrors(),
                'status' => $status,
                'season_type_form' => $this->renderView('@AltezzaTravel/hotels/_partial/_form/_hotel_season_type_form.html.twig', [
                    'hotel' => $hotel,
                    'form' => $seasonTypeForm->createView(),
                    'errors' => $seasonTypeForm->getErrors(),
                ]),
                'season_form_prototype' => $this->renderView('@AltezzaTravel/hotels/_partial/_form/_hotel_season_prototype.html.twig', [
                    'hotel' => $hotel,
                    'form' => $seasonForm->createView()->children['seasons']->vars['prototype'],
                    'errors' => $seasonForm->getErrors(),
                ]),
                'season_types' => $seasonTypes->toArray(),
            ]);
        }

        $seasonForm = $this->createForm(HotelSeasonsForm::class, $hotel, []);
        /** @var HotelSeason[]|ArrayCollection $formSeasons */
        $formSeasons = $seasonForm->get('seasons')->getData()->toArray();

        $seasonForm->handleRequest($request);

        if ($seasonForm->isSubmitted()) {
            if ($seasonForm->isValid()) {
                /** @var HotelSeason[]|ArrayCollection $submittedSeasons */
                $submittedSeasons = $seasonForm->get('seasons')->getData();

                foreach ($formSeasons as $formSeason) {
                    $hotel->removeSeason($formSeason);
                    if (!$submittedSeasons->contains($formSeason)) {
                        $this->getEm()->remove($formSeason);
                    }
                }

                foreach ($submittedSeasons as $submittedSeason) {
                    $hotel->addSeason($submittedSeason);
                }

                $this->getEm()->flush();

                $this->addFlash('form_success', 'success');

                return $this->redirectToRoute('hotels_seasons_edit', [
                    'hotel' => $hotel->getId(),
                ]);
            }

            $this->addFlash('form_success', 'error');
        }

        return $this->render('@AltezzaTravel/hotels/seasons.html.twig', [
            'hotel' => $hotel,
            'seasonTypeForm' => $seasonTypeForm->createView(),
            'form' => $seasonForm->createView(),
            'errors' => $seasonForm->getErrors(),
        ]);
    }

    /**
     * @param Request $request
     * @param Hotel   $hotel
     * @return JsonResponse|NotFoundHttpException
     */
    public function yearsHotelListAction(Request $request, Hotel $hotel)
    {
        if (!$request->isXmlHttpRequest()) {
            return $this->createNotFoundException();
        }

        $yearsList = $hotel->getYearsList(false, false);

        return new JsonResponse([
            'status' => true,
            'result' => $yearsList,
        ]);
    }

    /**
     * @param Request $request
     * @param Hotel   $hotel
     * @param int     $year
     * @return JsonResponse|RedirectResponse
     * @throws OptimisticLockException
     */
    public function copyPricesRatesAction(Request $request, Hotel $hotel, int $year)
    {
        $form = $this->createForm(HotelPricesCopyRatesForm::class, null, [
            'method' => 'post',
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Hotel $fromHotel */
            $fromHotel = $form->get('hotel')->getData();
            $fromYear = $form->get('year')->getData();

            $yearsList = $fromHotel->getYearsList(false, false);

            if (!\in_array($fromYear, $yearsList)) {
                return new JsonResponse([
                    'status' => false,
                    'message' => 'Choice year are not exist by this hotel',
                ]);
            }

            /** @var HotelService $hotelService */
            $hotelService = $this->get(HotelService::class);

            $this->getEm()->beginTransaction();

            try {
                if ($hotel->getId() !== $fromHotel->getId()) {
                    $hotelService->copySeasonsByHotelAndYear($hotel, $year, $fromHotel, $fromYear);
                }

                $hotelService->copyPriceAdditionalFeesByHotelAndYear($hotel, $year, $fromHotel, $fromYear);
                $hotelService->copyPriceSupplementsByHotelAndYear($hotel, $year, $fromHotel, $fromYear);

                $this->getEm()->flush();
                $this->getEm()->commit();
                $this->getEm()->clear(Hotel::class);
                $hotel = $this->getEm()->getRepository(Hotel::class)->find($hotel->getId());
            } catch (HotelCopyException $exception) {
                $this->getEm()->rollback();

                return new JsonResponse([
                    'status' => false,
                    'message' => $exception->getMessage(),
                ]);
            } catch (\Exception $exception) {
                $this->getEm()->rollback();
                $this->get('logger')->addError($exception->getMessage(), ['exception' => $exception]);

                return new JsonResponse([
                    'status' => false,
                    'message' => 'Sorry! Some error on copy rates.',
                ]);
            }

            $result = [];

            $hotelYearsOptions = $this->getEm()->getRepository(HotelYearsOptions::class)->findBy([
                'hotel' => $fromHotel,
                'year' => $fromYear,
            ]);
            $hotelPrices = $this->getEm()->getRepository(HotelPrice::class)->findBy([
                'hotel' => $fromHotel,
                'year' => $fromYear,
            ]);

            $result['rates'] = array_map(function (HotelYearsOptions $hotelYearOption) {
                return [
                    'slug' => $hotelYearOption->getSlug(),
                    'value' => $hotelYearOption->getValue(),
                ];
            }, $hotelYearsOptions);

            $result['prices'] = array_map(function (HotelPrice $hotelPrice) {
                return [
                    'room' => $hotelPrice->getRoom()->getId(),
                    'accommodation' => $hotelPrice->getAccommodationType()->getType(),
                    'season' => $hotelPrice->getSeasonType()->getType(),
                    'mealPlan' => $hotelPrice->getMealPlanType()->getType(),
                    'value' => $hotelPrice->getPrice(),
                ];
            }, $hotelPrices);

            $result['template'] = $this->renderView(
                '@AltezzaTravel/hotels/_partial/hotel_prices.html.twig',
                $this->editPricesAction($request, $hotel, $year, true)
            );

            return new JsonResponse([
                'status' => true,
                'result' => $result,
            ]);
        }

        return $this->redirectToRoute('hotels_prices_edit', [
            'hotel' => $hotel->getId(),
            'year' => $year,
        ]);
    }

    /**
     * @param Request $request
     * @param Hotel   $hotel
     * @param integer $year
     * @param boolean $isCopyRates
     * @return RedirectResponse|Response|array
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function editPricesAction(Request $request, Hotel $hotel, int $year = null, $isCopyRates = false)
    {
        if (!$year) {
            $year = $request->get('year', date('Y'));
        }

        $roomTypesQB = $this->getEm()->getRepository(TypeRoom::class)->getAllSortedQB();

        $roomTypes = $roomTypesQB->getQuery()->getResult();

        $form = $this->createForm(HotelPricesForm::class, $hotel, [
            'year' => $year,
        ]);

        /** @var HotelSeason[]|ArrayCollection $formSeasons */
        $formPriceAdditionalFees = $form->get('priceAdditionalFees')->getData();
        $this->filterFormDataByYear($formPriceAdditionalFees, $year);
        $form->get('priceAdditionalFees')->setData($formPriceAdditionalFees);

        $formPriceSupplements = $form->get('priceSupplements')->getData();
        $this->filterFormDataByYear($formPriceSupplements, $year);
        $form->get('priceSupplements')->setData($formPriceSupplements);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $submittedPriceAdditionalFees = $form->getData()->getPriceAdditionalFees();
                foreach ($formPriceAdditionalFees as $formPriceAdditionalFee) {
                    if (!$submittedPriceAdditionalFees->contains($formPriceAdditionalFee)) {
                        $this->getEm()->remove($formPriceAdditionalFee);
                    }
                }

                $submittedPriceSupplements = $form->getData()->getPriceSupplements();
                foreach ($formPriceSupplements as $formPriceSupplement) {
                    if (!$submittedPriceSupplements->contains($formPriceSupplement)) {
                        $this->getEm()->remove($formPriceSupplement);
                    }
                }

                $this->getEm()->flush();
                $this->addFlash('form_success', 'success');

                return $this->redirectToRoute('hotels_prices_edit', [
                    'hotel' => $hotel->getId(),
                    'year' => $year,
                ]);
            }

            $this->addFlash('form_success', 'error');
        }

        $hotelList = $this->getEm()->getRepository(Hotel::class)->findAllSorted();

        $copyRatesForm = $this->createForm(HotelPricesCopyRatesForm::class);

        $params = [
            'hotel' => $hotel,
            'hotelList' => $hotelList,
            'year' => $year,
            'additionalPersonOptions' => HotelYearsOptions::getPriceAdditionalPersonOptions($hotel->isTeenageRangeInit()),
            'mealPlanPersonOptions' => HotelYearsOptions::getPriceMealPlanPersonOptions($hotel->isTeenageRangeInit()),
            'roomTypes' => $roomTypes,
            'form' => $form->createView(),
            'copyRatesForm' => $copyRatesForm->createView(),
            'errors' => $form->getErrors(),
        ];

        if ($isCopyRates) {
            return $params;
        }

        return $this->render('@AltezzaTravel/hotels/prices.html.twig', $params);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function ajaxRequestAction(Request $request)
    {
        $filterByEntity = $request->get('filter');
        $filterByColumn = $request->get('by');
        $filterByValue = $request->get('value');

        try {
            switch ($filterByEntity) {
                case 'area':
                    $repository = $this->getEm()->getRepository(TerritorialArea::class);

                    $result = array_map(function (TerritorialArea $item) {
                        return [
                            'id' => $item->getId(),
                            'title' => $item->getTitle(),
                        ];
                    }, $repository->findBy([$filterByColumn => $filterByValue]));
                    break;
                case 'airstrip':
                    $qb = $this->getEm()->getRepository(TerritorialAirstrip::class)->createQueryBuilder('ta');
                    $airstrips = $qb->join(sprintf('ta.%s', $filterByColumn), 'joined')
                        ->where($qb->expr()->eq('joined.id', $filterByValue))
                        ->getQuery()
                        ->getResult();

                    $result = array_map(function (TerritorialAirstrip $item) {
                        return [
                            'id' => $item->getId(),
                            'title' => $item->getTitle(),
                        ];
                    }, $airstrips);
                    break;
                default:
                    throw new NotFoundHttpException();
            }
        } catch (\Exception $exception) {
            return new JsonResponse([
                'status' => false,
                'message' => $exception->getMessage(),
            ]);
        }

        return new JsonResponse([
            'status' => true,
            'result' => $result,
        ]);
    }

    /**
     * @param object[]|ArrayCollection $formData
     * @param integer $year
     */
    private function filterFormDataByYear($formData, $year)
    {
        return $formData->filter(function ($item) use ($formData, $year) {
            if ((int) $item->getYear() !== (int) $year) {
                $formData->removeElement($item);
            }
        });
    }
}
