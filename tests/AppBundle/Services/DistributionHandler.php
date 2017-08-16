<?php
namespace Tests\AppBundle\Services;

use AppBundle\Services\Parliament;
use AppBundle\Services\DistributionHandler;
use AppBundle\Entity\Party;
use PHPUnit\Framework\TestCase;
use Exception;

class DistributionHandlerTest extends TestCase
{
    /**
     *
     * @var AppBundle\Services\Parliament
     */
    private $parliament;
    
    /**
     * Key: party name
     * Value: Number of Seats.
     *
     * @var array
     */
    private $expectedDistribution;
    
    /**
     * Number of Seats in Parliament
     *
     * @var int
     */
    private $seatsNum;
    
    /**
     * Initialize objects required for test.
     */
    private function init()
    {
        $this->seatsNum = 15;
        $this->expectedDistribution = ['A' => 7, 'B' => 2, 'C' => 3, 'D' => 3];
        
        $parliament = new Parliament();
        $parliament->init($this->seatsNum);
        
        $state = "Berlin";
        $party = new Party();
        $party->setName("A")->setVotes(15000)->setState($state);
        $parliament->add($party);
        
        $party = new Party();
        $party->setName("B")->setVotes(5400)->setState($state);
        $parliament->add($party);
        
        $party = new Party();
        $party->setName("C")->setVotes(5500)->setState($state);
        $parliament->add($party);
        
        $party = new Party();
        $party->setName("D")->setVotes(5550)->setState($state);
        $parliament->add($party);
        
        $this->parliament = $parliament;
    }
    
    /**
     * Tests calculation of parliaments seat.
     * 
     * Example:15 
     *      Votes: ['A' => 15000, 'B' => 5400, 'C' => 5500, 'D' => 5550] 
     *      Result seats should be: ['A' => 7, 'B' => 2, 'C' => 3, 'D' => 3]
     * 
     */
    public function testCalculateTrue()
    {
        
        $this->init();
        $distributionHandler = new DistributionHandler();
        $distributionHandler->setParliament($this->parliament);
        $distributionHandler->calculate();
        
        foreach ($this->expectedDistribution as $partyName => $seats)
        {
            $this->assertEquals($seats, $this->parliament->getPartyByName($partyName)->getSeats());
        }
    }
 
    /**
     * Tests total number of seats from parties. 
     * 
     * Example:15 
     *      Votes: ['A' => 15000, 'B' => 5400, 'C' => 5500, 'D' => 5550] 
     *      Result seats should be: ['A' => 7, 'B' => 2, 'C' => 3, 'D' => 3]
     * 
     */
    public function testTotalPartiesSeatsTrue()
    {
        $this->init();
        
        $distributionHandler = new DistributionHandler();
        $distributionHandler->setParliament($this->parliament);
        $distributionHandler->calculate();
        
        $total = 0;
        foreach ($this->expectedDistribution as $partyName => $seats)
        {
            $total += $this->parliament->getPartyByName($partyName)->getSeats();
        }
        $this->assertEquals($this->seatsNum, $total);
    }    
    
}