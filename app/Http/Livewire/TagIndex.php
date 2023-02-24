<?php

namespace App\Http\Livewire;

use App\Models\Tag;
use Livewire\Component;
use Illuminate\Support\Str;

class TagIndex extends Component
{
    public $showCreate = false;
    public $tagName;
    public $tags = [];
    public $tagId;
    public $search = '';

    public function showCreateTag(){
        $this->showCreate = true;
    }

    public function closeCreateTag(){
        $this->showCreate = false;
    }

    public function createTag(){
        Tag::create([
          'tag_name' => $this->tagName,
          'slug' => Str::slug($this->tagName)
      ]);
        $this->reset();
        $this->tags = Tag::all();
    }

    public function mount(){
        $this->tags = Tag::all();
    }

    public function editTag($tagId){
        $this->reset(['tagName']);
        $this->tagId = $tagId;
        $tag = Tag::find($tagId);
        $this->tagName = $tag->tag_name;
        $this->showCreate = true;
    }

    public function updateTag(){
        $tag = Tag::findorFail($this->tagId);
        $tag->update([
            'tag_name' => $this->tagName, 
            'slug' => Str::slug($this->tagName)]);
        $this->reset();
        $this->tags = Tag::all();
        $this->showCreate = false;
        $this->dispatchBrowserEvent('banner-message', ['style' => 'success', 'message' => 'Tag created successfully']);
    }

    public function deleteUser($tagId){
        $tag = Tag::findorFail($tagId);
        $tag->delete();
        $this->tags = Tag::all();
        
    }

    public function render()
    {
        return view('livewire.tag-index', [
            'tags' => Tag::search('tag_name', $this->search)->paginate(10)
        ]);
    }
}
