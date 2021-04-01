<?php

namespace App\EventSubscriber;

use Milky\LoremIpsumBundle\Event\FilterApiResponseEvent;
use Milky\LoremIpsumBundle\Event\MilkyLoremIpsumEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class AddMessageToIpsumApiSubscriber implements EventSubscriberInterface {

    public static function getSubscribedEvents()
    {
        return [
            MilkyLoremIpsumEvents::FILTER_API => 'onFilterApi'
        ];
    }

    public function onFilterApi(FilterApiResponseEvent $event){

        $data = $event->getData();
        $data['messsage'] = 'Have a magical day!';
        $event->setData($data);
    }
}