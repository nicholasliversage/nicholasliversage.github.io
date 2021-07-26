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
        $cat2->name = 'Reclamacao:Falta de agua';
        $cat2->save();

        $cat4 = new Category();
        $cat4->name = 'Reclamacao:Acessorio em mau estado';
        $cat4->save();

        $cat5 = new Category();
        $cat5->name = 'Reclamacao:Factura';
        $cat5->save();

        $cat3 = new Category();
        $cat3->name = 'Pedido de Recibo';
        $cat3->save();

        $cat6 = new Category();
        $cat6->name = 'Pedido de nova ligacao';
        $cat6->save();
    }
}
