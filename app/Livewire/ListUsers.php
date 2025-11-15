<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class ListUsers extends Component
{
    use WithPagination;

    public $search='';
    public $numberRows = 5;

    #[On('create_user')]
    public function updateList($user = null){
        //dump($user);
    }

    //public function placeholder(){
    //    return view('placeholder');
    //}

    public function render()
    {
        $users = User::where('name', 'like', '%' . $this->search . '%')
            ->orderBy('id', 'desc')
            ->paginate($this->numberRows);

        return view('livewire.list-users', [
            'users' => $users
        ]);
    }
}
