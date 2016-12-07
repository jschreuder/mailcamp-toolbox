<?php

namespace jschreuder\MailCampToolbox\Command;

use jschreuder\MailCampToolbox\Call\FindActiveListSubscribersCall;
use jschreuder\MailCampToolbox\Entity\Subscription;
use jschreuder\MailCampToolbox\MailCampClient;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CompareTxtToListCommand extends Command
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
        $this->setName('list:compare-txt')
            ->setDescription('Compare a mailinglist\'s subscribers to e-mail addresses in the TXT file')
            ->addArgument('txtFile', InputArgument::REQUIRED)
            ->addArgument('listId', InputArgument::REQUIRED);
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Loading...');
        $txtFile = $input->getArgument('txtFile');
        $listId = intval($input->getArgument('listId'));

        $output->writeln('Checking TXT file');
        if (!file_exists($txtFile) || !is_readable($txtFile)) {
            throw new \RuntimeException('Unreadable or non-existing TXT file: ' . $txtFile);
        }
        $txtHandle = fopen($txtFile, 'r');
        if (!is_resource($txtHandle)) {
            throw new \RuntimeException('Could not open TXT file: ' . $txtFile);
        }

        $output->writeln('Retrieving mailinglist subscribers for list with ID ' . $listId);
        /** @var  Subscription[] $subscribers */
        $subscribers = $this->mailcamp->process(new FindActiveListSubscribersCall($listId));
        $subscribers = array_map(function (Subscription $subscription) {
            return $subscription->getEmailAddress();
        }, $subscribers);
        if (count($subscribers) === 0) {
            throw new \RuntimeException('Empty mailinglist');
        }

        // Create list of matched and unmatched e-mail addresses based on TXT
        $notInMailCamp = [];
        $found = [];
        while (($line = fgets($txtHandle)) !== false) {
            $email = trim($line);

            // Skip empty or invalid e-mail addresses
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                continue;
            }

            $idx = array_search($email, $subscribers);
            if ($idx === false) {
                $notInMailCamp[] = $email;
            } else {
                $found[] = $email;
            }
        }

        // Create final list of e-mail addresses in MailCamp that were not in TXT file
        $notInTxt = array_diff($subscribers, $found);

        // GENERATE OUTPUT
        $output->writeln('');
        $output->writeln('--------------------------------------------------------------');
        $output->writeln('E-mail addresses in Mailcamp, not in TXT: ' . count($notInTxt));
        $output->writeln('--------------------------------------------------------------');
        foreach ($notInTxt as $email) {
            $output->writeln($email);
        }
        $output->writeln('');
        $output->writeln('--------------------------------------------------------------');
        $output->writeln('E-mail addresses in TXT, not in Mailcamp: ' . count($notInMailCamp));
        $output->writeln('--------------------------------------------------------------');
        foreach ($notInMailCamp as $email) {
            $output->writeln($email);
        }
        $output->writeln('');
        $output->writeln('--------------------------------------------------------------');
        $output->writeln('Total e-mail addresses matched: ' . count($found));
        $output->writeln('--------------------------------------------------------------');
        $output->writeln('');
    }
}