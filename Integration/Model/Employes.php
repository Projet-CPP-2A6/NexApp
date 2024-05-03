<?php

class Employes
{
    private $id;
    private $nom;
    private $prenom;
    private $matricule;
    private $depart;
    private $poste;
    private $dateEmb;
    private $statut;

    public function getId()
    {
        return $this->id;
    }

    

    public function getNom()
    {
        return $this->nom;
    }

    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    public function getPrenom()
    {
        return $this->prenom;
    }

    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }

    public function getMatricule()
    {
        return $this->matricule;
    }

    public function setMatricule($matricule)
    {
        $this->matricule = $matricule;
    }

    public function getDepart()
    {
        return $this->depart;
    }

    public function setDepart($depart)
    {
        $this->depart = $depart;
    }

    public function getPoste()
    {
        return $this->poste;
    }

    public function setPoste($poste)
    {
        $this->poste = $poste;
    }

    public function getDateEmb()
    {
        return $this->dateEmb;
    }

 
}