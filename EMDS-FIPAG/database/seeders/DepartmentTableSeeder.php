<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Department;

class DepartmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dept1 = new Department();
        $dept1->dptName = 'GESTOR DE ZONA';
        $dept1->save();

        $dept2 = new Department();
        $dept2->dptName = 'ATENDIMENTO';
        $dept2->save();

        $dept3 = new Department();
        $dept3->dptName = 'DEPARTAMENTO TECNICO';
        $dept3->save();

        $dept4 = new Department();
        $dept4->dptName = 'SECCAO DE LIGACOES';
        $dept4->save();
    }
}
