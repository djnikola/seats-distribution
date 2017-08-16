<?php
namespace AppBundle\Services\Interfaces;

use AppBundle\Entity\Party;

interface PartyHandlerInterface
{
    /**
     * Return all results for all states.
     * 
     * @return array of AppBundle\Entity\Party
     */
    function getAll();
    
    /**
     * Returns results for state $state.
     * 
     * @param string $state
     * @return array of AppBundle\Entity\Party
     */
    function getByState($state);
    
    /**
     * Saves party's results.
     * 
     * @param Party $party
     */
    function save(Party $party);
    
    /**
     * Delete party's result.
     * 
     * @param Party $party
     */
    function delete(Party $party);
}