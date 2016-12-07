<?php

namespace jschreuder\MailCampToolbox\Command;

use jschreuder\MailCampToolbox\Entity\Subscription;
use jschreuder\MailCampToolbox\MailCampClient;
use jschreuder\MailCampToolbox\Message\FindActiveSubscriptionsCall;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FindActiveSubscriptionsCommand extends Command
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
        $this->setName('subscriber:find')
            ->addArgument('email', InputArgument::REQUIRED);
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var  Subscription[] $subscriptions */
        $subscriptions = $this->mailcamp->process(new FindActiveSubscriptionsCall($email = $input->getArgument('email')));
        foreach ($subscriptions as $subscription) {
            $output->writeln($subscription->getEmailAddress() . ' is in list ' . $subscription->getListName());
        }
    }
}