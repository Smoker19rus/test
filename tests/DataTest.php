<?php

use PHPUnit\Framework\TestCase;

class DataTest extends TestCase
{
    protected $request;

    /**
     * @dataProvider additionProvider
     */
    public function testCheckStatusCode($lat, $lon)
    {
        $client = new \GuzzleHttp\Client();
        $this->request = $client->get("http://geozones.kdvonline.ru/getZone?lat={$lat}&lon={$lon}");
        $this->assertSame(200, $this->request->getStatusCode());
    }

    /**
     * @dataProvider additionProvider
     */
    public function testCheckResult($lat, $lon)
    {
        $client = new \GuzzleHttp\Client();
        $this->request = $client->get("http://geozones.kdvonline.ru/getZone?lat={$lat}&lon={$lon}");
        $jsonBody = \GuzzleHttp\json_decode($this->request->getBody());
        $this->assertSame("ok", $jsonBody->result);
        $this->assertSame("none", $jsonBody->result);

    }
    /**
     * @dataProvider additionProvider
     */
    public function testEmptyField($lat, $lon)
{
    $client = new \GuzzleHttp\Client();
    $this->request = $client->get("http://geozones.kdvonline.ru/getZone?lat={$lat}&lon={$lon}");
    $jsonBody = \GuzzleHttp\json_decode($this->request->getBody());
    if($jsonBody->result == "ok")
    {
        $this->assertAttributeNotEmpty("description", $jsonBody);
        $this->assertAttributeNotEmpty("lat", $jsonBody);
        $this->assertAttributeNotEmpty("lon", $jsonBody);
        $this->assertAttributeNotEmpty("name", $jsonBody);
    }
    if($jsonBody->result == "none"){
        $this->assertAttributeNotEmpty("lat", $jsonBody);
        $this->assertAttributeNotEmpty("lon", $jsonBody);
        $this->assertObjectNotHasAttribute("description", $jsonBody);
        $this->assertObjectNotHasAttribute("name",$jsonBody);
    }

}
    /**
     * @dataProvider additionProvider
     */
    public function testDescSymbols($lat, $lon)
{
    $client = new \GuzzleHttp\Client();
    $this->request = $client->get("http://geozones.kdvonline.ru/getZone?lat={$lat}&lon={$lon}");
    $jsonBody = \GuzzleHttp\json_decode($this->request->getBody());
    if($jsonBody->result == "ok") {
        $this->assertSame(36, strlen($jsonBody->description));
    }
}

    public function additionProvider()
    {
        return [
            [
                56.4997075,
                84.949777
            ],
            [
                53.4997075,
                86.949777
            ]
        ];
    }

}