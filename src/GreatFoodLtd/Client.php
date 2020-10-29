<?php declare(strict_types = 1);

namespace App\GreatFoodLtd;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException;

abstract class Client
{
    protected GuzzleClient $client;

    public function __construct(GuzzleClient $client)
    {
        $this->client = new $client([
            'base_uri' => $_ENV['CLIENT_URI'],
        ]);
    }

    private function auth()
    {
        try {
            $response = $this->client->request('POST', '/auth_token', [
                'multipart' => [
                    [
                        'client_secret' => $_ENV['CLIENT_SECRET'],
                        'client_id'     => $_ENV['CLIENT_ID'],
                        'grant_type'    => $_ENV['GRANT_TYPE'],
                        'headers'  => [
                            'Content-Type' => 'application/x-www-form-urlencoded'
                        ]
                    ]
                ]
            ]);

            $response = json_decode($response->getContents(), true);

            if (array_key_exists('access_token', $response)) {
                $response['access_token'];
            }
        } catch (GuzzleException $e) {
        }

        return [];
    }

    protected function getAuthHeader(): string
    {
        return sprintf('Bearer %s', $this->auth());
    }
}