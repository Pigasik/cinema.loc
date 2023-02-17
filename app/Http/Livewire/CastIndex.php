<?php

namespace App\Http\Livewire;

use App\Models\Cast;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class CastIndex extends Component
{
    use WithPagination;
    protected $key = '1d7a93431099a07e3032306e6032da45';
    protected $rules = [
        'castName' => 'required',
        'castPoster' => 'required'
    ];
    public $castTMDBId;
    public $castName;
    public $castPoster;
    public $showEdit = false;
    public $castId;

    public function generateCast(){
        $newCast = Http::get('https://api.themoviedb.org/3/person/'. $this->castTMDBId .'?api_key=1d7a93431099a07e3032306e6032da45&language=en-USS')->json();
        $cast = Cast::where('tmdb_id', $newCast['id'])->first();
        if(!$cast){
           Cast::create([
            'tmdb_id' => $newCast['id'],
            'name' => $newCast['name'],
            'slug' => Str::slug($newCast['name']),
            'poster_path' => $newCast['profile_path']
        ]); 
        } else{
            $this->dispatchBrowserEvent('banner-message', ['style' => 'denger', 'message' => 'Invalid TMDBId']);
    
        }
        $this->reset();
        
    }

    public function editCast($id){
        $this->castId = $id;
        $this->loadCast();
        $this->showEdit = true; 
    }

    public function loadCast(){
        $cast = Cast::findOrFail($this->castId);
        $this->castName = $cast->name;
        $this->castPoster = $cast->poster_path;
    }

    public function closeEditCast(){
        $this->showEdit = false;
        $this->resetValidation();
    }

    public function updateCast(){
        $this->validate();
        $cast = Cast::findOrFail($this->castId);
        $cast->update([
            'name' => $this->castName,
            'poster_path' => $this->castPoster
        ]);
        $this->dispatchBrowserEvent('banner-message', ['style' => 'success', 'message' => 'Cast updated']);
        $this->reset();
    }
    
    public function deleteCast($id){
        Cast::findOrFail($id)->delete();
        $this->dispatchBrowserEvent('banner-message', ['style' => 'success', 'message' => 'Cast deleted']);
        $this->reset();
    }


    public function render()
    {
        return view('livewire.cast-index', [
            'casts' => Cast::paginate(10)
        ]);
    }
}
