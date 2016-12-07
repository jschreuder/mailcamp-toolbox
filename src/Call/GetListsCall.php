<?php

namespace jschreuder\MailCampToolbox\Call;

use jschreuder\MailCampToolbox\Entity\MailingList;

class GetListsCall implements CallInterface
{
    public function getType()
    {
        return 'user';
    }

    public function getMethod()
    {
        return 'GetLists';
    }

    public function getDetails()
    {
        return '
            <lists />
            <sortinfo />
            <countonly />
            <start />
            <perpage />
        ';
    }

    public function parseResponse(\SimpleXMLElement $response)
    {
        $lists = [];
        foreach ($response->item as $item) {
            $lists[] = new MailingList(
                intval($item->listid),
                strval($item->name),
                strval($item->ownername),
                strval($item->owneremail),
                strval($item->replytoemail)
            );
        }
        return $lists;
    }
}
