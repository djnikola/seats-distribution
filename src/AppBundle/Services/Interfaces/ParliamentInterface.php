<?php
namespace AppBundle\Services\Interfaces;

interface ParliamentInterface
{
    /**
     * @param int $seatsNum
     * @return ParliamentInterface
     */
    public function init($seatsNum);
    
    /**
     * Add party.
     * 
     * @param \AppBundle\Entity\Party $party
     * @throws Exception
     */
    public function add(\AppBundle\Entity\Party $party);
    
    /**
     * Returns true if there are no parties.
     * 
     * @return bool
     */
    public function isEmpty();
    
    /**
     * Returns array of Parties. 
     * 
     * @return array
     */
    public function getParties();
    
    /**
     * Returns party by name.
     * 
     * @param string $name
     * @return AppBundle\Entity\Party
     * @throws Exception
     */
    public function getPartyByName($name);
    
    /**
     * Returns number of seats.
     * 
     * @return int
     */
    public function getSeatsNum();

}