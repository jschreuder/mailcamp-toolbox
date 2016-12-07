<?php

namespace jschreuder\MailCampToolbox\Command;

use jschreuder\MailCampToolbox\Entity\Subscription;
use jschreuder\MailCampToolbox\MailCampClient;
use jschreuder\MailCampToolbox\Message\FindActiveListSubscribersCall;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FindActiveListSubscribersCommand extends Command
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
        $this->setName('subscriber:list')
            ->addArgument('listId', InputArgument::REQUIRED);
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var  Subscription[] $subscriptions */
        $subscriptions = $this->mailcamp->process(new FindActiveListSubscribersCall($listId = $input->getArgument('listId')));
        $output->writeln('List ' . $listId . ' has these subscribers:');
        foreach ($subscriptions as $subscription) {
            $output->writeln('- ' . $subscription->getEmailAddress());
        }
    }
}