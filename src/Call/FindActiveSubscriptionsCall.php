<?php

namespace jschreuder\MailCampToolbox\Call;

use jschreuder\MailCampToolbox\Entity\Subscription;

/**
 * API Call to retrieve all active subscriptions for an e-mail address
 */
class FindActiveSubscriptionsCall implements CallInterface
{
    /** @var  string */
    private $email;

    /**
     * @param  string $email
     */
    public function __construct($email)
    {
        $this->email = $email;
    }

    public function getType()
    {
        return 'subscribers';
    }

    public function getMethod()
    {
        return 'GetSubscribers';
    }

    public function getDetails()
    {
        return '
            <searchinfo>
                <List><array></array></List>
                <Email>'.$this->email.'</Email>
                <Confirmed>1</Confirmed>
                <Status>a</Status>
            </searchinfo>
            <sortinfo>
                <SortBy>Date</SortBy>
                <Direction>Down</Direction>
            </sortinfo>
        ';
    }

    /**
     * Returns a list of Subscription instances
     *
     * @param   \SimpleXMLElement $response
     * @return  Subscription[]
     */
    public function parseResponse(\SimpleXMLElement $response)
    {
        $subscriptions = [];
        foreach ($response->subscriberlist->item as $item) {
            $subscriptions[] = new Subscription(
                intval($item->subscriberid),
                strval($item->emailaddress),
                intval($item->listid),
                strval($item->listname),
                \DateTimeImmutable::createFromFormat('U', strval($item->subscribedate)),
                boolval($item->confirmed),
                $item->unsubscribed === 0 ? null : \DateTimeImmutable::createFromFormat('U', strval($item->unsubscribed)),
                boolval($item->bounced)
            );
        }
        return $subscriptions;
    }
}