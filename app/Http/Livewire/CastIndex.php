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
    public $castTMDBId;
    public $castName;
    public $castPoster;

    public function generateCast(){
        $newCast = Http::get('https://api.themoviedb.org/3/person/10580?api_key=1d7a93431099a07e3032306e6032da45&language=en-USS')->json();
        Cast::create([
            'tmdb_id' => $newCast['id'],
            'name'    => $newCast['name'],
            'slug'    => Str::slug($newCast['name']),
            'poster_path' => $newCast['profile_path']
        ]);
    }
    
    public function render()
    {
        return view('livewire.cast-index', [
            'casts' => Cast::paginate(10)
        ]);
    }
}
