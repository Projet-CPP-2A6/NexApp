<?php

class Societe
{
    private $id;
    private $matricule;
    private $nomSoc;
    private $descSoc;
    private $imagePath;
    private $organisationAff;

    // Constructor
    public function __construct($matricule, $nomSoc, $descSoc, $imagePath, $organisationAff)
    {
        $this->matricule = $matricule;
        $this->nomSoc = $nomSoc;
        $this->descSoc = $descSoc;
        $this->imagePath = $imagePath;
        $this->organisationAff = $organisationAff;
    }

    // Getters and Setters
    public function getId()
    {
        return $this->id;
    }

    public function getMatricule()
    {
        return $this->matricule;
    }

    public function setMatricule($matricule)
    {
        $this->matricule = $matricule;
    }

    public function getNomSoc()
    {
        return $this->nomSoc;
    }

    public function setNomSoc($nomSoc)
    {
        $this->nomSoc = $nomSoc;
    }

    public function getDescSoc()
    {
        return $this->descSoc;
    }

    public function setDescSoc($descSoc)
    {
        $this->descSoc = $descSoc;
    }

    public function getImagePath()
    {
        return $this->imagePath;
    }

    public function setImagePath($imagePath)
    {
        $this->imagePath = $imagePath;
    }

    public function getOrganisationAff()
    {
        return $this->organisationAff;
    }

    public function setOrganisationAff($organisationAff)
    {
        $this->organisationAff = $organisationAff;
    }
}
?>
