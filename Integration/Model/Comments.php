<?php

class CommentEntity
{
    private $idComments;
    private $descComment;
    private $idAnnonces; 

    public function getIdComments()
    {
        return $this->idComments;
    }


    public function getDescComment()
    {
        return $this->descComment;
    }

    public function setDescComment($descComment)
    {
        $this->descComment = $descComment;
    }

    public function getIdAnnonces()
    {
        return $this->idAnnonces;
    }

    public function setIdAnnonces($idAnnonces)
    {
        $this->idAnnonces = $idAnnonces;
    }
}
?>
