<?php

namespace jschreuder\MailCampToolbox\Entity;

class MailingList
{
    /** @var  int */
    private $id;

    /** @var  string */
    private $name;

    /** @var  string */
    private $owner;

    /** @var  string */
    private $emailFrom;

    /** @var  string */
    private $emailReplyTo;

    /**
     * @param  int $id
     * @param  string $name
     * @param  string $owner
     * @param  string $emailFrom
     * @param  string $emailReplyTo
     */
    public function __construct($id, $name, $owner, $emailFrom, $emailReplyTo)
    {
        $this->id = $id;
        $this->name = $name;
        $this->owner = $owner;
        $this->emailFrom = $emailFrom;
        $this->emailReplyTo = $emailReplyTo;
    }

    /** @return  int */
    public function getId()
    {
        return $this->id;
    }

    /** @return  string */
    public function getName()
    {
        return $this->name;
    }

    /** @return  string */
    public function getOwner()
    {
        return $this->owner;
    }

    /** @return  string */
    public function getEmailFrom()
    {
        return $this->emailFrom;
    }

    /** @return  string */
    public function getEmailReplyTo()
    {
        return $this->emailReplyTo;
    }
}