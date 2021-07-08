<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\User;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $r1 = Role::create(['name' => 'Root']);
        $r2 = Role::create(['name' => 'Admin']);
        $r3 = Role::create(['name' => 'User']);
        $r4 = Role::create(['name' => 'Gestor']);
        $r5 = Role::create(['name' => 'Atendimento']);
        $r6 = Role::create(['name' => 'Ligacoes']);

       
    }
}
