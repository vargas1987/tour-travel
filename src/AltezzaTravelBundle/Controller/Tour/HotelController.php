<?php

namespace AltezzaTravelBundle\Controller\Tour;

use AltezzaTravelBundle\Controller\AbstractController;
use AltezzaTravelBundle\Entity\Hotel;
use AltezzaTravelBundle\Entity\HotelMakeStory;
use AltezzaTravelBundle\Entity\HotelMakeStoryProgram;
use AltezzaTravelBundle\Entity\TerritorialAirstrip;
use AltezzaTravelBundle\Entity\TerritorialArea;
use AltezzaTravelBundle\Entity\TypeMealPlan;
use AltezzaTravelBundle\Form\Tour\HotelCalculateForm;
use AltezzaTravelBundle\Form\Tour\HotelMakeStoryForm;
use AltezzaTravelBundle\Form\Tour\HotelSearchForm;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class HotelController
 * @package AltezzaTravelBundle\Controller\Tour
 */
class HotelController extends AbstractController
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function indexAction(Request $request)
    {
        if (!$this->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('tour_login');
        }

        return $this->redirectToRoute('tour_hotel_search');
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function searchAction(Request $request)
    {
        $form = $this->createForm(HotelSearchForm::class, null);

        $form->handleRequest($request);

        $result = [];
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $hotelPickUpHelper = $this->getHotelPickUpHelper();

                try {
                    $submitData = $form->getData();

                    $sorting = $form->get('sorting')->getData();
                    $dateFrom = $submitData['dateFrom'];
                    $dateTo = $submitData['dateTo'];
                    $interval = $dateFrom->diff($dateTo);

                    /** @var Hotel[]|ArrayCollection $hotels */
                    $hotels = $hotelPickUpHelper->findHotelsByOptions($submitData);

                    $result['nights'] = $interval->format('%a');
                    $hotels = $hotelPickUpHelper->calculateHotelsAccommodations($hotels, $submitData);

                    $items = $hotels->toArray();

                    usort($items, function ($first, $second) use ($sorting) {
                        $getSortedPrice = function ($rooms) use ($sorting) {
                            usort($rooms, function ($first, $second) use ($sorting) {
                                if ($sorting === 'asc') {
                                    return $first['price'] < $second['price'] ? -1 : 1;
                                }

                                return $first['price'] > $second['price'] ? -1 : 1;
                            });

                            return current($rooms)['price'];
                        };

                        if ($sorting === 'asc') {
                            return $getSortedPrice($first['rooms']) < $getSortedPrice($second['rooms']) ? -1 : 1;
                        }

                        return $getSortedPrice($first['rooms']) > $getSortedPrice($second['rooms']) ? -1 : 1;
                    });

                    $result['items'] = $items;

                    $this->addFlash('form_success', 'success');
                } catch (\Exception $exception) {
                    $this->getLogger()->error($exception->getMessage(), ['exception' => $exception]);
                    $this->addFlash('form_success', 'error');
                }
            } else {
                $this->addFlash('form_success', 'error');
            }
        }

        return $this->render('@AltezzaTravel/tour/hotel/search.html.twig', [
            'form' => $form->createView(),
            'result' => $result,
        ]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function calculateAction(Request $request)
    {
        $form = $this->createForm(HotelCalculateForm::class, null);

        $form->handleRequest($request);

        $result = [];
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $hotelPickUpHelper = $this->getHotelPickUpHelper();

                try {
                    $submitData = $form->getData();

                    $hotel = $submitData['hotel'];
                    $mealPlanTypes = $submitData['typeMealPlan'];
                    $dateFrom = $submitData['dateFrom'];
                    $dateTo = $submitData['dateTo'];
                    $interval = $dateFrom->diff($dateTo);

                    $result['nights'] = $interval->format('%a');
                    $result['mealPlanTypes'] = $mealPlanTypes;
                    $hotels = $hotelPickUpHelper->findOutCost($hotel, $dateFrom, $dateTo, $submitData);

                    $items = $hotels->toArray();

                    $result['items'] = $items;

                    $this->addFlash('form_success', 'success');
                } catch (\Exception $exception) {
                    $this->getLogger()->error($exception->getMessage(), ['exception' => $exception]);
                    $this->addFlash('form_success', 'error');
                }
            } else {
                $this->addFlash('form_success', 'error');
            }
        }

        return $this->render('@AltezzaTravel/tour/hotel/calculate.html.twig', [
            'form' => $form->createView(),
            'result' => $result,
        ]);
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
                case 'mealPlan':
                    $hotel = $this->getEm()->getRepository(Hotel::class)->find($filterByValue);
                    $repository = $this->getEm()->getRepository(TypeMealPlan::class)
                        ->createQueryBuilder('mealPlan')
                        ->innerJoin('mealPlan.hotels', 'hotel')
                        ->where('hotel.id = :hotel')
                        ->setParameter('hotel', $filterByValue)
                        ->getQuery()->getResult()
                    ;

                    $result = [
                        'ageRange' => [
                            'childTo' => $hotel->getChildTo() ?? 0,
                            'teenagerFrom' => $hotel->getTeenagerFrom() ?? 0,
                            'teenagerTo' => $hotel->getTeenagerTo() ?? 0,
                            'adultFrom' => $hotel->getAdultFrom() ?? 0,
                        ]
                    ];

                    $result['mealPlans'] = array_map(function (TypeMealPlan $item) {
                        return [
                            'id' => $item->getType(),
                            'title' => $item->getTitle(),
                        ];
                    }, $repository);

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
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function makeStoryAction(Request $request)
    {
        $form = $this->createForm(HotelMakeStoryForm::class, new HotelMakeStory());

        $form->handleRequest($request);
        $this->getEm()->beginTransaction();
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                /** @var HotelMakeStory $story */
                $story = $form->getData();
                $this->getEm()->persist($story);
                $this->getEm()->flush();
                $this->getEm()->commit();

                $this->addFlash('form_success', 'Story has been successfuly saved.');
            } catch (\Exception $exception) {
                $this->getEm()->rollback();
                $this->getLogger()->error($exception->getMessage(), [
                    'exception' => $exception
                ]);

                $this->addFlash('form_success', 'error');
            }
        }

        return $this->render('@AltezzaTravel/tour/hotel/make_story.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
