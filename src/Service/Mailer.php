<?php

namespace App\Service;

use App\Entity\User;
use Knp\Snappy\Pdf;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\WebpackEncoreBundle\Asset\EntrypointLookupInterface;
use Twig\Environment;

class Mailer {

    private $mailer;
    private $twig;
    private $pdf;
    private $entrypointLookup;

    public function __construct(MailerInterface $mailer, Environment $twig, Pdf $pdf, EntrypointLookupInterface $entrypointLookup)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
        $this->pdf = $pdf;
        $this->entrypointLookup = $entrypointLookup;
    }

    public function sendWelomeMessage(User $user): TemplatedEmail{
        
        $email = (new TemplatedEmail())
        ->from(new Address('alienmailer@example.com', 'The Space Bar'))
        ->to(new Address($user->getEmail(), $user->getFirstName()))
        ->subject('Welcome to the Space Bar!')
        ->htmlTemplate('email/welcome.html.twig')
        ->context([
            //'user' => $user
        ]);

        $this->mailer->send($email);

        return $email;
    }

    public function sendAuthorWeeklyReportMessage(User $author, array $articles): TemplatedEmail {
        
        $html = $this->twig->render('email/author-weekly-report-pdf.html.twig', [
            'articles' => $articles
        ]);

        $this->entrypointLookup->reset(); // Froce Encore to return css array on second loop (default one Encore array per request)
        $pdf = $this->pdf->getOutputFromHtml($html);

        $email = (new TemplatedEmail())
        ->from(new Address('alienmailer@example.com', 'The Space Bar'))
        ->to(new Address($author->getEmail(), $author->getFirstName()))
        ->subject('Your weekly report on The Space Bar!')
        ->htmlTemplate('email/author-weekly-report.html.twig')
        ->context([
            'author' => $author,
            'articles' => $articles
        ])
        ->attach($pdf, sprintf('weekly-report-%s.pdf', date('Y-m-d')));

        $this->mailer->send($email);
        
        return $email;
    }
}