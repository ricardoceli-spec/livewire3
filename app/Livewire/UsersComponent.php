<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Livewire\Attributes\Rule;
use Livewire\WithFileUploads;

class UsersComponent extends Component
{
    use WithFileUploads;

    public $title;
    public $search;

    #[Rule('required|min:5|max:255')]
    public $name;
    #[Rule('required|email|unique:users,email')]
    public $email;
    #[Rule('required|min:6')]
    public $password;
    #[Rule('nullable|image|max:1024')]
    public $image; 

    public function createUser(){

        $this->validate();

        if($this->image){
            $customName = 'users/'.uniqid().'.'.$this->image->extension();
            $this->image->storeAs('public',$customName);
        }else{
            $customName = null;
        }

        User::create([
            'name'=> $this->name,
            'email'=> $this->email,
            'password'=> $this->password,
            'image'=> $customName
        ]);

        session()->flash('msg','Usuario creado correctamente');
        $this->reset(['name','email','password','image']);
    }
    
    public function render()
    {
        $this->title = "Usuarios";
        $usersCount = User::count();
        $users = User::where('name','like','%'.$this->search.'%')->get();

        return view('livewire.users-component',[
            'title'=>$this->title,
            'usersCount'=>$usersCount,
            'users'=>$users
        ]);
    }
}
