<?php

use PHPUnit\Framework\TestCase;
class DataTestZones extends TestCase
    {
    protected $requestz;

    public function testCheckStatusCodeZones() {
    $client = new \GuzzleHttp\Client();
    $this->requestz = $client->get("http://geozones.kdvonline.ru/printZones");
    $this->assertSame(200, $this->requestz->getStatusCode());
        }
    public function testCheckStatusResult() {
        $client = new \GuzzleHttp\Client();
        $this->requestz = $client->get("http://geozones.kdvonline.ru/printZones");
        $jsonBody = \GuzzleHttp\json_decode($this->requestz->getBody());

        $this->assertSame("ok", $jsonBody->result);
    }
    public function testCheckValueSymbolDesc() {
        $client = new \GuzzleHttp\Client();
        $this->requestz = $client->get("http://geozones.kdvonline.ru/printZones");
        $jsonBody = \GuzzleHttp\json_decode($this->requestz->getBody());
        foreach ($jsonBody->zones as $zone) {

            $this->assertSame(36,strlen($zone->description));

        }
    }
    public function testCheckEmptyFields() {
        $client = new \GuzzleHttp\Client();
        $this->requestz = $client->get("http://geozones.kdvonline.ru/printZones");
        $jsonBody = \GuzzleHttp\json_decode($this->requestz->getBody());
        for ($i = 0; $i < count($jsonBody->zones) ; $i++) {

            $this->assertAttributeNotEmpty("description", $jsonBody->zones[$i]);
            $this->assertAttributeNotEmpty("name", $jsonBody->zones[$i]);
    }


    }
}