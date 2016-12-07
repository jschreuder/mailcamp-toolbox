<?php

namespace jschreuder\MailCampToolbox\Call;

class UnsubscribeSubscriberCall implements CallInterface
{
    /** @var  string */
    private $email;

    /** @var  string */
    private $listId;

    /**
     * @param  string $email
     * @param  string $listId
     */
    public function __construct($email, $listId)
    {
        $this->email = $email;
        $this->listId = $listId;
    }

    public function getType()
    {
        return 'subscribers';
    }

    public function getMethod()
    {
        return 'UnsubscribeSubscriber';
    }

    public function getDetails()
    {
        return '
            <emailaddress>'.$this->email.'</emailaddress>
			<listid>'.$this->listId.'</listid>
        ';
    }

    public function parseResponse(\SimpleXMLElement $response)
    {
        return null;
    }
}