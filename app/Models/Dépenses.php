<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dépenses extends Model
{
    protected $fillable = ['colocation_id', 'user_id', 'description', 'montant', 'category_id'];
}
