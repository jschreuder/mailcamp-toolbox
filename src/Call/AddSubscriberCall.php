<?php

namespace jschreuder\MailCampToolbox\Call;

/**
 * API Call to subscribe an e-mail address to a mailinglist
 */
class AddSubscriberCall implements CallInterface
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
        return 'AddSubscriberToList';
    }

    public function getDetails()
    {
        return '
            <emailaddress>'.$this->email.'</emailaddress>
            <mailinglist>'.$this->listId.'</mailinglist>
            <format>html</format>
            <confirmed>yes</confirmed>
            <add_to_autoresponders>false</add_to_autoresponders>
            <customfields />
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