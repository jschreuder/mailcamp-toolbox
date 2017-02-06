<?php

namespace jschreuder\MailCampToolbox\Command;

use jschreuder\MailCampToolbox\MailCampClient;
use jschreuder\MailCampToolbox\Call\AddSubscriberCall;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AddSubscriberCommand extends Command
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
        $this->setName('subscriber:add')
            ->addArgument('email', InputArgument::REQUIRED)
            ->addArgument('listId', InputArgument::REQUIRED);
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->mailcamp->process(new AddSubscriberCall(
            $email = $input->getArgument('email'),
            $listId = $input->getArgument('listId')
        ));
        $output->writeln('Added ' . $email . ' to list with ID ' . $listId);
    }
}