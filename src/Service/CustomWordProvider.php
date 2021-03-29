<?php

namespace App\Service;

use Milky\LoremIpsumBundle\MilkyWordProvider;

class CustomWordProvider extends MilkyWordProvider {

    public function getWordList(): array {
        $words = parent::getWordList();
        $words[] = 'breach';

        return $words;
    }
}