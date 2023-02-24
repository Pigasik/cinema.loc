<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class UserIndex extends Component
{
    public $search = '';
    public $showCreate = false;
    public $users = [];
    public $userName;
    public $userEmail;
    public $userRoles;
    public $userId;
    public $roles;

    public function mount(){
        $this->users = User::all();
    }

    public function editUser($userId){
        $user = User::find($userId);
        $this->userName = $user->name;
        $this->userEmail = $user->email;
        $this->userRoles = $user->roles->pluck('name');
        $this->showCreate = true;
    }

    public function updateUser(){
        
        $this->showCreate = false;
        $this->dispatchBrowserEvent('banner-message', ['style' => 'success', 'message' => 'User update successfully']);
    }

    public function deleteUser($userId){
        $user = User::findorFail($userId);
        $user->delete();        
    }

    public function closeCreateUser(){
        $this->showCreate = false;
    }

    public function render()
    {
        return view('livewire.user-index', [
            'users' => User::search('name', $this->search)->paginate(10)
        ]);
    }
}
