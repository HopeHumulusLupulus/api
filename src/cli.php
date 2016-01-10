<?php
use Symfony\Component\Console\Application;
use Cli\Command\SendMessageCommand;
require __DIR__.'/../vendor/autoload.php';

$application = new Application();
$application->add(new SendMessageCommand());
$application->run();