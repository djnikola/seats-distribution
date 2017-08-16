<?php
namespace AppBundle\Services;

use AppBundle\Entity\Party;
use AppBundle\Services\Interfaces\ParliamentInterface;
use Exception;

class Parliament implements ParliamentInterface
{
    /**
     * Number of seats in parliament.
     *
     * @var int
     */
    private $seatsNum;    
    
    /**
     * key: party_name
     * value: AppBundle\Entity\Party
     * 
     * @var array
     */
    private $parties = [];
    
    function __construct() 
    {
        
    }
    
    /**
     * 
     * {@inheritdoc}
     */
    public function init($seatsNum)
    {
        $this->seatsNum = $seatsNum;
        return $this;
    }
    
    /**
     * 
     * {@inheritdoc}
     */
    public function add(Party $party)
    {
        if(key_exists($party->getName(), $this->parties))
        {
            throw new Exception("Party already exists in Parliament", 500);
        }
        $this->parties[$party->getName()] = $party;
    }
    
    /**
     * 
     * {@inheritdoc}
     */
    public function isEmpty()
    {
        return (count($this->parties) == 0);
    }
    
    /**
     * 
     * {@inheritdoc}
     */
    public function getParties()
    {
        return $this->parties;
    }
    
    /**
     * 
     * {@inheritdoc}
     */
    public function getPartyByName($name)
    {
        if(!key_exists($name, $this->parties))
        {
            throw new Exception;
        }
        
        return $this->parties[$name];
    }
    
    /**
     * 
     * {@inheritdoc}
     */
    public function getSeatsNum()
    {
        return $this->seatsNum;
    }

}