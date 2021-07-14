<?php

namespace App;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';

    //use HasFactory;
    protected $fillable = ['name,email,telefone'];

    public function documents() {
        return $this->hasMany('App\Document');
    }
}
