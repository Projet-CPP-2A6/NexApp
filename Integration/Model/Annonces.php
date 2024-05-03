<?php

class Annonces
{
    private $idAnnonces;
    private $image;
    private $titre;
    private $description;
    private $date;
    private $commentCount;

    public function getIdAnnonces()
    {
        return $this->idAnnonces;
    }

    public function setIdAnnonces($idAnnonces)
    {
        $this->idAnnonces = $idAnnonces;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }

    public function getTitre()
    {
        return $this->titre;
    }

    public function setTitre($titre)
    {
        $this->titre = $titre;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date)
    {
        $this->date = $date;
    }

    public function getCommentCount()
    {
        return $this->commentCount;
    }

    public function setCommentCount($commentCount)
    {
        $this->commentCount = $commentCount;
    }
}
?>