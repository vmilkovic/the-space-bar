<?php

namespace App\Service;

use Milky\LoremIpsumBundle\WordProviderInterface;

class CustomWordProvider implements WordProviderInterface {

    public function getWordList(): array {
        return ['beach'];
    }
}