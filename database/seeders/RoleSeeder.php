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
        $rol1 = Role::create(['name' => 'admin']);
        $rol2 = Role::create(['name' => 'usuario']);

        /* Permission::create([
            'name' => 'construccion.confeccionar',
            'description' => 'Construccion Confeccionar'
        ])->syncRoles([$rol1]); */
        Permission::create([
            'name' => 'ordenes.trabajo',
            'description' => 'Ordenes de Trabajo'
        ])->syncRoles([$rol2]);
        Permission::create([
            'name' => 'stock',
            'description' => 'Stock'
        ])->syncRoles([$rol2]);
        Permission::create([
            'name' => 'egresos.etiquetas',
            'description' => 'Egresos y Etiquetas'
        ])->syncRoles([$rol2]);
        Permission::create([
            'name' => 'horarios.maquinas',
            'description' => 'Horarios Maquinas'
        ])->syncRoles([$rol2]);
        /* Permission::create([
            'name' => 'confeccionar.despiece',
            'description' => 'Stock Confeccionar Despiece'
        ])->syncRoles([$rol1]);
        Permission::create([
            'name' => 'registrar.egresos',
            'description' => 'Egresos y Etiquetas Registrar Egresos'
        ])->syncRoles([$rol1]);
        Permission::create([
            'name' => 'listar',
            'description' => 'Egresos y Etiquetas Listar'
        ])->syncRoles([$rol1]);
        Permission::create([
            'name' => 'construccion.listarcancelar',
            'description' => 'Construccion Listar/Cancelar'
        ])->syncRoles([$rol1]); 
         Permission::create([
            'name' => 'reparacion.confeccionar',
            'description' => 'Reparacion Confeccionar'
        ])->syncRoles([$rol1]); */
        Permission::create([
            'name' => 'proveedores',
            'description' => 'Proveedores'
        ])->syncRoles([$rol1]);
        Permission::create([
            'name' => 'datos',
            'description' => 'Datos'
        ])->syncRoles([$rol1]);
        Permission::create([
            'name' => 'control.horarios.maquina',
            'description' => 'Control Horarios Maquina'
        ])->syncRoles([$rol1]);
        Permission::create([
            'name' => 'usuarios',
            'description' => 'Usuarios'
        ])->syncRoles([$rol1]);

        Permission::create([
            'name' => 'roles',
            'description' => 'Roles'
        ])->syncRoles([$rol1]);
        
        Permission::create([
            'name' => 'maquinas',
            'description' => 'Maquinas'
        ])->syncRoles([$rol1]);
    }
}
