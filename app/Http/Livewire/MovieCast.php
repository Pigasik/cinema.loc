<?php

namespace App\Http\Livewire;

use App\Models\Cast;
use Livewire\Component;

class MovieCast extends Component
{
    public $queryCast = '';
    public $movie;
    public $casts = [];

    public function mount($movie)
    {
        $this->movie = $movie;
    }

    public function updatedQueryCast()
    {
        $this->casts = Cast::search('name', $this->queryCast)->get();
    }

    public function addCast($castId)
    {
        $cast = Cast::findOrFail($castId);
        $this->movie->casts()->attach($cast);
        $this->reset('queryCast');
        $this->emit('castAdd');
    }

    public function deliteCast($castId)
    {
        $this->movie->casts()->detach($castId);
        $this->emit('castDelite');
    }
    public function render()
    {
        return view('livewire.movie-cast');
    }
}