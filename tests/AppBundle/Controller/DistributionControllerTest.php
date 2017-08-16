<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DistributionControllerTest extends WebTestCase
{
    /**
     * Tests GET Method.
     */
    public function testGetIndex()
    {
        
        $client = static::createClient();

        $client->request('GET', 'distribution/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        
    }
    
    /**
     * Tests POST Method.
     */
    public function testPostIndex()
    {
        $state = "Saxony";
        $client = static::createClient();
        
        $parties = '{"seats_num": 15,
            "state": "'. $state .'",
            "parties": {"A":6000,"B":7000,"C":8000,"D":9000}}';
        
        $crawler = $client->request('GET', 'distribution/state/'. $state ."/");

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $content = $client->getResponse()->getContent();
        $parliament = json_decode($content, true);
        if(count($parliament) == 0)
        {
            $client = static::createClient();
            //empty.
            $crawler = $client->request('POST','distribution/', array(), array(), 
                array('CONTENT_TYPE' => 'application/json'),
                $parties
            );
            $this->assertEquals(200, $client->getResponse()->getStatusCode());
        }
        else {
            $this->assertEquals(200, $client->getResponse()->getStatusCode());
        }
        
    }
    
    /**
     * Tests POST Method.
     */
    public function testPutIndex()
    {
        $state = "Berlin";
        $client = static::createClient();
        
        $parties = '{"seats_num": 15,
            "state": "'. $state .'",
            "parties": {"A":6000,"B":7000,"C":8000,"D":9001}}';
        
        $crawler = $client->request('GET', 'distribution/state/'. $state ."/");

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $content = $client->getResponse()->getContent();
        $parliament = json_decode($content, true);
        if(count($parliament) == 0)
        {
            $this->assertEquals(200, $client->getResponse()->getStatusCode());
        }
        else {
            $client = static::createClient();
            //empty.
            $crawler = $client->request('PUT','distribution/', array(), array(), 
                array('CONTENT_TYPE' => 'application/json'),
                $parties
            );
            $this->assertEquals(200, $client->getResponse()->getStatusCode());
        }
        
    }
    
    /**
     * Tests DELETE Method.
     */
    public function testDeleteIndex()
    {
        $state = "Saxony";
        $client = static::createClient();
        
        $crawler = $client->request('GET', 'distribution/state/'. $state ."/");

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $content = $client->getResponse()->getContent();
        $parliament = json_decode($content, true);
        if(count($parliament) !== 0)
        {
            $client = static::createClient();
            //empty.
            $crawler = $client->request('DELETE','distribution/state/'. $state ."/");
            $this->assertEquals(200, $client->getResponse()->getStatusCode());
        }
        else {
            $this->assertEquals(200, $client->getResponse()->getStatusCode());
        }
        
    }
    
}
