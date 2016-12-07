<?php

namespace jschreuder\MailCampToolbox;

use Guzzle\Http\Client;
use jschreuder\MailCampToolbox\Message\CallInterface;

class MailCampClient
{
    /** @var  Client */
    private $httpClient;

    /** @var  string */
    private $username;

    /** @var  string */
    private $token;

    /**
     * @param  Client $httpClient
     * @param  string $username
     * @param  string $token
     */
    public function __construct(Client $httpClient, $username, $token)
    {
        $this->httpClient = $httpClient;
        $this->username = $username;
        $this->token = $token;
    }

    public function process(CallInterface $message)
    {
        $xml = $this->createXml($message);
        $response = $this->httpClient->post(null, null, ['xml' => $xml])->send()->xml();
        if (strval($response->status) !== 'SUCCESS') {
            throw new \RuntimeException('Getting response from MailCamp failed: ' . $response->errormessage);
        }

        return $message->parseResponse($response->data);
    }

    private function createXml(CallInterface $message)
    {
        return '
            <xmlrequest>
                <username>'.$this->username.'</username>
                <usertoken>'.$this->token.'</usertoken>
                <requesttype>'.$message->getType().'</requesttype>
                <requestmethod>'.$message->getMethod().'</requestmethod>
                <details>
                    '.$message->getDetails().'
                </details>
            </xmlrequest>
        ';
    }
}
