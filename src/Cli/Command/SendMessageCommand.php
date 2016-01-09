<?php
namespace Cli\Command;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Telegram\Bot\Api;
class SendMessageCommand extends Command {
    protected function configure()
    {
        $this
            ->setName('sendmsg')
            ->setDescription('Send a message to telegram')
            ->addArgument(
                'arguments',
                InputArgument::REQUIRED,
                'Arguments to method sendMessage of Telegram bot api'
            );
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $arguments = $input->getArgument('arguments');
        $arguments = unserialize(base64_decode($arguments));
        if(!$arguments) {
            $output->writeln('<error>Invalid params</error>');
            return;
        }
        $telegram = new Api($arguments['token']);
        $telegram->sendMessage($arguments['params']);
    }
}