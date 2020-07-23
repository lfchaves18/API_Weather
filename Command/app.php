<?php

include __DIR__ . '/vendor/autoload.php';

date_default_timezone_set('America/Sao_Paulo');

use Symfony\Component\Console\Application;
use App\Command\TimeCommand;

$app = new Application('Console Lucas App', 'v1.0.0');
$app->add( new TimeCommand() );
$app->run();