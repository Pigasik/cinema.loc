<?php

namespace App\Http\Livewire;

use App\Models\Tag;
use Livewire\Component;
use Illuminate\Support\Str;

class TagIndex extends Component
{
    public $showCreate = false;
    public $tagName;
    // public $tagId;

    public function showCreateTag()
    {
        $this->showCreate = true;
    }

    public function closeCreateTag()
    {
        $this->showCreate = false;
    }

    public function createTag()
    {
        Tag::create([
          'tag_name' => $this->tagName,
          'slug' => Str::slug($this->tagName)
      ]);
        $this->reset();
        // $this->dispatchBrowserEvent('banner-message', ['style' => 'success', 'message' => 'Tag created successfully']);
    }

    public function render()
    {
        return view('livewire.tag-index');
    }
}
