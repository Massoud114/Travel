<?php

namespace App\Controller;

use App\Api\Unsplash;
use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TravelController
 * @Route("/travel")
 */
class TravelController extends AbstractController
{
	/**
	 * @Route("/new", name="travel.new")
	 * @param Request $request
	 * @return Response
	 */
	public function new(Request $request): Response
	{
		if ($request->getSession()->has('flight') and $this->getUser()){
			return $this->redirectToRoute("travel.book");
		}
	    return $this->render('pages/travel.new.html.twig');
	}

	/**
	 * @Route("/show", name="travel.show", methods={"GET", "POST"})
	 * @param Request $request
	 * @param Unsplash $unsplash
	 * @return Response
	 */
	public function show(Request $request, Unsplash $unsplash): Response
	{
		$flight = json_decode($request->get('flight'));

		$travelData = json_decode($request->get('travel'));
		$image = $unsplash->getCountryPhoto($travelData->destinationCountry);

		$countryInfo = $unsplash->getCountryInfo($travelData->destinationCountry);
		//dd($travelData, $flight, $countryInfo);

		$session = $request->getSession();
		$session->set('flight', $flight);
		$session->set('travel', $travelData);

	    return $this->render('pages/travel.show.html.twig', [
	    	'flight' => $flight,
		    'image' => $image,
		    'travelData' => $travelData,
		    'countryInfo' => $countryInfo
	    ]);
	}

	/**
	 * @Route("/book", name="travel.book")
	 * @param Request $request
	 * @return Response
	 * @IsGranted("IS_AUTHENTICATED_FULLY")
	 */
	public function book(Request $request): Response
	{
		$session = $request->getSession();
		if (!$session->has('flight')) {
			return $this->redirectToRoute('travel.new');
		}
		$flight = $session->get('flight');
	    $travelData = $session->get('travel');
	    return $this->render('pages/travel.book.html.twig', [
	    	'flight' => $flight,
		    'travelData' => $travelData
	    ]);
	}

	/**
	 * @Route("/change", name="travel.change")
	 * @param Session $session
	 * @return Response
	 */
	public function change(Session $session): Response
	{
		if ($session->has('flight')){
			$session->remove('flight');
			$session->remove('travel');
		}
	    return $this->redirectToRoute("travel.new");
	}

	/**
	 * @Route("/confirm", name="travel.confirm")
	 * @param Session $session
	 * @return Response
	 */
	public function confirm(Session $session, Unsplash $unsplash): Response
	{
		dd($unsplash->setup());
		if (!$session->has('flight')) {
			return $this->redirectToRoute('travel.new');
		}
		$flight = $session->get('flight');
		$travelData = $session->get('travel');

		$user = $this->getUser();

		$bookingData = array (
			'data' =>
				array (
					'type' => 'flight-order',
					'flightOffers' =>
						array (
							0 => $flight
						),
					'travelers' =>
						array (
							0 =>
								array (
									'id' => '1',
									'dateOfBirth' => $user->getDateBirth(),
									'name' =>
										array (
											'firstName' => $user->getFirstname(),
											'lastName' => $user->getFirstname(),
										),
									'gender' => 'MALE',
									'contact' =>
										array (
											'emailAddress' => $user->getEmail(),
										),
									'documents' =>
										array (
											0 =>
												array (
													'documentType' => 'PASSPORT',
													'birthPlace' => 'Madrid',
													'issuanceLocation' => 'Madrid',
													'issuanceDate' => '2015-04-14',
													'number' => '00000000',
													'expiryDate' => '2025-04-14',
													'issuanceCountry' => 'ES',
													'validityCountry' => 'ES',
													'nationality' => 'ES',
													'holder' => true,
												),
										),
								),
						),
					'contacts' =>
						array (
							0 =>
								array (
									'addresseeName' =>
										array (
											'firstName' => $user->getFirstName(),
											'lastName' => $user->getLastName(),
										),
									'emailAddress' => $user->getEmail(),
								),
						),
				),
		);

		dd($bookingData);
	    return $this->render('pages/travel.confirm.html.twig');
	}
}
