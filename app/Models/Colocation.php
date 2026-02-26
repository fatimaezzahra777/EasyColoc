<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Colocation extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'owner_id', 'status'];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
    public function memberships()
    {
        return $this->hasMany(Membership::class);
    }

    public function dépenses()
    {
        return $this->hasMany(Dépenses::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'memberships')
            ->withPivot(['role', 'left_at'])
            ->withTimestamps();
    }
    public function invitations()
    {
        return $this->hasMany(ColocationInvitation::class);
    }
}
