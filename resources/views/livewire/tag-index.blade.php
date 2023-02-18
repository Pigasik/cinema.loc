<div class="flex flex-col">
    <div class="w-full flex mb-4 p-2 justify-end">
        <x-jet-button wire:click="showCreateTag">Create Tag</x-jet-button>
    </div>
    <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
      <div class="py-4 inline-block w-1/2 sm:px-6 lg:px-8">
        <div class="relative">
            <input wire:model="search" type="text" placeholder="Search by tag"
            class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" />
        </div>
    </div>
      <div class="py-4 inline-block min-w-full sm:px-6 lg:px-8">
        <div class="overflow-hidden">
          <table class="w-full text-center">
            <thead class="border-b bg-gray-800">
              <tr>
                <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                  Tags
                </th>
                <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                  Slug
                </th>
                <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                    Action
                </th>
              </tr>
            </thead class="border-b">
            <tbody>
              @foreach($tags as $tag)
              <tr class="bg-white border-b">
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{$tag->tag_name}}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{$tag->slug}}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                  <x-jet-button wire:click="editTag({{ $tag->id }})"
                    class="text-white">Edit</x-jet-button>
                <x-jet-button wire:click="deleteTag({{ $tag->id }})"
                    class="text-white">Delete</x-jet-button>
                </td>
              </tr> 
              @endforeach  
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <x-jet-dialog-modal wire:model="showCreate">
      @if ($tagId)
      <x-slot name="title">Edit Tag</x-slot>         
      @else
      <x-slot name="title">Create Tag</x-slot>
      @endif
      <x-slot name="content">
        <div class="flex justify-center">
          <div class="mb-3 w-full">
            <label for="tag_name" class="form-label inline-block mb-2 text-gray-700">Tag Name</label>
            <input wire:model="tagName" type="text" class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"/>
          </div>
        </div>
      </x-slot>
      <x-slot name="footer">
        @if ($tagId)
        <x-jet-button wire:click="updateTag">Edit</x-jet-button>
        @else
        <x-jet-button wire:click="createTag">Save</x-jet-button>
        @endif
        <x-jet-button class="px-4" wire:click="closeCreateTag">Close</x-jet-button>
      </x-slot>
    </x-jet-dialog-model>
  </div>
