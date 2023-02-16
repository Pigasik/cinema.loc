<div class="flex flex-col">
  <div class="w-full flex mb-4 p-2 justify-end">
    <div class="flex justify-center">
      <div class="mb-1 w-full">
        <label for="tmdb_id_g" class="form-label inline-block mb-2 text-gray-700">Cast Name</label>
        <input wire:model="castTMDBId" id="tmdb_id_g" name="tmdb_id_g" type="text" class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"/>
      </div>
    </div>
    <x-jet-button wire:click="generateCast">Create Cast</x-jet-button>  
  </div>
    <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
      <div class="py-4 inline-block min-w-full sm:px-6 lg:px-8">
        <div class="overflow-hidden">
          <table class="w-full text-center">
            <thead class="border-b bg-gray-800">
              <tr>
                <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                  Name
                </th>
                <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                  Slug
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
              @foreach ($casts as $cast)
              <tr class="bg-white border-b">
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{$cast->name}}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{$cast->slug}}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{$cast->poster_path}}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Edit and Delete</td>
              </tr>
               @endforeach
            </tbody>
            {{$casts->links()}}
          </table>
        </div>
      </div>
    </div>
  </div>
