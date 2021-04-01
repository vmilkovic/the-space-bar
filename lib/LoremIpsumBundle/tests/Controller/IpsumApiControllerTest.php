<?php

namespace Milky\LoremIpsumBundle\Tests\Controller;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpKernel\Kernel;
use Milky\LoremIpsumBundle\MilkyLoremIpsumBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Routing\RouteCollectionBuilder;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Client;

class IpsumApiControllerTest extends TestCase {

    public function testIndex() {
        
        $kernel = new MilkyLoremIpsumControllerKernel();
        $client = new Client($kernel);
        $client->request('GET', '/api/');

        var_dump($client->getResponse()->getContent());
        $this->assertSame(200, $client->getResponse()->getStatusCode());
    }
}

class MilkyLoremIpsumControllerKernel extends Kernel {

    use MicroKernelTrait;

    public function __construct()
    {
        parent::__construct('test', true);
    }

    public function registerBundles()
    {
        return [
            new MilkyLoremIpsumBundle(),
            new FrameworkBundle()
        ];
    }

    protected function configureRoutes(RouteCollectionBuilder $routes)
    {
        $routes->import(__DIR__.'/../../src/Resources/config/routes.xml', '/api');
    }

    protected function configureContainer(ContainerBuilder $c, LoaderInterface $loader)
    {
        $c->loadFromExtension('framework', [
            'secret' => 'FOO'
        ]);
    }

    public function getCacheDir()
    {
        return __DIR__.'/../cache/'.spl_object_hash($this);
    }
}