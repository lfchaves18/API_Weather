<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;

class TimeCommand extends Command 
{
    protected function configure()
    {
        $this->setName('time')
            ->setDescription('Exibe data e hora atual')
            ->setHelp('Este comando exibe a data e hora atual')
            ->addOption(
                'fmt',
                null,
                InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY,
                'Qual o formato desejado?',
                ['std', 'dmy', 'ymd']
            )
            ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $optionValue = $input->getOption('fmt')[0];

        switch( $optionValue ) {
            case 'dmy':
                 $now = date('d-m-Y H:i:s');
                 break;
            case 'ymd':
                 $now = date('Y-m-d H:i:s');
                 break;
            default:
                 $now = date('c');
                 break;  
        }

        $output->writeln( sprintf("Formato selecionado: %s ", $optionValue ) );

        $message = sprintf("Data e hora atual: %s", $now);
        $output->writeln($message);
        return Command::SUCCESS;
    }
}