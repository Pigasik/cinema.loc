<div class="flex flex-col">
  <div class="w-full flex mb-4 p-2 justify-end">
    <div class="flex justify-center">
      <div class="mb-1 w-full">
        <label for="tmdb_id_g" class="form-label inline-block mb-2 text-gray-700">Episode ID</label>
        <input wire:model="episodeNumber" id="tmdb_id_g" name="tmdb_id_g" type="text" class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"/>
      </div>
    </div>
    <x-jet-button wire:click="generateEpisode">Generate</x-jet-button>  
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
                  Public
                </th>
                <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                  Episode
                </th>
                <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                  Action
                </th>
              </tr>
            </thead class="border-b">
            <tbody>
              @foreach ($episodes as $episode)
              <tr class="bg-white border-b">
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{$episode->name}}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                  @if ($episode->is_public)
                      <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                        Published
                      </span>
                  @else
                      <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                        UnPublished
                       </span>
                  @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{$episode->episode_number}}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                  <x-jet-button wire:click="editEpisode({{ $episode->id }})"
                    class="bg-green-500 hover:bg-green-700 text-white text-white">Edit</x-jet-button>
                  <x-jet-button wire:click="deleteEpisode({{ $episode->id }})"
                    class="bg-red-500 hover:bg-red-700 text-white">Delete</x-jet-button>
                </td>
              </tr>
               @endforeach
            </tbody>
          </table>
        <div class="m-2 p-2">
          {{$episodes->links()}}
        </div>
        </div>
      </div>
    </div>
    <x-jet-dialog-modal wire:model="showEdit">
      <x-slot name="title">Edit Episodes</x-slot>         
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
            <label for="episodeNumber" class="form-label inline-block mb-2 text-gray-700">Episode number</label>
            <input wire:model="episodeNumber" type="text" class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"/>
            @error('episodeNumber')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
          </div>
        </div>
        <div class="flex justify-center">
          <div class="mb-3 w-full">
            <label for="overview" class="form-label inline-block mb-2 text-gray-700">Overview</label>
            <textarea class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ $overview }}</textarea>
            @error('overview')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
          </div>
        </div>
        <div class="flex flex-col">
          <div class="flex items-center px-2 py-6">
              <input wire:model="isPublic" type="checkbox"
                  class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
              <label for="remember-me" class="ml-2 block text-sm text-gray-900">
                  Published
              </label>
          </div>
      </div>
      </x-slot>
      <x-slot name="footer">
        <x-jet-button wire:click="updateEpisode">Edit</x-jet-button>
        <x-jet-button class="px-4" wire:click="closeEditEpisode">Close</x-jet-button>
      </x-slot>
    </x-jet-dialog-model>
  </div>
