<?php

namespace App\Http\Livewire;

use App\Models\Genre;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class GenreIndex extends Component
{
    use WithPagination;
    protected $rules = [
        'title' => 'required',
    ];
    public $tmdbId;
    public $title;
    public $genreId;
    public $showEdit = false;
    public $search = '';

    public function generateGenre(){
        $apiKey = config('services.api.key');
        $response = Http::get('https://api.themoviedb.org/3/genre/movie/list?api_key='.$apiKey.'&language=fr');
        $genres = $response->json()['genres'];
        foreach ($genres as $genre) {
            Genre::create([
                'tmdb_id' => $genre['id'],
                'title' => $genre['name'],
                'slug' => Str::slug($genre['name'])
            ]);
        }
        $this->reset();
    }

    public function editGenre($id){
        $this->genreId = $id;
        $this->loadGenre();
        $this->showEdit = true;
    }

    public function loadGenre(){
        $genre = Genre::findOrFail($this->genreId);
        $this->title = $genre->title;
    }

    public function closeEditGenre(){
        $this->showEdit = false;
        $this->resetValidation();
    }

    public function updateGenre(){
        $this->validate();
        $genre = Genre::findOrFail($this->genreId);
        $genre->update([
            'title' => $this->title,
        ]);
        $this->dispatchBrowserEvent('banner-message', ['style' => 'success', 'message' => 'Genre updated']);
        $this->reset();
    }
    
    public function deleteGenre($id){
        Genre::findOrFail($id)->delete();
        $this->dispatchBrowserEvent('banner-message', ['style' => 'success', 'message' => 'Genre deleted']);
        $this->reset();
    }

    public function render()
    {
        return view('livewire.genre-index', [
            'genres' => Genre::search('title', $this->search)->paginate(10)
        ]);
    }
}
