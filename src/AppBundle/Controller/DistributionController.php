<?php

namespace AppBundle\Controller;
 
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Services\DistributionHandler;
use Doctrine\ORM\EntityManagerInterface;
use \AppBundle\Entity\Party;
use \AppBundle\Services;
use \AppBundle\Services\GermanStates;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use AppBundle\Entity\Votes;
use GuzzleHttp\Client;

class DistributionController extends FOSRestController
{
    
    /**
     * Get all results from all states.
     * 
     * @ApiDoc(
     *  statusCodes={
     *         200="Returned when successful",
     *  },
     *  tags={
     *         "in-development"
     *  },
     *  resource=true,
     *  description="Returns a collection of Parties for all states",
     * )
     * 
     * @Rest\Get("/distribution/")
     * @return array of \AppBundle\Entity\Party
     */
    public function getAction()
    {
        $allStates = $this->container->get('app_bundle.services.party_handler')->getAll();
        return $allStates;
    }
    
    /**
     * Get results from single $state.
     * 
     * @ApiDoc(
     *  statusCodes={
     *         200="Returned when successful.",
     *         404="When state does not exists."
     *  },
     *  requirements={
     *      {
     *          "name"="state",
     *          "dataType"="string",
     *          "description"="One of German's federal state."
     *      }
     *  },
     *  tags={
     *         "in-development"
     *  },
     *  
     *  resource=true,
     *  description="Returns a collection of Parties for given state",
     * )
     * 
     * @Rest\Get("/distribution/state/{state}/")
     */
    public function getStateAction($state)
    {
        $statesService = $this->container->get('app_bundle.services.german_states');
        if (!$statesService->isGermanState($state))
        {
            return $this->view("State '$state' does not exists!", 404);
        }
        
        $parties = $this->container->get('app_bundle.services.party_handler')->getByState($state);
        return $parties;
    }
    
    
    /**
     * Post results for single $state.
     * 
     * @ApiDoc(
     *  statusCodes={
     *         200="Returned when successful.",
     *         404="When state does not exists."
     *  },
     *  tags={
     *         "in-development"
     *  },
     *  requirements={
     *      {
     *          "name"="seats_num",
     *          "dataType"="integer",
     *          "requirement"="\d+",
     *          "description"="how many seats in parliament"
     *      },
     *      {
     *          "name"="state",
     *          "dataType"="string",
     *          "description"="name of german state"
     *      },
     *      {
     *          "name"="parties",
     *          "dataType"="array",
     *          "description"="{'A': 1000, 'B': 2500}"
     *      }
     *  },
     *  description="Post votes in state and trigers parliament's seats calculation",
     * ),
     * @Rest\Post("/distribution/")
     */
    public function postAction(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $state = $data["state"];
        
        $statesService = $this->container->get('app_bundle.services.german_states');
        if (!$statesService->isGermanState($state))
        {
            return $this->view("State '$state' does not exists!", 404);
        }
        
        $parties = $this->container->get('app_bundle.services.party_handler')->getByState($state);
        if (count($parties) > 0)
        {
            //already inserted.
            return $this->view("Parliament for this state '$state' already exists!", 404);
        }
        
        
        $parliament = $this->container->get("app_bundle.services.parliament")->init($data['seats_num']);

        if (is_array($data['parties']) && count($data['parties']) > 0)
        {
            foreach($data['parties'] as $name => $votes)
            {
                $party = new \AppBundle\Entity\Party();
                $party->setName($name)
                    ->setVotes($votes)
                    ->setState($state);
                $parliament->add($party);
            }
        }

        $distributionHandler = $this->container->get('app_bundle.services.distribution_handler');
        $distributionHandler->setParliament($parliament);
        $distributionHandler->calculate();
        
        //save.
        $parties = $distributionHandler->getParliament()->getParties();
        foreach($parties as $party)
        {
            $this->container->get('app_bundle.services.party_handler')->save($party);
        }
        
        return $distributionHandler->getParliament()->getParties();
    }
    
    
    /**
     * Update results for single $state.
     * 
     * @ApiDoc(
     *  statusCodes={
     *         200="Returned when successful.",
     *         404="When state does not exists."
     *  },
     *  tags={
     *         "in-development"
     *  },
     *  input="body",
     *  description="Updates votes in state and trigers parliament's seats calculation",
     * ),
     * @Rest\Put("/distribution/")
     */
    public function putAction(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $state = $data["state"];
        
        $statesService = $this->container->get('app_bundle.services.german_states');
        if (!$statesService->isGermanState($state))
        {
            return $this->view("State '$state' does not exists!", 404);
        }
        
        $parties = $this->container->get('app_bundle.services.party_handler')->getByState($state);
        if (count($parties) === 0)
        {
            //already inserted.
            return $this->view("Parliament for this state '$state' doesn't exists!", 404);
        }
        
        //delete.
        foreach($parties as $party)            
        {
            $this->container->get('app_bundle.services.party_handler')->delete($party);
        }
        
        $parliament = $this->container->get("app_bundle.services.parliament")->init($data['seats_num']);

        if (is_array($data['parties']) && count($data['parties']) > 0)
        {
            foreach($data['parties'] as $name => $votes)
            {
                $party = new \AppBundle\Entity\Party();
                $party->setName($name)
                    ->setVotes($votes)
                    ->setState($state);
                $parliament->add($party);
            }
        }

        $distributionHandler = $this->container->get('app_bundle.services.distribution_handler');
        $distributionHandler->setParliament($parliament);
        $distributionHandler->calculate();
        
        //save.
        $parties = $distributionHandler->getParliament()->getParties();
        foreach($parties as $party)
        {
            $this->container->get('app_bundle.services.party_handler')->save($party);
        }
        
        return $distributionHandler->getParliament()->getParties();
    }
    
    
    /**
     * Deletes parties in state's parlament.
     * 
     * @ApiDoc(
     *  statusCodes={
     *         200="Returned when successful.",
     *         404="When state does not exists."
     *  },
     *  requirements={
     *      {
     *          "name"="state",
     *          "dataType"="string",
     *          "description"="One of German's federal state."
     *      }
     *  },
     *  tags={
     *         "in-development"
     *  },
     *  example={
     * 
     *  },
     *  resource=true,
     *  description="Deletes a collection of Parties for given state",
     * )
     * @Rest\Delete("/distribution/state/{state}/")
     */
    public function deleteStateAction($state)
    {
        $statesService = $this->container->get('app_bundle.services.german_states');
        if (!$statesService->isGermanState($state))
        {
            return $this->view("State '$state' does not exists!", 404);
        }

        $parties = $this->container->get('app_bundle.services.party_handler')->getByState($state);
        if (!is_array($parties) || count($parties) === 0)
        {
            return $this->view("There are no parties in state '$state' !", 200);
        }
        foreach($parties as $party)            
        {
            $this->container->get('app_bundle.services.party_handler')->delete($party);
        }
        return $this->view("Deleting successfully done!", 200);
    }

}