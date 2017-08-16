<?php
namespace AppBundle\Services\Interfaces;
use AppBundle\Services\Interfaces\ParliamentInterface;

interface DistributionHandlerInterface
{
    
    /**
     * The seats allocated to a party are calculated by this method in two steps:
     *      In the first step the corresponding number of votes that are attributable to a party is multiplied by the total number of available seats and divided by the total number of valid votes.
     *      In the second step the result is split into the integer portion and the rest. The integer parts are attributed to the respective party as seats. 
     *      The remaining seats are allocated to parties in the order of the size of the fractional portions.
     * 
     * @return boolean
     */
    public function calculate();
    
    /**
     * Sets parlament and calculate sum of all parties' votes.
     * 
     * @param AppBundle\Services\Interfaces\ParliamentInterface $parliament
     * @return \AppBundle\Entity\DistributionHandler
     */
    public function setParliament(ParliamentInterface $parliament);
    
    /**
     * 
     * @return AppBundle\Services\Interfaces\ParliamentInterface
     */
    public function getParliament();
    
    /**
     * Returns votes from all parties. 
     * 
     * @return int
     */
    public function getTotalVotes();
    
}