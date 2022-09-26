<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;
use Ntech\CoreBundle\Doctrine\Type\UTCDateTimeType;
use Doctrine\DBAL\Types\Type;
use Symfony\Component\VarDumper\VarDumper;
use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\CliDumper;

// @todo -> Check and merge with Symfony debugger 
// -> All VDumps should be available on separate tab;
function cliDump($var) {
    $output = fopen("php://memory", "r+b");
    $cloner = new VarCloner();
    $dumper = new CliDumper();

    $dumper->dump(
        $cloner->cloneVar($var),
        $output
    );
    $output = stream_get_contents($output, -1, 0);
    var_dump($output);
    //VarDumper::dump($output);
}

function cl($var) {
    //echo "<pre>";
    cliDump($var);
    //echo "</pre>";
    exit();
}
function clinput() {
    cl(file_get_contents('php://input'));
}
function fl($var) {
    ob_start();
    //var_dump($var);
    cliDump($var);
    $result = ob_get_clean();

    file_put_contents(
        //"/Users/__/Sites/__/var/logs/var_dump.html", 
        "/var/www/bots/webapp/var/logs/var_dump.html",
        $result, 
        FILE_APPEND
    );
}

function cliDump2($var) {
    $output = fopen("php://memory", "r+b");
    $cloner = new VarCloner();
    $dumper = new CliDumper();

    $dumper->dump(
        $cloner->cloneVar($var),
        $output
    );
    $output = stream_get_contents($output, -1, 0);
    print_r($output);
    //VarDumper::dump($output);
}
function flr($var) {
    ob_start();
    //var_dump($var);
    cliDump2($var);
    $result = ob_get_clean();

    file_put_contents(
        //"/Users/__/Sites/__/var/logs/var_dump.html", 
        "/var/www/bots/webapp/var/logs/var_dump.html",
        $result, 
        FILE_APPEND
    );
}

class AppKernel extends Kernel
{
    public function flTest($var)
    {
        fl($_SERVER["REQUEST_URI"]);
    }

    public function __construct($env, $debug)
    {
        date_default_timezone_set('UTC');
        Type::overrideType('datetime', UTCDateTimeType::class);
        Type::overrideType('datetimetz', UTCDateTimeType::class);

        parent::__construct($env, $debug);
    }

    public function registerBundles()
    {
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle(),

            new Ntech\CoreBundle\NtechCoreBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'), true)) {
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    public function getRootDir()
    {
        return __DIR__;
    }

    public function getCacheDir()
    {
        return dirname(__DIR__).'/var/cache/'.$this->getEnvironment();
    }

    public function getLogDir()
    {
        return dirname(__DIR__).'/var/logs';
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getRootDir().'/config/config_'.$this->getEnvironment().'.yml');
    }
}
