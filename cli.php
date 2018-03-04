<?php

require __DIR__ . '/vendor/autoload.php';

use MongoCLI\Command\Boot;
use Symfony\Component\Debug\Debug;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\CommandLoader\FactoryCommandLoader;

$application = new Application();

$env = new Dotenv\Dotenv(__DIR__);
$env->load();

$debug = getenv('APP_DEBUG');

if ($debug) {
    Debug::enable();
}

$commandLoader = new FactoryCommandLoader([
    'mongo:boot'   => function () { return new Boot(); },
    'mongo:client' => function () { return new \MongoCLI\Command\MongoClient(); },
]);

$input = new ArrayInput(array(
    'command' => 'mongo:boot',
));

$application->setCommandLoader($commandLoader);

try {
    $application->run($input);
} catch (\Exception $exception) {
    echo "Application error: \r\n $exception \r\n";
    exit(1);
}

exit(1);
