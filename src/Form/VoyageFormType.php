<?php

namespace App\Form;

use App\Entity\Voyage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VoyageFormType extends AbstractType
{
	/*private HttpClientInterface $httpClient;
	protected RequestStack $requestStack;

	public function __construct(HttpClientInterface $httpClient, RequestStack $requestStack)
	{
		$this->httpClient = $httpClient;
		$this->requestStack = $requestStack;
	}

	private function loadAirports(): array
	{
		$request = $this->requestStack->getCurrentRequest();
		$response = $this->httpClient->request('GET', str_replace($request->getRequestUri(), "", $request->getUri())
			. '/EasyPNR-Airports.json');
		return $response->toArray();
	}*/


	public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('dateVoyage', DateType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Voyage::class,
        ]);
    }
}
