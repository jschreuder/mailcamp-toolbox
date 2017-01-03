<?php

namespace jschreuder\MailCampToolbox\Command;

use jschreuder\MailCampToolbox\Call\FindActiveSubscriptionsCall;
use jschreuder\MailCampToolbox\Entity\Subscription;
use jschreuder\MailCampToolbox\MailCampClient;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GetSubscriptionsCommand extends Command
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
        $this->setName('subscriber:find-all')
            ->setDescription('Get all subscriptions for e-mail addresses in the TXT file')
            ->addArgument('txtFile', InputArgument::REQUIRED)
            ->addArgument('contains', InputArgument::OPTIONAL, 'Only show subscriptions to lists containing this value');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Loading...');
        $txtFile = $input->getArgument('txtFile');
        $contains = $input->getArgument('contains');

        $output->writeln('Checking TXT file');
        if (!file_exists($txtFile) || !is_readable($txtFile)) {
            throw new \RuntimeException('Unreadable or non-existing TXT file: ' . $txtFile);
        }
        $txtHandle = fopen($txtFile, 'r');
        if (!is_resource($txtHandle)) {
            throw new \RuntimeException('Could not open TXT file: ' . $txtFile);
        }

        while (($line = fgets($txtHandle)) !== false) {
            $email = trim($line);

            // Skip empty or invalid e-mail addresses
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                continue;
            }

            /** @var  Subscription[] $lists */
            $lists = $this->mailcamp->process(new FindActiveSubscriptionsCall($email));
            if ($contains) {
                foreach ($lists as $idx => $list) {
                    if (strpos($list->getListName(), $contains) === false) {
                        unset($lists[$idx]);
                    }
                }
            }
            if (count($lists) === 0) {
                continue;
            }

            $output->writeln('EMAIL: ' . $email);
            foreach ($lists as $list) {
                $output->writeln(' - ' . $list->getListName());
            }
        }
    }
}