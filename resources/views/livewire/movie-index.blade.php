<div class="flex flex-col">
  <div class="w-full flex mb-4 p-2 justify-end">
    <div class="flex justify-center">
      <div class="mb-1 w-full">
        <label for="tmdb_id_g" class="form-label inline-block mb-2 text-gray-700">Movie ID</label>
        <input wire:model="tmdbId" id="tmdb_id_g" name="tmdb_id_g" type="text" class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"/>
      </div>
    </div>
    <x-jet-button wire:click="generateMovie">Generate</x-jet-button>  
  </div>
    <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
      
    <div class="py-4 inline-block w-1/2 sm:px-6 lg:px-8">
        <div class="relative">
            <input wire:model="search" type="text" placeholder="Search by title"
            class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" />
        </div>
    </div>

      <div class="py-4 inline-block min-w-full sm:px-6 lg:px-8">
        <div class="overflow-hidden">
          <table class="w-full text-center">
            <thead class="border-b bg-gray-800">
              <tr>
                <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                  Title
                </th>
                <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                  Rating
                </th>
                <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                  Visits
                </th>
                <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                  Runtime
                </th>
                <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                  Published
                </th>
                <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                  Poster
                </th>
                <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                  Action
                </th>
              </tr>
            </thead class="border-b">
            <tbody>
              @foreach ($movies as $movie_t)
              <tr class="bg-white border-b">
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{$movie_t->title}}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{$movie_t->rating}}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{$movie_t->visits}}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{$movie_t->runtime}}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                  @if ($movie_t->is_public)
                  <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                    Published
                  </span>
              @else
                  <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                    UnPublished
                   </span>
              @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                  <img class="w-20 h-25 rounded" src="https://www.themoviedb.org/t/p/w440_and_h660_face/{{$movie_t->poster_path}}">
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                  <x-jet-button wire:click="showTrailer({{ $movie_t->id }})"
                    class="text-white">Trailer</x-jet-button>
                  <x-jet-button wire:click="editMovie({{ $movie_t->id }})"
                    class="bg-green-500 hover:bg-green-700 text-white text-white">Edit</x-jet-button>
                  <x-jet-button wire:click="deleteMovie({{ $movie_t->id }})"
                    class="bg-red-500 hover:bg-red-700 text-white">Delete</x-jet-button>
                </td>
              </tr>
               @endforeach
            </tbody>
          </table>
        <div class="m-2 p-2">
          {{$movies->links()}}
        </div>
        </div>
      </div>
    </div>
    <x-jet-dialog-modal wire:model="showEdit">
      <x-slot name="title">Edit Movie</x-slot>
      <x-slot name="content">
              <div class="mb-3 w-full" x-data="{tab: 0}">
                  <div class="flex border border-black overflow-hidden">
                      <button class="px-4 py-2 w-full" x-on:click.prevent="tab = 0">Form</button>
                      <button class="px-4 py-2 w-full" x-on:click.prevent="tab = 1">Tags</button>
                      <button class="px-4 py-2 w-full" x-on:click.prevent="tab = 2">Casts</button>
                  </div>
                  @if($movie)
                  @foreach($movie->genres as $genre)
                  {{$genre->title}}
                  @endforeach
                  @endif
                  <div>
                      <div class="p-4 space-x-2" x-show="tab === 0">
                                      <div class="flex justify-center">
                                        <div class="mb-3 w-full">
                                          <label for="first-name"
                                              class="block text-sm font-medium text-gray-700 mr-4">Title</label>
                                          <input wire:model="title" type="text"
                                              class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                                          @error('title')
                                              <span class="text-red-500 text-sm">{{ $message }}</span>
                                          @enderror
                                        </div>  
                                      </div>
                                      <div class="flex justify-center">
                                        <div class="mb-3 w-full">
                                          <label for="first-name"
                                              class="block text-sm font-medium text-gray-700 mr-4">Runtime</label>
                                          <input wire:model="runtime" type="text"
                                              class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                                          @error('runtime')
                                              <span class="text-red-500 text-sm">{{ $message }}</span>
                                          @enderror
                                        </div>  
                                      </div>
                                      <div class="flex justify-center">
                                        <div class="mb-3 w-full">
                                          <label for="first-name"
                                              class="block text-sm font-medium text-gray-700 mr-4">Language</label>
                                          <input wire:model="lang" type="text"
                                              class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                                          @error('lang')
                                              <span class="text-red-500 text-sm">{{ $message }}</span>
                                          @enderror
                                        </div>  
                                      </div>
                                      <div class="flex justify-center">
                                        <div class="mb-3 w-full">
                                          <label for="first-name"
                                              class="block text-sm font-medium text-gray-700 mr-4">Format</label>
                                          <input wire:model="videoFormat" type="text"
                                              class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                                          @error('videoFormat')
                                              <span class="text-red-500 text-sm">{{ $message }}</span>
                                          @enderror
                                        </div>  
                                      </div>
                                      <div class="flex justify-center">
                                        <div class="mb-3 w-full">
                                          <label for="first-name"
                                              class="block text-sm font-medium text-gray-700 mr-4">Rating</label>
                                          <input wire:model="rating" type="text"
                                              class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                                          @error('rating')
                                              <span class="text-red-500 text-sm">{{ $message }}</span>
                                          @enderror
                                        </div>  
                                      </div>
                                      <div class="flex justify-center">
                                        <div class="mb-3 w-full">
                                          <label for="first-name"
                                              class="block text-sm font-medium text-gray-700 mr-4">Poster</label>
                                          <input wire:model="posterPath" type="text"
                                              class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                                          @error('posterPath')
                                              <span class="text-red-500 text-sm">{{ $message }}</span>
                                          @enderror
                                        </div>  
                                      </div>
                                      <div class="flex justify-center">
                                        <div class="mb-3 w-full">
                                          <label for="first-name"
                                              class="block text-sm font-medium text-gray-700 mr-4">Backdrop</label>
                                          <input wire:model="backdropPath" type="text"
                                              class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                                          @error('backdropPath')
                                              <span class="text-red-500 text-sm">{{ $message }}</span>
                                          @enderror
                                        </div>  
                                      </div>
                                      <div class="flex justify-center">
                                        <div class="mb-3 w-full">
                                          <label for="overview"
                                              class="block text-sm font-medium text-gray-700 mr-4">Overview</label>
                                          <textarea
                                              class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ $overview }}</textarea>
                                          @error('overview')
                                              <span class="text-red-500 text-sm">{{ $message }}</span>
                                          @enderror
                                        </div>  
                                      </div>
                                      <div class="flex flex-col">
                                        <div class="mb-3 w-full">
                                          <div class="flex items-center px-2 py-6">
                                              <input wire:model="isPublic" type="checkbox"
                                                  class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                              <label for="remember-me" class="ml-2 block text-sm text-gray-900">
                                                  Published
                                              </label>
                                          </div>
                                        </div>  
                                      </div>
                      </div>
                      <div class="p-4 space-x-2" x-show="tab === 1">
                          @if ($movie)
                              <livewire:movie-tag :movie="$movie" />
                          @endif
                      </div>
                      <div class="p-4 space-x-2" x-show="tab === 2">
                          @if ($movie)
                              <livewire:movie-cast :movie="$movie" />
                          @endif
                      </div>
                    </div>
              </div>
      </x-slot>
      <x-slot name="footer">
        <x-jet-button wire:click="updateMovie">Edit</x-jet-button>
        <x-jet-button class="px-4" wire:click="closeEditMovie">Close</x-jet-button>
      </x-slot>
  </x-jet-dialog-modal>
  <x-jet-dialog-modal wire:model="showTrailer">
      <x-slot name="title">Trailer Movie</x-slot>
      <x-slot name="content">
          @if ($movie)
              <div class="flex space-x-4 space-y-2 m-2">
                  @foreach ($movie->trailers as $trailer)
                      <x-jet-button wire:click="deleteTrailer({{ $trailer->id }})" class="hover:bg-red-500">
                          {{ $trailer->name }}</x-jet-button>
                  @endforeach
              </div>
          @endif
          <div class="flex justify-center">
            <div class="mb-3 w-full">
              <label for="trailerName" class="form-label inline-block mb-2 text-gray-700">Name</label>
              <input wire:model="trailerName" type="text" class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"/>
              @error('trailerName')
              <span class="text-red-500 text-sm">{{ $message }}</span>
              @enderror
            </div>
          </div>
          <div class="flex justify-center">
            <div class="mb-3 w-full">
              <label for="embedHtml" class="form-label inline-block mb-2 text-gray-700">Embed Html</label>
              <textarea wire:model="embedHtml" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
         @error('embedHtml')
              <span class="text-red-500 text-sm">{{ $message }}</span>
              @enderror
            </div>
          </div>
      </x-slot>
      <x-slot name="footer">
          <x-jet-button wire:click="closeEditTrailer" class="bg-gray-600 hover:bg-gray-800 text-white">Cancel
          </x-jet-button>
          <x-jet-button wire:click="addTrailer">Add Trailer</x-m-button>
      </x-slot>
  </x-jet-dialog-modal>
  </div>
