<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $root = new User();
        $root->name = 'Wade Wilson';
        $root->email = 'deadp00l@gmail.com';
        $root->password = 'deadp00l';
        $root->department_id = '1';
        $root->status = true;
        $root->save();

        $r1 = Role::where('name','Root')->first();
        $permissions = Permission::pluck('id','id')->all();
        $r1->syncPermissions($permissions);
        $root->assignRole($r1);

        $admin = new User();
        $admin->name = 'Tony Stark';
        $admin->email = 'ir0nman@gmail.com';
        $admin->password = 'ir0nman';
        $admin->department_id = '1';
        $admin->status = true;
        $admin->save();

        $r2 = Role::where('name','User')->first();
        $permissions2 = Permission::pluck('id','id')->all();
        $r2->syncPermissions($permissions2);
        $admin->assignRole($r2);

        $r21 = Role::where('name','Gestor')->first();
        $r21->syncPermissions($permissions2);
        $admin->assignRole($r21);

        $user = new User();
        $user->name = 'Steve Rogers';
        $user->email = 'captain@gmail.com';
        $user->password = 'captain';
        $user->department_id = '2';
        $user->status = true;
        $user->save();

        $r3 = Role::where('name','User')->first();
        $permissions3 = Permission::pluck('id','id')->all();
        $r3->syncPermissions($permissions3);
        $user->assignRole($r3);

        $r4 = Role::where('name','Atendimento')->first();
        $permissions4 = Permission::pluck('id','id')->all();
        $r4->syncPermissions($permissions4);
        $user->assignRole($r4);
    }
}
