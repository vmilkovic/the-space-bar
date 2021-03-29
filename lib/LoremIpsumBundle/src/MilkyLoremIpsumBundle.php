<?php 

namespace Milky\LoremIpsumBundle;

use Milky\LoremIpsumBundle\DependencyInjection\MilkyLoremIpsumExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class MilkyLoremIpsumBundle extends Bundle {

    public function getContainerExtension()
    {
        if(null === $this->extension){
            $this->extension = new MilkyLoremIpsumExtension();
        }

        return $this->extension;
    }
}