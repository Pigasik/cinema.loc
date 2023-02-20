<?php

namespace App\Http\Livewire;

use App\Models\Genre;
use App\Models\Movie;
use App\Models\TrailerUrl;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class MovieIndex extends Component
{
    use WithPagination;

    public $search = ''; 
    public $title;
    public $runtime;
    public $lang;
    public $videoFormat;
    public $rating;
    public $posterPath;
    public $backdropPath;
    public $overview;
    public $isPublic;
    public $tmdbId;
    public $movieId;
    public $movie;
    public $showEdit = false;
    public $showTrailer = false;
    public $trailerName;
    public $embedHtml;

    protected $listeners = [
        'tagAdd' => 'tagAdd',
        'tagDelite' => 'tagDelite',
        'castAdd' => 'castAdd',
        'castDelite' => 'castDelite'
        ];

    protected $rules = [
        'title' => 'required',
        'posterPath' => 'required',
        'runtime' => 'required',
        'lang' => 'required',
        'videoFormat' => 'required',
        'rating' => 'required',
        'backdropPath' => 'required',
        'overview' => 'required',
        'isPublic' => 'required'
    ];

    public function generateMovie()
    {
        $apiKey = config('services.api.key');
        $movie = Movie::where('tmdb_id', $this->tmdbId)->exists();
        if ($movie) {
            $this->dispatchBrowserEvent('banner-message', ['style' => 'danger', 'message' => 'Movie exists']);
            return;
        }
        $url = 'https://api.themoviedb.org/3/movie/'. $this->tmdbId .'?api_key='.$apiKey.'&language=en-US';

        $apiMovie = Http::get($url);

        if ($apiMovie->successful()) {
            $newMovie = $apiMovie->json();

            $created_movie = Movie::create([
                'tmdb_id' => $newMovie['id'],
                'title' => $newMovie['title'],
                'slug'  => Str::slug($newMovie['title']),
                'runtime' => $newMovie['runtime'],
                'rating' => $newMovie['vote_average'],
                'release_date' => $newMovie['release_date'],
                'lang' => $newMovie['original_language'],
                'video_format' => 'HD',
                'is_public' => false,
                'overview' => $newMovie['overview'],
                'poster_path' => $newMovie['poster_path'],
                'backdrop_path' => $newMovie['backdrop_path']
            ]);
            $tmdb_genres = $newMovie['genres'];
            $tmdb_genres_ids = collect($tmdb_genres)->pluck('id');
            $genres = Genre::whereIn('tmdb_id', $tmdb_genres_ids)->get();
            //dd($genres);
            $created_movie->genres()->attach($genres);
            $this->reset('tmdbId');
            $this->dispatchBrowserEvent('banner-message', ['style' => 'success', 'message' => 'Movie created']);
        } else {
            $this->dispatchBrowserEvent('banner-message', ['style' => 'danger', 'message' => 'Api not exists']);
            $this->reset('tmdbId');
        }
    }

    public function editMovie($movieId){
        $this->movie = Movie::findOrFail($movieId);
        $this->loadMovie();
        $this->showEdit = true;
    }

    public function loadMovie(){
        $this->title = $this->movie->title;
        $this->runtime = $this->movie->runtime;
        $this->lang = $this->movie->lang;
        $this->videoFormat = $this->movie->video_format;
        $this->rating = $this->movie->rating;
        $this->posterPath = $this->movie->poster_path;
        $this->backdropPath = $this->movie->backdrop_path;
        $this->overview = $this->movie->overview;
        $this->isPublic = $this->movie->is_public;
    }

    public function closeEditMovie(){
        $this->showEdit = false;
        $this->resetValidation();
    }

    public function updateMovie()
    {
        $this->validate();
        $this->movie->update([
            'title' => $this->title,
            'runtime' => $this->runtime,
            'lang' => $this->lang,
            'video_format' => $this->videoFormat,
            'rating' => $this->rating,
            'poster_path' => $this->posterPath,
            'backdrop_path' => $this->backdropPath,
            'overview' => $this->overview,
            'is_public' => $this->isPublic,
        ]);
        $this->dispatchBrowserEvent('banner-message', ['style' => 'success', 'message' => 'Movie updated']);
        $this->reset();
    }

    public function deleteMovie($movieId)
    {
        $movie = Movie::findOrFail($movieId);
        $movie->delete();
        $this->dispatchBrowserEvent('banner-message', ['style' => 'success', 'message' => 'Movie Deleted']);
        $this->reset();
    }

    public function showTrailer($movieId){
        $this->movie = Movie::findOrFail($movieId);
        $this->showTrailer = true;
    }

    public function addTrailer(){
        $this->movie->trailers()->create([
            'name' => $this->trailerName,
            'embed_html' => $this->embedHtml
        ]);
        $this->reset();
        $this->dispatchBrowserEvent('banner-message', ['style' => 'success', 'message' => 'Trailer add']);
    }

    public function deleteTrailer($trailerId){
        $trailer = TrailerUrl::findOrFail($trailerId);
        $trailer->delete();
        $this->reset();
        $this->dispatchBrowserEvent('banner-message', ['style' => 'success', 'message' => 'Trailer deleted']);
    }

    public function closeEditTrailer(){
        $this->showTrailer = false;
        $this->reset();
    }

    public function tagAdd()
    {
        $this->dispatchBrowserEvent('banner-message', ['style' => 'success', 'message' => 'Tag Add']);
        $this->reset();
    }

    public function tagDelite()
    {
        $this->dispatchBrowserEvent('banner-message', ['style' => 'success', 'message' => 'Tag deleted']);
        $this->reset();
    }
    public function castAdd()
    {
        $this->dispatchBrowserEvent('banner-message', ['style' => 'success', 'message' => 'Cast Add']);
        $this->reset();
    }

    public function castDelite()
    {
        $this->dispatchBrowserEvent('banner-message', ['style' => 'success', 'message' => 'Cast deleted']);
        $this->reset();
    }

    public function render()
    {
        return view('livewire.movie-index', [
            'movies' => Movie::search('title', $this->search)->paginate(10)
        ]);
    }
}
