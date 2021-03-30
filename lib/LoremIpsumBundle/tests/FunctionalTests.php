<?php

namespace Milky\LoremIpsumBundle\Tests;

use Milky\LoremIpsumBundle\MilkyIpsum;
use Milky\LoremIpsumBundle\MilkyLoremIpsumBundle;
use Milky\LoremIpsumBundle\WordProviderInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel;

class FunctionalTest extends TestCase
{
    public function testServiceWiring()
    {
        $kernel = new MilkyLoremIpsumTestingKernel();
        $kernel->boot();
        $container = $kernel->getContainer();

        $ipsum = $container->get('milky_lorem_ipsum.milky_ipsum');
        $this->assertInstanceOf(MilkyIpsum::class, $ipsum);
        $this->assertIsString($ipsum->getParagraphs());
    }
}

class MilkyLoremIpsumTestingKernel extends Kernel
{
    public function __construct()
    {
        parent::__construct('test', true);
    }

    public function registerBundles()
    {
        return [
            new MilkyLoremIpsumBundle(),
        ];
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(function(ContainerBuilder $container) {
            $container->register('stub_word_list', StubWordList::class)
                ->addTag('milky_ipsum_word_provider');
        });
    }

    public function getCacheDir()
    {
        return __DIR__.'/cache/'.spl_object_hash($this);
    }
}

class StubWordList implements WordProviderInterface
{
    public function getWordList(): array
    {
        return ['stub', 'stub2'];
    }
}
