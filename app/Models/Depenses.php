<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Depenses extends Model
{
    protected $fillable = [
        'colocation_id', 
        'user_id', 
        'description',
        'montant', 
        'category_id'
    ];

    public function colocation()
    {
        return $this->belongsTo(Colocation::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category(){
        return $this->belongsTo(Depenses::class);
    }
}
