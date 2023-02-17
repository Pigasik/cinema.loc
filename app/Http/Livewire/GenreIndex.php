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
    protected $key = '1d7a93431099a07e3032306e6032da45';
    protected $rules = [
        'title' => 'required',
    ];
    public $tmdbId;
    public $title;
    public $genreId;
    public $showEdit = false;

    public function generateGenre(){
        $newGenre = Http::get('https://api.themoviedb.org/3/genre/movie/list?api_key=1d7a93431099a07e3032306e6032da45&language=en-US')->json();
        foreach($newGenre as $genre){
        $genre = Genre::where('tmdb_id', $newGenre['id'])->first();
        if(!$genre){
            Genre::create([
            'tmdb_id' => $newGenre['id'],
            'title' => $newGenre['name'],
            'slug' => Str::slug($newGenre['name'])
        ]);
        $this->reset();
        } else{
            $this->dispatchBrowserEvent('banner-message', ['style' => 'danger', 'message' => 'Invalid TMDBId']);
        }}
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
            'genres'=>Genre::paginate(10)
        ]);
    }
}
