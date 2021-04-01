<?php

namespace Milky\LoremIpsumBundle\Event;

final class MilkyLoremIpsumEvents {

    /**
     * Called directly before the Lorem Ipsum API data is returned.
     * 
     * Listeners have the oppeortunity to change that data.
     * 
     * @Event("Milky\LoremIpsumBundle\Event\FilterApiResponseEvent")
     */
    const FILTER_API = 'milky_lorem_ipsum.filter_api';
}