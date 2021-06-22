<?php

namespace App\Api;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class Unsplash
{
	private HttpClientInterface $client;
	private Session $session;

	public function __construct(HttpClientInterface $client, Session $session)
	{
		$this->client = $client;
		$this->session = $session;
	}

	public function setup() {
		if ($this->session->has("authToken")) {
			$exp = $this->session->get("expireAt");
			if ($exp >= new \DateTime('now')){
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
		dd($response);
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
}
