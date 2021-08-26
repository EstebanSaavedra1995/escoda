<?php

namespace App\Http\Livewire;

use Livewire\Component;

class UsuariosPassword extends Component
{

    public $password;
    public $contraseña;
    public function render()
    {
        $this->password= bcrypt($this->contraseña);
        return view('livewire.usuarios-password');
    }
}
