<?php 

namespace App\EventListener;

use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mailer\Event\MessageEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class SetFromListener implements EventSubscriberInterface {

    public function onMessage(MessageEvent $event){

        $email = $event->getMessage();
        if(!$email instanceof Email){
            return;
        }

        $email->from(new Address('someone@example.com', 'The Space Bar'));
    }

    public static function getSubscribedEvents()
    {
        return [
            MessageEvent::class => 'onMessage'
        ];
    }
}