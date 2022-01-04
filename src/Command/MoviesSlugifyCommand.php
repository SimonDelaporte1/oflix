<?php

namespace App\Command;

use App\Service\MySlugger;
use App\Repository\MovieRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MoviesSlugifyCommand extends Command
{
    protected static $defaultName = 'app:movies:slugify';
    protected static $defaultDescription = 'Slugifies movies titles in the database';
    
    // Nos services
    private $movieRepository;
    private $mySlugger;
    private $entityManager;

    public function __construct(MovieRepository $movieRepository, MySlugger $mySlugger, ManagerRegistry $doctrine)
    {
        $this->movieRepository = $movieRepository;
        $this->mySlugger = $mySlugger;
        $this->entityManager = $doctrine->getManager();

        // On appelle le constructeur parent
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Permet un affichage trop stylé dans le terminal
        $io = new SymfonyStyle($input, $output);

        $io->info('Mise à jour des slugs');

        // Récupérer tous les films (via MovieRepository)
        $movies = $this->movieRepository->findAll();
        // Pour chaque film
        foreach ($movies as $movie) {
            // On slugifie le titre avec notre service MySlugger
            $movie->setSlug($this->mySlugger->MySluggerToLower($movie->getTitle()));
        }
        // On flush (via l'entityManager)
        $this->entityManager->flush();

        $io->success('Les slugs ont été mis à jour');

        return Command::SUCCESS;
    }
}
