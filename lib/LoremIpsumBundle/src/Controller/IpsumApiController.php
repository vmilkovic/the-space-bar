<?php

namespace Milky\LoremIpsumBundle\Controller;

use Milky\LoremIpsumBundle\MilkyIpsum;
use Milky\LoremIpsumBundle\Event\MilkyLoremIpsumEvents;
use Milky\LoremIpsumBundle\Event\FilterApiResponseEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IpsumApiController extends AbstractController {

    private $milkyIpsum;
    private $eventDispatcher;

    public function __construct(MilkyIpsum $milkyIpsum, EventDispatcherInterface $eventDispatcher = null)
    {
        $this->milkyIpsum = $milkyIpsum;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function index(){
        $data = [
            'paragraphs' => $this->milkyIpsum->getParagraphs(),
            'sentences' => $this->milkyIpsum->getSentences()
        ];

        $event = new FilterApiResponseEvent($data);

        if($this->eventDispatcher){   
            $this->eventDispatcher->dispatch(MilkyLoremIpsumEvents::FILTER_API, $event);
        }

        return $this->json($event->getData());
    }

}