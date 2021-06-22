<?php


namespace App\Controller;

use App\Api\Amadeus;
use App\Entity\ReservationHotel;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/hotel")
 * @IsGranted("IS_AUTHENTICATED_FULLY")
 */
class HotelController extends AbstractController
{
	/**
	 * @Route("/search", name="hotel.search")
	 * @param Session $session
	 * @return Response
	 */
	public function search(Session $session, Amadeus $amadeus): Response
	{
		if (!$session->has('travel')) {
			return $this->redirectToRoute('travel.new');
		}
		$travelData = $session->get('travel');
		$hotels = $amadeus->getAvailableHotel($travelData);

		dd($hotels);

	    return $this->render('pages/hotel.search.html.twig', [
	    	'hotels' => $hotels
	    ]);
	}

	/**
	 * @Route("/show/{id}", name="hotel.show")
	 * @param Request $request
	 * @return Response
	 */
	public function show(Request $request, Amadeus $amadeus): Response
	{
	    $hotelId = $request->get('id');
	    $hotelInfo = $amadeus->getHotelInfo($hotelId);
	    $hotel = $hotelInfo['hotel'];
	    $isAvailable = $hotelInfo['available'];
	    $offer = $hotelInfo['offers'][0];

	    $request->getSession()->set('hotel', $hotel);

		$image = $amadeus->getCountryPhoto("hotel-travel");

	    //dd($hotel, $isAvailable, $offer);
	    return $this->render('pages/hotel.show.html.twig', [
	    	'hotel' => $hotel,
		    'isAvailable' => $isAvailable,
		    'offer' => $offer,
		    'image' => $image
	    ]);
	}
	
	/**
	* @Route("/pay", name="hotel.pay")
	* @return Response
	*/
	public function pay(): Response
	{
	    return $this->render('pages/hotel.pay.html.twig');
	}

	/**
	 * @Route("/confirm", name="hotel.confirm")
	 * @param Session $session
	 * @return Response
	 */
	public function confirm(Session $session): Response
	{
		$manager = $this->getDoctrine()->getManager();

	    $hotel = $session->get('hotel');

		$reservation = new ReservationHotel();

		$reservation->setUser($this->getUser())
			->setIsValid(true)
			->setIsPurchased(true)
			->setHotelName($hotel['hotel']['name']);

		$manager->persist($reservation);
		$manager->flush();

	    return $this->render('pages/hotel.confirm.html.twig', [
	    	'hotel' => $hotel
	    ]);
	}
}
