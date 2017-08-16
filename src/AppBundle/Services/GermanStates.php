<?php
namespace AppBundle\Services;

use AppBundle\Services\Interfaces\GermanStatesInterface;

class GermanStates implements GermanStatesInterface
{
    /**
     * {@inheritdoc}
     */
    public function getAll()
    {
        return [
            "Baden-Württemberg",
            "Bavaria",
            "Berlin",
            "Brandenburg",
            "Bremen",
            "Hamburg",
            "Hesse",
            "Lower Saxony",
            "Mecklenburg-Vorpommern",
            "North Rhine-Westphalia",
            "Rhineland-Palatinate",
            "Saarland",
            "Saxony",
            "Saxony-Anhalt",
            "Schleswig-Holstein",
            "Thuringia"
        ];
    }
    
    /**
     *{@inheritdoc}
     */
    public function isGermanState($state)
    {
        $states = $this->getAll();
        return (in_array($state, $states));
    }
}