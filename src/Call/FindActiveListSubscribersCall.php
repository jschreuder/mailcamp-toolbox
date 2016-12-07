<?php

namespace jschreuder\MailCampToolbox\Call;

use jschreuder\MailCampToolbox\Entity\Subscription;

class FindActiveListSubscribersCall implements CallInterface
{
    /** @var  int */
    private $listId;

    /**
     * @param  int $listId
     */
    public function __construct($listId)
    {
        $this->listId = $listId;
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
                <List><array>'.$this->listId.'</array></List>
                <Email></Email>
                <Confirmed>1</Confirmed>
                <Status>a</Status>
            </searchinfo>
            <sortinfo>
                <SortBy>Date</SortBy>
                <Direction>Down</Direction>
            </sortinfo>
        ';
    }

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