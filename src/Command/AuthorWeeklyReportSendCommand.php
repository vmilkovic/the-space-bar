<?php

namespace App\Command;

use App\Repository\UserRepository;
use App\Repository\ArticleRepository;
use App\Service\Mailer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AuthorWeeklyReportSendCommand extends Command
{
    protected static $defaultName = 'app:author-weekly-report:send';
    protected static $defaultDescription = 'Send weekly reports to authors';

    private $userRepository;
    private $articleRepository;
    private $mailer;

    public function __construct(UserRepository $userRepository, ArticleRepository $articleRepository, Mailer $mailer){
        parent::__construct(null);
        
        $this->userRepository = $userRepository;
        $this->articleRepository = $articleRepository;
        $this->mailer = $mailer;
    }

    protected function configure()
    {
        $this
            ->setDescription(self::$defaultDescription)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $authors = $this->userRepository
            ->findAllSubscribedToNewsletter();

        $io->progressStart(count($authors));

        foreach($authors as $author){
            $io->progressAdvance();

            $articles = $this->articleRepository->findAllPublishedLastWeekByAuthor($author);
            if(count($articles) === 0){
                continue;
            }

            $this->mailer->sendAuthorWeeklyReportMessage($author, $articles);
        }

        $io->progressFinish();

        $io->success('Weekly reports were sent to authors!');
    }
}
