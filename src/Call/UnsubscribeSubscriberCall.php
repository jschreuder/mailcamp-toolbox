<?php

namespace jschreuder\MailCampToolbox\Call;

/**
 * API Call to unsubscribe an e-mail address form a mailinglist
 */
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

    /**
     * Voids the response, either succeeds or will throw an exception on failure
     *
     * @param   \SimpleXMLElement $response
     * @return  null
     */
    public function parseResponse(\SimpleXMLElement $response)
    {
        return null;
    }
}