<?php

class Votes
{
    private $id;
    private $userIdentifier;
    private $announceId;
    private $voteValue;
    private $timestamp;

    public function getId()
    {
        return $this->id;
    }

    

    public function getUserIdentifier()
    {
        return $this->userIdentifier;
    }

    public function setUserIdentifier($userIdentifier)
    {
        $this->userIdentifier = $userIdentifier;
    }

    public function getAnnounceId()
    {
        return $this->announceId;
    }

    public function setAnnounceId($announceId)
    {
        $this->announceId = $announceId;
    }

    public function getVoteValue()
    {
        return $this->voteValue;
    }

    public function setVoteValue($voteValue)
    {
        $this->voteValue = $voteValue;
    }

    public function getTimestamp()
    {
        return $this->timestamp;
    }

    
}
