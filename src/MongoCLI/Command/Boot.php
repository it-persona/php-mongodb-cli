<?php

namespace MongoCLI\Command;

use MongoCLI\Database\Connection;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class Boot
 * @package MongoCLI\Command
 */
class Boot extends Command
{
    protected function configure()
    {
        $this
            ->setName('mongo:boot')
            ->setDescription('Connect to MongoDB server')
            ->setHelp('This command create connection to MongoDB server')
        ;
    }

    /**
     * Boot mongo shell
     * ----------------
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @param null $collectionsNames
     * @return int|null|void
     * @throws \Exception
     */
    public function execute(InputInterface $input, OutputInterface $output, $collectionsNames = null)
    {
        $connection = new Connection();

        $output->writeln([
            '<comment>',
            'PHP MongoDB Client (CLI) version: 1.0',
            '</comment>'
        ]);

        $output->writeln('<info>Connected to database: </info><comment>'.$connection->getDatabaseName().'</comment>');

        $output->writeln([
            '<info>Collections:</info>',
        ]);

        $collections = $connection->getCollections();

        foreach ($collections as $collection) {
            $collectionName = $collection->getName();
            $collectionSize = $connection->getCollection($collectionName)->count();
            $output->writeln('  <comment>'.$collectionName.'['.$collectionSize.']'.'</comment>');
        }

        $this->shell($input, $output);
    }

    /**
     * MongoDB shell
     * -------------
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @throws \Exception
     */
    public function shell(InputInterface $input, OutputInterface $output)
    {
        $command = $this->getApplication()->find('mongo:client');
        $arguments = array(
            'command' => 'mongo:client',
        );

        $greetInput = new ArrayInput($arguments);
        $returnCode = $command->run($greetInput, $output);

        if ($returnCode == 0) {
            $this->shell($input, $output);
        }
    }
}
