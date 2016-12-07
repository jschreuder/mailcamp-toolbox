<?php

namespace jschreuder\MailCampToolbox\Call;

interface CallInterface
{
    /** @return  string */
    public function getType();

    /** @return  string */
    public function getMethod();

    /** @return  string */
    public function getDetails();

    /**
     * Parse response into something usable
     *
     * @param   \SimpleXMLElement $response
     * @return  mixed
     */
    public function parseResponse(\SimpleXMLElement $response);
}