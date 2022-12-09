<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Picture extends Model
{
    use HasFactory;
    
    protected $guarded=[];

    public function albums()
    {
      return $this->belongsTo('App\Models\Album','album_id');
    }
}
