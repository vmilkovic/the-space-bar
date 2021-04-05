<?php

namespace App\Tests\Service;

use Knp\Snappy\Pdf;
use App\Entity\User;
use Twig\Environment;
use App\Entity\Article;
use App\Service\Mailer;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\WebpackEncoreBundle\Asset\EntrypointLookupInterface;

class MailerTest extends KernelTestCase
{
    public function testSendWelcomeMEssage(): void
    {
        $symfonyMailer = $this->createMock(MailerInterface::class);
        $symfonyMailer->expects($this->once())
            ->method('send');

        $pdf = $this->createMock(Pdf::class);
        $twig = $this->createMock(Environment::class);
        $entriPointLookup = $this->createMock(EntrypointLookupInterface::class);

        $user = new User();
        $user->setFirstName('Vedran');
        $user->setEmail('vedran@email.com');

        $mailer = new Mailer($symfonyMailer, $twig, $pdf, $entriPointLookup);
        $email = $mailer->sendWelomeMessage($user);

        $this->assertSame('Welcome to the Space Bar!', $email->getSubject());
        $this->assertCount(1, $email->getTo());

        /** @var Address[] $addresses */
        $addresses = $email->getTo();
        $this->assertInstanceOf(Address::class, $addresses[0]);
        $this->assertSame('Vedran', $addresses[0]->getName());
        $this->assertSame('vedran@email.com', $addresses[0]->getAddress());
    }

    public function testIntegrationSendAuthorWeeklyReportMessage()
    {
        self::bootKernel();

        $symfonyMailer = $this->createMock(MailerInterface::class);
        $symfonyMailer->expects($this->once())
            ->method('send');

        $pdf = self::$container->get(Pdf::class);
        $twig = self::$container->get(Environment::class);
        $entrypointLookup = $this->createMock(EntrypointLookupInterface::class);

        $user = new User();
        $user->setFirstName('Vedran');
        $user->setEmail('vedran@email.com');

        $article = new Article();
        $article->setTitle('Black Holes: Ultimate Party ppoer');

        $mailer = new Mailer($symfonyMailer, $twig, $pdf, $entrypointLookup);
        $email = $mailer->sendAuthorWeeklyReportMessage($user, [$article]);

        $this->assertCount(1, $email->getAttachments());
    }
}
