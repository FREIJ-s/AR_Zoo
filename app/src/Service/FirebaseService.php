<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class FirebaseService
{
    private HttpClientInterface $client;
    private string $firebaseUrl;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
        $this->firebaseUrl = 'https://zoo-arcadia-2c6e3-default-rtdb.europe-west1.firebasedatabase.app/';
    }

    public function addData(string $collection, array $data): string
    {
        $url = "{$this->firebaseUrl}{$collection}.json";

        $response = $this->client->request('POST', $url, [
            'json' => $data,
            'verify_peer' => false,
            'verify_host' => false,
        ]);

        return $response->getStatusCode() === 200 ? "Succès" : "Erreur";
    }

    public function getData(string $collection): array
    {
        $url = "{$this->firebaseUrl}{$collection}.json";

        $response = $this->client->request('GET', $url, [
            'verify_peer' => false,
            'verify_host' => false,
        ]);

        $data = json_decode($response->getContent(), true);

        return $data ? array_values($data) : [];
    }
}
