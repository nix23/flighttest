<?php
namespace Ntech\CoreBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class TestCommand extends ContainerAwareCommand
{
    private $container;
    private $em;
    private $getProxyCmd;

    public function __construct($container)
    {
        $this->container = $container;
        $this->em = $container->get('doctrine.orm.entity_manager');

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('ntech:test')
            ->setDescription('Test.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {   
        echo "test";
    }
}