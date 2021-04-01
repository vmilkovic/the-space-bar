<?php 

namespace Milky\LoremIpsumBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Milky\LoremIpsumBundle\DependencyInjection\MilkyLoremIpsumExtension;
use Milky\LoremIpsumBundle\DependencyInjection\Compiler\WordProviderCompilerPass;

class MilkyLoremIpsumBundle extends Bundle {

    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new WordProviderCompilerPass());
    }

    public function getContainerExtension()
    {
        if(null === $this->extension){
            $this->extension = new MilkyLoremIpsumExtension();
        }

        return $this->extension;
    }
}