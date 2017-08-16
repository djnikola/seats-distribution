<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="party")
 */
class Party
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $votes;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $seats;
    
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $state;
    
    /**
     * Get id.
     * 
     * @return int
     */
    function getId() 
    {
        return $this->id;
    }

    /**
     * Set id.
     * 
     * @param int $id
     * @return \AppBundle\Entity\Party
     */
    function setId($id) 
    {
        $this->id = $id;
        return $this;
    }

        
    /**
     * Get name.
     * 
     * @return string
     */
    function getName() {
        return $this->name;
    }

    /**
     * Get votes.
     * 
     * @return int
     */
    function getVotes() {
        return $this->votes;
    }

    /**
     * Get seats.
     * 
     * @return int
     */
    function getSeats() {
        return $this->seats;
    }

    /**
     * Set name.
     * 
     * @param string $name
     * @return \AppBundle\Entity\Party
     */
    function setName($name) {
        $this->name = $name;
        return $this;
    }

    /**
     * Set votes.
     * 
     * @param int $votes
     * @return \AppBundle\Entity\Party
     */
    function setVotes($votes) {
        $this->votes = $votes;
        return $this;
    }

    /**
     * Set seats
     * 
     * @param int $seats
     * @return \AppBundle\Entity\Party
     */
    function setSeats($seats) {
        $this->seats = $seats;
        return $this;
    }
    
    /**
     * Get state
     * 
     * @return string
     */
    function getState() 
    {
        return $this->state;
    }

    /**
     * Set state.
     * 
     * @param string $state
     * @return \AppBundle\Entity\Party
     */
    function setState($state) 
    {
        $this->state = $state;
        return $this;
    }

    /**
     * Increment seats.
     * 
     * @return \AppBundle\Entity\Party
     */
    function incSeats()
    {
        $this->seats++;
        return $this;
    }

}