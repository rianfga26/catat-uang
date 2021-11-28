<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategori';
    protected $guarded = []; 

    public function keuangan(){
        return $this->hasMany('App\Keuangan');
    }
}
