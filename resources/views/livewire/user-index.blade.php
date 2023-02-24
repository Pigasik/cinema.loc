<div class="flex flex-col">
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
                  Email
                  </th>
                  <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                    Roles
                </th>
                <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                  Action
                </th>
              </tr>
            </thead class="border-b">
            <tbody>
              @foreach($users as $user)
              <tr class="bg-white border-b">
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{$user->name}}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{$user->email}}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{$user->roles()->pluck('name')->implode(' ')}}</td>
                
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                  <x-jet-button wire:click="editUser({{ $user->id }})"
                    class="bg-green-500 hover:bg-green-700 text-white text-white">Edit</x-jet-button>
                <x-jet-button wire:click="deleteUser({{ $user->id }})"
                    class="bg-red-500 hover:bg-red-700 text-white">Delete</x-jet-button>
                </td>
              </tr> 
              @endforeach  
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <x-jet-dialog-modal wire:model="showCreate">
      
      <x-slot name="title">Edit User</x-slot>
     
      <x-slot name="content">
        <div class="flex justify-center">
          <div class="mb-3 w-full">
            <label for="name" class="form-label inline-block mb-2 text-gray-700">Name</label>
            <input wire:model="userName" type="text" class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"/>
          </div>
        </div>
        <div class="flex justify-center">
            <div class="mb-3 w-full">
              <label for="userEmail" class="form-label inline-block mb-2 text-gray-700">Email</label>
              <input wire:model="userEmail" type="text" class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"/>
            </div>
          </div>
          <div class="flex justify-center">
            <div class="mb-3 w-full">
                <label for="userRoles" class="form-label inline-block mb-2 text-gray-700">Roles</label>
                <input wire:model="userRoles" type="text" class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"/>
              </div>  
        </div>
        <div class="flex justify-center">
            <div class="mb-3 w-full">
                <label class="form-label inline-block mb-2 text-gray-700">All roles</label><br>
                @foreach ($roles = Spatie\Permission\Models\Role::pluck('name','name')->all() as $role)
                <input  wire:model="roles" type="checkbox" value="{{ $role }}"
                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                <label class="form-label inline-block mb-2 text-gray-700">{{ $role }}</label><br>
                @endforeach
              </div>  
        </div>
       
        
      </x-slot>
      <x-slot name="footer">
        
        <x-jet-button wire:click="updateUser">Edit</x-jet-button>
        
        <x-jet-button class="px-4" wire:click="closeCreateUser">Close</x-jet-button>
      </x-slot>
    </x-jet-dialog-model>
  </div>
