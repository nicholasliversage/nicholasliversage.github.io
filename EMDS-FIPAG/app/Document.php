<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $table = 'document';
    
    protected $fillable = ['name','description'];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function department(){
        return $this->belongsTo('App\Department');
    }
    
    public function cliente(){
        return $this->belongsTo('App\Cliente');
    }

    public function categories() {
        return $this->belongsTo('App\Category');
    }
}
