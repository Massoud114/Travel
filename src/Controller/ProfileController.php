<?php

namespace App\Controller;

use App\Entity\ReservationHotel;
use App\Repository\ReservationHotelRepository;
use App\Repository\ReservationVolRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/profile")
 * @IsGranted("IS_AUTHENTICATED_FULLY")
 */
class ProfileController extends AbstractController
{
    /**
     * @Route("/", name="profile.vols")
     * @Route("/vols", name="profile")
     */
    public function index(ReservationVolRepository $repository): Response
    {
        $user = $this->getUser();
        $volsByUser = $repository->findBy(['user' => $user]);

        return $this->render('profile/index.html.twig', [
            'vols' => $volsByUser,
        ]);
    }

    /**
     * @Route("/hotels", name="profile.hotels")
     */
    public function hotel(ReservationHotelRepository $repository): Response
    {
        $user = $this->getUser();
        $hotelsByUser = $repository->findBy(['user' => $user]);

        return $this->render('profile/hotel.html.twig', [
            'hotels' => $hotelsByUser,
        ]);
    }
}
