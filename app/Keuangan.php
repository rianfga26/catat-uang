<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Keuangan extends Model
{
    protected $table = 'keuangan';
    protected $dateFormat = 'Y-m-d';

    public function kategori(){
        return $this->belongsTo('App\Kategori');
    }
}
