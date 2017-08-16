<?php
namespace Tests\AppBundle\Services;

use AppBundle\Services\Parliament;
use AppBundle\Entity\Party;
use PHPUnit\Framework\TestCase;
use Exception;

class ParliamentTest extends TestCase
{
    /**
     * Tests initialization
     */
    public function testInitTrue()
    {
        $seatsNum = 16;
        $parliament = new Parliament();
        $parliament->init($seatsNum);
        $this->assertEquals($seatsNum, $parliament->getSeatsNum());
    }
    
    /**
     * Tests if Parlament is empty after initialization.
     */
    public function testIsEmptyTrue()
    {
        $seatsNum = 16;
        $parliament = new Parliament();
        $parliament->init($seatsNum);
        $this->assertEquals(true, $parliament->isEmpty());
    }
    
    /**
     * Tests adding party
     */
    public function testAddPartyTrue()
    {
        $seatsNum = 16;
        //creating parliament.
        $parliament = new Parliament();
        $parliament->init($seatsNum);
        
        //creating party
        $party = new Party();
        $party->setName("A")->setSeats(15)->setState('Berlin')->setVotes(5000);
        $parliament->add($party);
        
        $this->assertEquals(1, count($parliament->getParties()));
        
    }
    
    /**
     * Tests adding same party twice.
     */
    public function testAddPartyException()
    {
        $seatsNum = 16;
        //creating parliament.
        $parliament = new Parliament();
        $parliament->init($seatsNum);
        
        try {
            //creating party
            $party = new Party();
            $party->setName("A")->setSeats(15)->setState('Berlin')->setVotes(5000);
            $parliament->add($party);

            $party = new Party();
            $party->setName("A")->setSeats(20)->setState('Berlin')->setVotes(7500);
            $parliament->add($party);
            
            $this->fail("Party '". $party->getName() . "' already exists in parliament.");
        }
        catch (Exception $ex)
        {
            $this->assertEquals($ex->getCode(), 500);
        }
    }
    
    /**
     * Tests adding same party twice.
     */
    public function getPartyByNameTrue()
    {
        $seatsNum = 16;
        //creating parliament.
        $parliament = new Parliament();
        $parliament->init($seatsNum);
        
        try {
            //creating party
            $party = new Party();
            $party->setName("A")->setSeats(15)->setState('Berlin')->setVotes(5000);
            $parliament->add($party);

            $party = new Party();
            $party->setName("B")->setSeats(20)->setState('Berlin')->setVotes(7500);
            $parliament->add($party);
            
            $party = new Party();
            $party->setName("C")->setSeats(8)->setState('Berlin')->setVotes(500);
            $parliament->add($party);
            
            $party = $parliament->getPartyByName("B");
            $this->assertEquals("B", $party->getName());
        }
        catch (Exception $ex)
        {
            $this->fail("Party '". $party->getName() . "' already exists in parliament.");
        }
    }
    
}