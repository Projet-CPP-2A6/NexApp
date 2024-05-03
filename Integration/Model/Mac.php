<?php

class Mac
{
    private $idMac;
    private $nom;
    private $email;
    private $numero;
    private $societe;
    private $matricule;
    private $pays;
    private $region;
    private $postcode;
    private $categorieId; 

    public function getIdMac()
    {
        return $this->idMac;
    }


    public function getNom()
    {
        return $this->nom;
    }

    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getNumero()
    {
        return $this->numero;
    }

    public function setNumero($numero)
    {
        $this->numero = $numero;
    }

    public function getSociete()
    {
        return $this->societe;
    }

    public function setSociete($societe)
    {
        $this->societe = $societe;
    }

    public function getMatricule()
    {
        return $this->matricule;
    }

    public function setMatricule($matricule)
    {
        $this->matricule = $matricule;
    }

    public function getPays()
    {
        return $this->pays;
    }

    public function setPays($pays)
    {
        $this->pays = $pays;
    }

    public function getRegion()
    {
        return $this->region;
    }

    public function setRegion($region)
    {
        $this->region = $region;
    }

    public function getPostcode()
    {
        return $this->postcode;
    }

    public function setPostcode($postcode)
    {
        $this->postcode = $postcode;
    }

    public function getCategorieId()
    {
        return $this->categorieId;
    }

    public function setCategorieId($categorieId)
    {
        $this->categorieId = $categorieId;
    }
}
?>
