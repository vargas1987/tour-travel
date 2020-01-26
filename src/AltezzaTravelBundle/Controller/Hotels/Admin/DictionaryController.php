<?php

namespace AltezzaTravelBundle\Controller\Hotels\Admin;

use AltezzaTravelBundle\Controller\AbstractController;
use AltezzaTravelBundle\Entity\HotelChain;
use AltezzaTravelBundle\Entity\TypeAccommodation;
use AltezzaTravelBundle\Entity\TypeRoom;
use AltezzaTravelBundle\Entity\TypeSeason;
use AltezzaTravelBundle\Form\Hotels\Admin\AccommodationTypeEditForm;
use AltezzaTravelBundle\Form\Hotels\Admin\HotelChainEditForm;
use AltezzaTravelBundle\Form\Hotels\Admin\RoomTypeEditForm;
use AltezzaTravelBundle\Form\Hotels\Admin\SeasonTypeEditForm;
use Symfony\Component\HttpFoundation\Request;

class DictionaryController extends AbstractController
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function roomTypeListAction()
    {
        $roomTypes = $this->getEm()->getRepository(TypeRoom::class)->findAllSorted();

        return $this->render('@AltezzaTravel/hotels/admin/roomTypeList.html.twig', [
            'roomTypes' => $roomTypes,
        ]);
    }

    /**
     * @param Request       $request
     * @param TypeRoom|null $roomType
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function roomTypeEditAction(Request $request, TypeRoom $roomType = null)
    {
        if (!$roomType) {
            $roomType = new TypeRoom();
        }

        $form = $this->createForm(RoomTypeEditForm::class, $roomType);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!$roomType->getId()) {
                $this->getEm()->persist($roomType);
            }

            $this->getEm()->flush();

            return $this->redirectToRoute('hotels_admin_room_type_list');
        }

        return $this->render('@AltezzaTravel/hotels/admin/roomTypeEdit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function accommodationTypeListAction()
    {
        $accommodationTypes = $this->getEm()->getRepository(TypeAccommodation::class)->findAllSorted();

        return $this->render('@AltezzaTravel/hotels/admin/accommodationTypeList.html.twig', [
            'accommodationTypes' => $accommodationTypes,
        ]);
    }

    /**
     * @param Request       $request
     * @param TypeAccommodation|null $accommodationType
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function accommodationTypeEditAction(Request $request, TypeAccommodation $accommodationType = null)
    {
        if (!$accommodationType) {
            $accommodationType = new TypeAccommodation();
        }

        $form = $this->createForm(AccommodationTypeEditForm::class, $accommodationType);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!$accommodationType->getType()) {
                $this->getEm()->persist($accommodationType);
            }

            $this->getEm()->flush();

            return $this->redirectToRoute('hotels_admin_accommodation_type_list');
        }

        return $this->render('@AltezzaTravel/hotels/admin/accommodationTypeEdit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function seasonTypeListAction()
    {
        $seasonTypes = $this->getEm()->getRepository(TypeSeason::class)->findAllSorted();

        return $this->render('@AltezzaTravel/hotels/admin/seasonTypeList.html.twig', [
            'seasonTypes' => $seasonTypes,
        ]);
    }

    /**
     * @param Request         $request
     * @param TypeSeason|null $seasonType
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function seasonTypeEditAction(Request $request, TypeSeason $seasonType = null)
    {
        if (!$seasonType) {
            $seasonType = new TypeSeason();
        }

        $form = $this->createForm(SeasonTypeEditForm::class, $seasonType);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!$seasonType->getType()) {
                $this->getEm()->persist($seasonType);
            }

            $this->getEm()->flush();

            return $this->redirectToRoute('hotels_admin_season_type_list');
        }

        return $this->render('@AltezzaTravel/hotels/admin/seasonTypeEdit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function hotelChainListAction()
    {
        $hotelChains = $this->getEm()->getRepository(HotelChain::class)->findAll();

        return $this->render('@AltezzaTravel/hotels/admin/hotelChainList.html.twig', [
            'hotelChains' => $hotelChains,
        ]);
    }

    /**
     * @param Request         $request
     * @param HotelChain|null $hotelChain
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function hotelChainEditAction(Request $request, HotelChain $hotelChain = null)
    {
        if (!$hotelChain) {
            $hotelChain = new HotelChain();
        }

        $form = $this->createForm(HotelChainEditForm::class, $hotelChain);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!$hotelChain->getId()) {
                $this->getEm()->persist($hotelChain);
            }

            $this->getEm()->flush();

            return $this->redirectToRoute('hotels_admin_hotel_chain_list');
        }

        return $this->render('@AltezzaTravel/hotels/admin/hotelChainEdit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
