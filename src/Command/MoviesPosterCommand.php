<?php

namespace App\Command;

use App\Service\OmdbApi;
use App\Service\MySlugger;
use App\Repository\MovieRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MoviesPosterCommand extends Command
{
    protected static $defaultName = 'app:movies:poster';
    protected static $defaultDescription = 'Get movies posters from omdbapi.com';

    // Nos services
    private $movieRepository;
    private $entityManager;
    private $omdbApi;

    public function __construct(MovieRepository $movieRepository, ManagerRegistry $doctrine, OmdbApi $omdbApi)
    {
        $this->movieRepository = $movieRepository;
        $this->entityManager = $doctrine->getManager();
        $this->omdbApi = $omdbApi;

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

        $io->info('Mise à jour des posters');

        // Récupérer tous les films (via MovieRepository)
        $movies = $this->movieRepository->findAll();
        // Pour chaque film
        foreach ($movies as $movie) {
            $io->info($movie->getTitle());

            // On slugifie le titre avec notre service MySlugger
            $moviePoster = $this->omdbApi->fetchPoster($movie->getTitle());
          
            if (!$moviePoster) {
                $io->warning('Poster non trouvé');
            }
            
            // On met à jour le poster du film
            $movie->setPoster($moviePoster);

        }
        // On flush (via l'entityManager)
        $this->entityManager->flush();

        $io->success('Les posters ont été mis à jour');

        return Command::SUCCESS;
    }
}
