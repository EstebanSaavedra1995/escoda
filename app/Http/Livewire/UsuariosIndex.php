<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UsuariosIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search;

    public function updatingSearch(){
        $this->resetPage();
    }

    public function render()
    {
        $users = User::where('name', 'LIKE','%'. $this->search .'%')
                        ->orWhere('email', 'LIKE','%'. $this->search .'%')->paginate();
        return view('livewire.usuarios-index',compact('users'));
    }
}
