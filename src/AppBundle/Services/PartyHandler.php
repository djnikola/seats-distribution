<?php
namespace AppBundle\Services;
use AppBundle\Services\Interfaces\PartyHandlerInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Party;

class PartyHandler implements PartyHandlerInterface
{
    /**
     *
     * @var \Doctrine\Common\Persistence\ObjectManager 
     */
    private $om;
    
    /**
     *
     * @var string
     */
    private $entityClass;
    
    /**
     *
     * @var \Doctrine\Common\Persistence\ObjectRepository 
     */
    private $repository;
    
    /**
     * 
     * @param ObjectManager $om
     * @param string $entityClass
     */
    public function __construct(ObjectManager $om, $entityClass)
    {
        $this->om = $om;
        $this->entityClass = $entityClass;
        $this->repository = $this->om->getRepository($this->entityClass);
    }
    
    /**
     * 
     * {@inheritdoc}
     */
    public function getAll() 
    {
        $allStates = $this->om->getRepository($this->entityClass)->findAll();
        return $allStates;
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function getByState($state) 
    {
        $parties = $this->om->getRepository($this->entityClass)->findBy(['state' => $state]);
        return $parties;
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function save(Party $party) 
    {
        if ($party->getSeats() > 0)
        {
            $this->om->persist($party);
            $this->om->flush();
        }
    }
    
    /**
     * 
     * {@inheritdoc}
     */
    public function delete(Party $party) 
    {
        $this->om->remove($party);
        $this->om->flush();
    }

}