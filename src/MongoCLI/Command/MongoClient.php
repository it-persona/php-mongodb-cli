<?php

namespace MongoCLI\Command;

use MongoCLI\Database\Grammar;
use MongoCLI\Database\Connection;
use MongoCLI\Database\QueryBuilder;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class MongoClient
 * @package MongoCLI\Command
 */
class MongoClient extends Command
{
    /**
     * @var string
     */
    private $host;

    /**
     * @var integer|string
     */
    private $port;

    /**
     * @var string
     */
    private $database;

    public function __construct()
    {
        $this->host = getenv('DB_HOST');
        $this->port = getenv('DB_PORT');
        $this->database = getenv('DB_NAME');
        parent::__construct();
    }

    /**
     * Command configuration
     * ---------------------
     */
    protected function configure()
    {
        $this
            ->setName('mongo:client')
            ->setDescription('PHP MongoDB CLI Client')
            ->setHelp('This command run MongoDB client shell')
        ;
    }

    /**
     * Execute database queries
     * ------------------------
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $grammar = new Grammar();
        $connection = new Connection();
        $queryBuilder = new QueryBuilder($connection);
        $helper = $this->getHelper('question');

        $output->writeln([
            '',
            '<comment>Enter your query with MySQL syntax like:</comment>'
        ]);

        $q = new Question('<info>> </info>', 'select * from projects');
        $query = $helper->ask($input, $output, $q);

        if($query == 'exit' || $query == 'quit' || $query == 'logout') {
            $output->writeln([
                '<info>',
                'Bye-Bye',
                '</info>',
            ]);

            exit(1);
        }

        var_dump($queryBuilder->run($grammar->setQuery($query)));
    }
}
