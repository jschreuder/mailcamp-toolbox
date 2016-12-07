<?php

namespace jschreuder\MailCampToolbox\Command;

use jschreuder\MailCampToolbox\Entity\MailingList;
use jschreuder\MailCampToolbox\MailCampClient;
use jschreuder\MailCampToolbox\Call\GetListsCall;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GetListsCommand extends Command
{
    /** @var  MailCampClient */
    private $mailcamp;

    public function __construct(MailCampClient $mailCamp)
    {
        $this->mailcamp = $mailCamp;
        parent::__construct();
    }

    public function configure()
    {
        $this->setName('list:list');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var  MailingList[] $lists */
        $lists = $this->mailcamp->process(new GetListsCall());
        foreach ($lists as $list) {
            $output->writeln('List ' . $list->getId() . ': ' . $list->getName());
        }
    }
}