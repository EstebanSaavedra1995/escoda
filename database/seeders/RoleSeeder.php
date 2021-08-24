<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $rol1= Role::create(['name' => 'admin']);
       $rol2= Role::create(['name' => 'usuario']);

       Permission::create(['name' => 'construccion.confeccionar'])->syncRoles([$rol1]);
       Permission::create(['name' => 'horarios.maquinas'])->syncRoles([$rol2]);
       Permission::create(['name' => 'confeccionar.despiece'])->syncRoles([$rol1]);
       Permission::create(['name' => 'registrar.egresos'])->syncRoles([$rol1]);
       Permission::create(['name' => 'listar'])->syncRoles([$rol1]);
       Permission::create(['name' => 'construccion.listarcancelar'])->syncRoles([$rol1]);
       Permission::create(['name' => 'control.maquina'])->syncRoles([$rol1]);
       Permission::create(['name' => 'reparacion.confeccionar'])->syncRoles([$rol1]);
       Permission::create(['name' => 'control.horarios.maquina'])->syncRoles([$rol1]);

    }
}
