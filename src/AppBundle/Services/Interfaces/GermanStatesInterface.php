<?php
namespace AppBundle\Services\Interfaces;

interface GermanStatesInterface
{
    /**
     * Returns array of all German states.
     * 
     * @return array
     */
    public function getAll();
    
    /**
     * Returns true if state is German state.
     * 
     * @param string $state
     * @return bool
     */
    public function isGermanState($state);
}