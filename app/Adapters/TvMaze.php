<?php

namespace App\Adapters;

use Illuminate\Support\Facades\Http;

class TvMaze
{
    public function getShows(int $page = 0): array
    {
        return Http::get('https://api.tvmaze.com/shows', [
            'page' => $page,
        ])->json();
    }

    public function getShowCrew(int $showId): array
    {
        return Http::get("https://api.tvmaze.com/shows/{$showId}/crew")->json();
    }

    public function getShowCast(int $showId): array
    {
        return Http::get("https://api.tvmaze.com/shows/{$showId}/cast")->json();
    }
}
