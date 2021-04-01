<?php

namespace Milky\LoremIpsumBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class WordProviderCompilerPass implements CompilerPassInterface {

    public function process(ContainerBuilder $container)
    {
        $definition = $container->getDefinition('milky_lorem_ipsum.milky_ipsum');

        $references = [];
        foreach($container->findTaggedServiceIds('milky_ipsum_word_provider') as $id => $tags){
            $references[] = new Reference($id);
        }
        
        $definition->setArgument(0, $references);
    }

}