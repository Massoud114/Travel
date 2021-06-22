<?php

namespace App\Controller;

use App\Entity\Voyage;
use App\Form\VoyageFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TravelController extends AbstractController
{
	/**
	 * @Route("/travel/new", name="travel.new")
	 * @param Request $request
	 * @return Response
	 */
	public function new(Request $request): Response
	{
		$voyage = new Voyage();
		$form = $this->createForm(VoyageFormType::class, $voyage);
		$form->handleRequest($request);


	    return $this->render('pages/travel.new.html.twig', [
	    	'form' => $form->createView()
	    ]);
	}

	/**
	 * @Route("/travel/show", name="travel.show", methods={"GET", "POST"})
	 * @param Request $request
	 * @return Response
	 */
	public function show(Request $request): Response
	{
		$flightJSON = $request->get('tra');
		$flight = json_encode(json_decode($flightJSON));

		$travelData = $request->get('travel');
		dd(json_decode($travelData));
	    return $this->render('pages/travel.show.html.twig', [
	    	'flight' => $flight
	    ]);
	}
}
