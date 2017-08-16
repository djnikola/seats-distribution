<?php

namespace AppBundle\Services;

use \AppBundle\Services\Interfaces\ParliamentInterface;
use \AppBundle\Services\Interfaces\DistributionHandlerInterface;

class DistributionHandler implements DistributionHandlerInterface
{
    
    /**
     * Total votes from all parties.
     *
     * @var int
     */
    private $totalVotes;
    
    /**
     *
     * @var ParliamentInterface 
     */
    private $parliament;
    
    function __construct() 
    {
        
    }
    
    /**
     * Sum of all parties' votes. 
     * 
     * @return int
     */
    private function sumTotalVotes()
    {
        $this->totalVotes = 0;
        if($this->parliament->isEmpty())
        {
            return $this->totalVotes;
        }
        
        foreach ($this->parliament->getParties() as $party)
        {
            $this->totalVotes += $party->getVotes();
        }
        return $this->totalVotes;
    }
    
    /**
     * The seats allocated to a party are calculated by this method in two steps:
     *      In the first step the corresponding number of votes that are attributable to a party is multiplied by the total number of available seats and divided by the total number of valid votes.
     *      In the second step the result is split into the integer portion and the rest. The integer parts are attributed to the respective party as seats. 
     *      The remaining seats are allocated to parties in the order of the size of the fractional portions.
     * 
     * @return boolean
     */
    public function calculate()
    {
        if($this->parliament->getSeatsNum() == 0 || $this->parliament->isEmpty())
        {
            return false;
        }
        
        $seatsVoteRatio = $this->parliament->getSeatsNum() / $this->getTotalVotes();
        $seatsNum = 0;
        $fractionalArr = [];
        foreach($this->parliament->getParties() as $party)
        {
            $ratio = $party->getVotes() * $seatsVoteRatio;
            $fractionalArr[$party->getName()] = $ratio - floor($ratio);
            $party->setSeats(floor($ratio));
            $seatsNum += $party->getSeats();
        }
        
        if($seatsNum == $this->parliament->getSeatsNum())
        {
            return true;
        }
        
        $remainingSeats = $this->parliament->getSeatsNum() - $seatsNum;

        arsort($fractionalArr, SORT_NUMERIC);        
        while($remainingSeats > 0)
        {
            reset($fractionalArr);
            $partyName = key($fractionalArr);
            $partyFraction = array_shift($fractionalArr);
            $party = $this->parliament->getPartyByName($partyName);
            $party->incSeats();
            $fractionalArr[$partyName] = $partyFraction;
            $remainingSeats--;
        }
        return true;
    }
    
    /**
     * Sets parlament and calculate sum of all parties' votes.
     * 
     * @param ParliamentInterface $parliament
     * @return \AppBundle\Entity\DistributionHandler
     */
    public function setParliament(ParliamentInterface $parliament)
    {
        $this->parliament = $parliament;
        $this->sumTotalVotes();
        return $this;
    }
    
    /**
     * Returns parliament.
     * 
     * @return ParliamentInterface
     */
    public function getParliament()
    {
       return $this->parliament;
    }
    
    /**
     * Returns total votes from all parties. 
     * 
     * @return int
     */
    public function getTotalVotes()
    {
        return $this->totalVotes;
    }
    
    
}