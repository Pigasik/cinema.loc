<?php

namespace App\Http\Livewire;

use App\Models\Serie;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithPagination;

class SerieIndex extends Component
{
    use WithPagination;
    public $search = '';
    public $name;
    public $showEdit = false;
    public $tmdbId;
    public $serieId;
    public $createdYear;
    public $posterPath;

    protected $rules = [
        'name' => 'required',
        'posterPath' => 'required',
        'createdYear' => 'required'
    ];

    public function generateSerie(){
        $apiKey = config('services.api.key');
        $newSerie = Http::get('https://api.themoviedb.org/3/tv/'. $this->tmdbId .'?api_key='.$apiKey.'&language=en-US')->json();
        //dd($newSerie);
        $serie = Serie::where('tmdb_id', $newSerie['id'])->first();
        if (!$serie) {
            Serie::create([
            'tmdb_id' => $newSerie['id'],
            'name' => $newSerie['name'],
            'slug' => Str::slug($newSerie['name']),
            'created_year' => $newSerie['first_air_date'],
            'poster_path' => $newSerie['poster_path']
        ]);
            $this->reset();
            $this->dispatchBrowserEvent('banner-message', ['style' => 'success', 'message' => 'Serie created']);
        } else {
            $this->dispatchBrowserEvent('banner-message', ['style' => 'danger', 'message' => 'Serie exists']);
        }
    }
    public function editSerie($id){
        $this->serieId = $id;
        $this->loadSerie();
        $this->showEdit = true;
    }

    public function loadSerie(){
        $serie = Serie::findOrFail($this->serieId);
        $this->name = $serie->name;
        $this->posterPath = $serie->poster_path;
        $this->createdYear = $serie->created_year;
    }

    public function closeEditSerie(){
        $this->showEdit = false;
        $this->resetValidation();
    }

    public function updateSerie(){
        $this->validate();
        $serie = Serie::findOrFail($this->serieId);
        $serie->update([
          'name' => $this->name,
          'created_year' => $this->createdYear,
          'poster_path' => $this->posterPath
      ]);
        $this->dispatchBrowserEvent('banner-message', ['style' => 'success', 'message' => 'Serie updated']);
        $this->reset();
    }
    
    public function deleteSerie($id){
        $serie = Serie::findOrFail($id);
        $serie->delete();
        $this->reset();
        $this->dispatchBrowserEvent('banner-message', ['style' => 'success', 'message' => 'Serie deleted']);
    }

    public function render()
    {
        return view('livewire.serie-index',[
            'series' => Serie::search('name', $this->search)->paginate(10)
        ]);
    }
}
