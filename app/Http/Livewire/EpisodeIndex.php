<?php

namespace App\Http\Livewire;

use App\Models\Episode;
use App\Models\Season;
use App\Models\Serie;
use App\Models\TrailerUrl;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class EpisodeIndex extends Component
{
    use WithPagination;
    
    public Serie $serie;
    public Season $season;

    public $search = '';

    public $episodeNumber;
    public $episodeId;
    public $showEdit = false;
    public $overview;
    public $name;
    public $isPublic;

    public $showTrailer = false;
    public $episode;
    public $trailerName;
    public $embedHtml;

    protected $rules = [
        'name' => 'required',
        'overview' => 'required',
        'episodeNumber' => 'required'
    ];

    public function generateEpisode()
    {
        $apiKey = config('services.api.key');
        $newEpisode = Http::get('https://api.themoviedb.org/3/tv/' . $this->serie->tmdb_id . '/season/' . $this->season->season_number .'/episode/'. $this->episodeNumber . '?api_key='.$apiKey.'&language=en-US');
        if ($newEpisode->ok()) {

            $episode = Episode::where('tmdb_id', $newEpisode['id'])->first();
            if (!$episode) {
                Episode::create([
                    'season_id' => $this->season->id,
                    'tmdb_id' => $newEpisode['id'],
                    'name' => $newEpisode['name'],
                    'slug' => Str::slug($newEpisode['name']),
                    'episode_number' => $newEpisode['episode_number'],
                    'overview' => $newEpisode['overview'],
                    'is_public' => false,
                    'visits' => 1
                ]);
                $this->reset('episodeNumber');
                $this->dispatchBrowserEvent('banner-message', ['style' => 'success', 'message' => 'Episode created']);
            } else {
                $this->dispatchBrowserEvent('banner-message', ['style' => 'danger', 'message' => 'Episode exists']);
            }
        } else {
            $this->dispatchBrowserEvent('banner-message', ['style' => 'danger', 'message' => 'Episode not exists']);
            $this->reset('episodeNumber');
        }
    }

    public function editEpisode($id)
    {
        $this->episodeId = $id;
        $this->loadEpisode();
        $this->showEdit = true;
    }
    public function loadEpisode()
    {
        $episode = Episode::findOrFail($this->episodeId);
        $this->name = $episode->name;
        $this->overview = $episode->overview;
        $this->episodeNumber = $episode->episode_number;
        $this->isPublic = $episode->is_public;
    }
    public function closeEditEpisode()
    {
        $this->showEdit = false;
        $this->showTrailer = false;
    }
    public function updateEpisode()
    {
        $this->validate();
        $episode = Episode::findOrFail($this->episodeId);
        $episode->update([
            'name' => $this->name,
            'episode_number' => $this->episodeNumber,
            'overview' => $this->overview,
            'is_public' => $this->isPublic
        ]);
        $this->dispatchBrowserEvent('banner-message', ['style' => 'success', 'message' => 'Episode updated']);
        $this->reset(['episodeNumber', 'name', 'overview', 'episodeId', 'showEdit']);
    }
    public function deleteEpisode($id)
    {
        $episode = Episode::findOrFail($id);
        $episode->delete();
        $this->reset(['episodeNumber', 'name', 'overview', 'episodeId', 'showEdit']);
        $this->dispatchBrowserEvent('banner-message', ['style' => 'success', 'message' => 'Episode deleted']);
    }

    public function render()
    {
        return view('livewire.episode-index', [
            'episodes' => Episode::where('season_id', $this->season->id)->search('name', $this->search)->paginate(10)
        ]);
    }
}
