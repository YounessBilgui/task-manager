<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\WithPagination;

class UserManger extends Component
{
    use WithPagination;

    public $name;
    public $email;
    public $password;
    public $confirmingDelete = null;

    protected $rules = [
        'name' => 'required|string',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6',
    ];

    public function createUser()
    {
        $this->validate();

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);
        $user->assignRole("user");
        $this->reset(['name', 'email', 'password']);
        session()->flash('message', 'User created successfully');
    }
    public function deleteUser($userId)
    {
        User::findOrFail($userId)->delete();
        $this->confirmingDelete = null;
        session()->flash('message', 'User deleted successfully');
    }

    public function confirmDelete($userId)
    {
        $this->confirmingDelete = $userId;
    }

    public function cancelDelete()
    {
        $this->confirmingDelete = null;
    }

    public function render()
    {
        $users = User::whereDoesntHave('roles', function ($q) {
            $q->where('name', 'admin');
        })->latest()->paginate(10);

        return view('livewire.user-manager', compact('users'))
            ->layout('layouts.app');
    }
}
