<div class="flex flex-col">
  <div class="w-full flex mb-4 p-2 justify-end">
    <div class="flex justify-center">
      <div class="mb-1 w-full">
        <label for="tmdb_id_g" class="form-label inline-block mb-2 text-gray-700">Season ID</label>
        <input wire:model="seasonNumber" id="tmdb_id_g" name="tmdb_id_g" type="text" class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"/>
      </div>
    </div>
    <x-jet-button wire:click="generateSeason">Generate</x-jet-button>  
  </div>
    <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
      
      <div class="py-4 inline-block w-1/2 sm:px-6 lg:px-8">
        <div class="relative">
            <input wire:model="search" type="text" placeholder="Search by name"
            class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" />
        </div>
    </div>

      <div class="py-4 inline-block min-w-full sm:px-6 lg:px-8">
        <div class="overflow-hidden">
          <table class="w-full text-center">
            <thead class="border-b bg-gray-800">
              <tr>
                <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                  Name
                </th>
                <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                  Poster
                </th>
                <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                  Season number
                </th>
                <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                  Action
                </th>
              </tr>
            </thead class="border-b">
            <tbody>
              @foreach ($seasons as $season)
              <tr class="bg-white border-b">
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{$season->name}}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{$season->poster_path}}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{$season->season_number}}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                  <a href="{{ route('admin.episodes.index', [$serie->id, $season->id]) }}"
                    class="px-6 py-2 bg-blue-300 text-gray-900 hover:bg-blue-500 hover:text-gray-700 rounded shadow">Episode</a>
                  <x-jet-button wire:click="editSeason({{ $season->id }})"
                    class="text-white">Edit</x-jet-button>
                  <x-jet-button wire:click="deleteSeason({{ $season->id }})"
                    class="text-white">Delete</x-jet-button>
                </td>
              </tr>
               @endforeach
            </tbody>
          </table>
        <div class="m-2 p-2">
          {{$seasons->links()}}
        </div>
        </div>
      </div>
    </div>
    <x-jet-dialog-modal wire:model="showEdit">
      <x-slot name="title">Edit Season</x-slot>         
      <x-slot name="content">
        <div class="flex justify-center">
          <div class="mb-3 w-full">
            <label for="name" class="form-label inline-block mb-2 text-gray-700">Name</label>
            <input wire:model="name" type="text" class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"/>
            @error('name')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
          </div>
        </div>
        <div class="flex justify-center">
          <div class="mb-3 w-full">
            <label for="seasonNumber" class="form-label inline-block mb-2 text-gray-700">Season number</label>
            <input wire:model="seasonNumber" type="text" class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"/>
            @error('seasonNumber')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
          </div>
        </div>
        <div class="flex justify-center">
          <div class="mb-3 w-full">
            <label for="posterPath" class="form-label inline-block mb-2 text-gray-700">Poster path</label>
            <input wire:model="posterPath" type="text" class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"/>
            @error('posterPath')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
          </div>
        </div>
      </x-slot>
      <x-slot name="footer">
        <x-jet-button wire:click="updateSeason">Edit</x-jet-button>
        <x-jet-button class="px-4" wire:click="closeEditSeason">Close</x-jet-button>
      </x-slot>
    </x-jet-dialog-model>
  </div>
