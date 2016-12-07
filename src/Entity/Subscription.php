<?php

namespace jschreuder\MailCampToolbox\Entity;

class Subscription
{
    /** @var  int */
    private $id;

    /** @var  string */
    private $emailAddress;

    /** @var  int */
    private $listId;

    /** @var  string */
    private $listName;

    /** @var  \DateTimeInterface */
    private $subscribeDate;

    /** @var  bool */
    private $confirmed;

    /** @var  \DateTimeInterface|null */
    private $unsubscribed;

    /** @var  bool */
    private $bounced;

    /**
     * @param  int $id
     * @param  string $emailAddress
     * @param  int $listId
     * @param  string $listName
     * @param  \DateTimeInterface $subscribeDate
     * @param  bool $confirmed
     * @param  \DateTimeInterface|null $unsubscribed
     * @param  bool $bounced
     */
    public function __construct(
        $id,
        $emailAddress,
        $listId,
        $listName,
        \DateTimeInterface $subscribeDate,
        $confirmed,
        \DateTimeInterface $unsubscribed = null,
        $bounced
    )
    {
        $this->id = $id;
        $this->emailAddress = $emailAddress;
        $this->listId = $listId;
        $this->listName = $listName;
        $this->subscribeDate = $subscribeDate;
        $this->confirmed = $confirmed;
        $this->unsubscribed = $unsubscribed;
        $this->bounced = $bounced;
    }

    /** @return  int */
    public function getId()
    {
        return $this->id;
    }

    /** @return  string */
    public function getEmailAddress()
    {
        return $this->emailAddress;
    }

    /** @return  int */
    public function getListId()
    {
        return $this->listId;
    }

    /** @return  string */
    public function getListName()
    {
        return $this->listName;
    }

    /** @return  \DateTimeInterface */
    public function getSubscribeDate()
    {
        return $this->subscribeDate;
    }

    /** @return  bool */
    public function isConfirmed()
    {
        return $this->confirmed;
    }

    /** @return  \DateTimeInterface|null */
    public function getUnsubscribed()
    {
        return $this->unsubscribed;
    }

    /** @return  bool */
    public function getBounced()
    {
        return $this->bounced;
    }
}
