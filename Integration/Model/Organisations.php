<?php

class Organisation
{
    private $id;
    private $nomOrg;
    private $description;
    private $imagePath;

    // Constructor
    public function __construct($nomOrg, $description, $imagePath)
    {
        $this->nomOrg = $nomOrg;
        $this->description = $description;
        $this->imagePath = $imagePath;
    }

    // Getters and Setters
    public function getId()
    {
        return $this->id;
    }

    public function getNomOrg()
    {
        return $this->nomOrg;
    }

    public function setNomOrg($nomOrg)
    {
        $this->nomOrg = $nomOrg;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getImagePath()
    {
        return $this->imagePath;
    }

    public function setImagePath($imagePath)
    {
        $this->imagePath = $imagePath;
    }
}

?>
