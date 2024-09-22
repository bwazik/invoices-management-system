<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->delete();

        $user = User::create([
            'name' => 'Abdullah Mohamed',
            'email' => 'bwazik@outlook.com',
            'password' => Hash::make('123456789'),
            'roles_name' => ['Owner', 'Admin', 'Data Entry'],
            'status' => 1,
        ]);

        $roles1 = [
            ['en' => 'Owner', 'ar' => 'المالك'],
        ];
        foreach ($roles1 as $role) {
            $role1 = Role::create(['name' => $role]);
        }

        $permissions = Permission::pluck('id' , 'id')->all();
        $role1->syncPermissions($permissions);
        $user->assignRole([$role1->id]);

        $roles2 = [
            ['en' => 'Admin', 'ar' => 'مسؤول'],
        ];
        foreach ($roles2 as $role) {
            $role2 = Role::create(['name' => $role]);
        }

        $permissions = Permission::pluck('id' , 'id')->all();
        $role2->syncPermissions($permissions);
        $user->assignRole([$role2->id]);

        $roles3 = [
            ['en' => 'Data Entry', 'ar' => 'مدخل بيانات'],
        ];
        foreach ($roles3 as $role) {
            $role3 = Role::create(['name' => $role]);
        }

        $permissions = Permission::pluck('id' , 'id')->all();
        $role3->syncPermissions($permissions);
        $user->assignRole([$role3->id]);

    }
}
