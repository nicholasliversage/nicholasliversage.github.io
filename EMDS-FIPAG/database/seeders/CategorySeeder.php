<?php

namespace Database\Seeders;
use App\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cat1 = new Category();
        $cat1->name = 'Novo Cliente';
        $cat1->save();

        $cat2 = new Category();
        $cat2->name = 'Reclamacao';
        $cat2->save();

        $cat3 = new Category();
        $cat3->name = 'Recibo';
        $cat3->save();
    }
}
