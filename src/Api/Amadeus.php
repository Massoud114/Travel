<?php

namespace App\Api;

use DateTime;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class Amadeus
{
	private HttpClientInterface $client;
	private SessionInterface $session;

	public function __construct(HttpClientInterface $client, SessionInterface $session)
	{
		$this->client = $client;
		$this->session = $session;
	}

	public function setup() {
		$now = new DateTime('now');
		if ($this->session->has("authToken")) {
			$exp = $this->session->get("expireAt");
			if ($exp > $now->getTimestamp()){
				return $this->session->get('authToken');
			}
		}
		$response = $this->client->request('POST', 'https://test.api.amadeus.com/v1/security/oauth2/token', [
			'headers' => [
				'Content-Type' => 'application/x-www-form-urlencoded'
			],
			'body' => [
				'client_id' => '1tGzxd3fKVzoGHKGczSPLSeI1iFvqeuX',
				'client_secret' => 'y79k0sQJvFbZMc7J',
				'grant_type' => 'client_credentials'
			]
		]);
		$content = $response->toArray();
		$date = new DateTime('now');

		$date->add(new \DateInterval('PT' . $content['expires_in'] . 'S'));

		$this->session->set('authToken', $content['access_token']);
		$this->session->set('expireAt', $date->getTimestamp());
		return $content['access_token'];
	}

	public function getCountryPhoto(string $countryName) {
		$response = $this->client->request('GET', 'https://api.unsplash.com/search/photos', [
			// these values are automatically encoded before including them in the URL
			'query' => [
				'query' => $countryName,
				'client_id' => '4FC7Es7m8ZD2hdv3JNqetIsGVTSJSwDOslM_-rZz8tw',
				'page' => 1,
				'per_page' => 5
			],
		]);
		$response = $response->toArray();
		$content = $response['results'];
		$urls = [];
		foreach ($content as $image){
			$urls[] = $image['urls']['regular'];
		}
		return $urls[0];
	}

	public function getCountryInfo($countryName)
	{
		$response = $this->client->request('GET', 'https://restcountries.eu/rest/v2/name/' . $countryName);
		return $response->toArray()[0];
	}

	/*public function bookFlight($bookingData) {
		$access_token = $this->setup();
		$response = $this->client->request("POST", "https://test.api.amadeus.com/v2/booking/flight-orders", [
			'body' => [
				'data' => $bookingData
			],
			'auth_bearer' => $access_token
		]);
		dd($response);
	}*/

	public function getAvailableHotel($travelData, $flight)
	{
		$access_token = $this->setup();
		$response = $this->client->request("GET", "https://test.api.amadeus.com/v2/shopping/hotel-offers", [
			'auth_bearer' => $access_token,
			'query' => [
				'cityCode' => $travelData->destinationLocationCode,
				'checkInDate' => $travelData->departureDate,
				'adults' => $travelData->adults,
			],
		]);

		return $response->toArray()['data'];
	}

	public function getHotelInfo($hotelId)
	{
		$access_token = $this->setup();
		$response = $this->client->request("GET", "https://test.api.amadeus.com/v2/shopping/hotel-offers/by-hotel", [
			'auth_bearer' => $access_token,
			'query' => [
				'hotelId' => $hotelId
			],
		]);
		return $response->toArray()['data'];
	}
}
