<?php

use PHPUnit\Framework\TestCase;

/**
 * http://docs.guzzlephp.org/en/stable/quickstart.html
 */
use GuzzleHttp\Client;

final class Test1 extends TestCase
{
    public $client;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        $this->client = new Client([
            'base_uri' => 'http://nginx'
        ]);

        parent::__construct($name, $data, $dataName);
    }

    public function testHomePage()
    {
        $response = $this->client->request('GET', '/');

        $this->assertEquals(
            200,
            $response->getStatusCode()
        );
    }

    public function testUploadingByURL()
    {
        $response = $this->client->request('POST', '/upload', [
            'form_params' => [
                'link' => 'https://capella.pics/0351d892-44ba-4c5f-9d34-0af0f9e33651'
            ]
        ]);

        /**
         * Check response code
         */
        $this->assertEquals(
            200,
            $response->getStatusCode()
        );

        /**
         * Check for success
         */
        $responseContent = $response->getBody()->getContents();
        $content = json_decode($responseContent);

        $this->assertEquals(
            true,
            $content->success
        );


    }
}