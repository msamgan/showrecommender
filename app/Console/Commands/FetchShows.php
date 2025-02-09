<?php

namespace App\Console\Commands;

use App\Actions\Shows\CreatePersonAction;
use App\Actions\Shows\CreateShowAction;
use App\Adapters\TvMaze;
use App\Mappers\PersonMapper;
use App\Mappers\ShowMapper;
use App\Models\Genre;
use App\Models\Person;
use App\Models\Show;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use JetBrains\PhpStorm\NoReturn;

class FetchShows extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-shows {--page=1 : The page number to fetch}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch shows from TVMaze API';

    /**
     * Execute the console command.
     */
    #[NoReturn]
    public function handle(TvMaze $tvMaze): void
    {
        $page = $this->option('page') ? (int) $this->option('page') : 0;
        $shows = $tvMaze->getShows(page: $page);
        $showsWithErrors = [];

        while (count($shows) > 0) {
            $page++;

            foreach ($shows as $show) {
                try {
                    $createdShow = $this->processShow(showApiData: $show);
                    $this->processShowGenre(genresApiData: $show['genres'], show: $createdShow);
                    $this->processShowCrew(crewApiData: $tvMaze->getShowCrew(showId: $show['id']), show: $createdShow);
                    $this->processShowCast(castApiData: $tvMaze->getShowCast(showId: $show['id']), show: $createdShow);
                } catch (Exception $e) {
                    $this->info('Error processing show: ' . $show['id']);
                    // $this->error($e->getMessage());

                    $showsWithErrors[] = $show['id'];

                    continue;
                }
            }

            $shows = $tvMaze->getShows(page: $page);
        }

        if (count($showsWithErrors) > 0) {
            Storage::put('showsWithErrors.txt', implode("\n", $showsWithErrors));
        }

        $this->info('All shows fetched');
    }

    private function processShow(array $showApiData): Show
    {
        $show = Show::query()->where('on_source_id', $showApiData['id'])->first();

        if ($show) {
            return $show;
        }

        return CreateShowAction::handle(data: ShowMapper::handle(apiData: $showApiData));
    }

    private function processShowGenre(array $genresApiData, Show $show): void
    {
        $genres = [];
        foreach ($genresApiData as $genre) {
            $genreModel = Genre::query()->where('name', strtolower($genre))->first();

            if (! $genreModel) {
                $genreModel = Genre::query()->create(['name' => strtolower($genre)]);
            }

            $genres[] = $genreModel->id;
        }

        $show->genres()->sync($genres);
    }

    private function processShowCrew(array $crewApiData, Show $show): void
    {
        $people = [];
        foreach ($crewApiData as $crewMember) {
            $person = Person::query()->where('on_source_id', $crewMember['person']['id'])->first();

            if (! $person) {
                $person = CreatePersonAction::handle(data: PersonMapper::handle(apiData: $crewMember));
            }

            $people[] = $person->id;
        }

        $show->people()->sync($people);
    }

    private function processShowCast(array $castApiData, Show $show): void
    {
        $people = [];
        foreach ($castApiData as $castMember) {
            $person = Person::query()->where('on_source_id', $castMember['person']['id'])->first();

            if (! $person) {
                $person = CreatePersonAction::handle(data: PersonMapper::handle(apiData: $castMember, isCast: true));
            }

            $people[] = $person->id;
        }

        $show->people()->sync($people);
    }
}
