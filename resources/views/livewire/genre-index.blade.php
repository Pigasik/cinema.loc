<div class="flex flex-col">
  <div class="w-full flex mb-4 p-2 justify-end">
    <div class="flex justify-center">
      <div class="mb-1 w-full">
        <label for="tmdb_id_g" class="form-label inline-block mb-2 text-gray-700">Genre ID</label>
        <input wire:model="tmdbId" id="tmdb_id_g" name="tmdb_id_g" type="text" class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"/>
      </div>
    </div>
    <x-jet-button wire:click="generateGenre">Create Genre</x-jet-button>  
  </div>
    <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
      <div class="py-4 inline-block min-w-full sm:px-6 lg:px-8">
        <div class="overflow-hidden">
          <table class="w-full text-center">
            <thead class="border-b bg-gray-800">
              <tr>
                <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                  Title
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
              @foreach ($genres as $genre)
              <tr class="bg-white border-b">
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{$genre->title}}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{$genre->slug}}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                  <x-jet-button wire:click="editGenre({{ $genre->id }})"
                    class="text-white">Edit</x-jet-button>
                <x-jet-button wire:click="deleteGenre({{ $genre->id }})"
                    class="text-white">Delete</x-jet-button>
                </td>
              </tr>
               @endforeach
            </tbody>
          </table>
        <div class="m-2 p-2">
          {{$genres->links()}}
        </div>
        </div>
      </div>
    </div>
    <x-jet-dialog-modal wire:model="showEdit">
      <x-slot name="title">Edit Genre</x-slot>         
      <x-slot name="content">
        <div class="flex justify-center">
          <div class="mb-3 w-full">
            <label for="title" class="form-label inline-block mb-2 text-gray-700">Title</label>
            <input wire:model="title" type="text" class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"/>
            @error('title')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
          </div>
        </div>
      </x-slot>
      <x-slot name="footer">
        <x-jet-button wire:click="updateGenre">Edit</x-jet-button>
        <x-jet-button class="px-4" wire:click="closeEditGenre">Close</x-jet-button>
      </x-slot>
    </x-jet-dialog-model>
  </div>
