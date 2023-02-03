<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    public function visites() {
        return $this->hasMany(Visite::class);
    }
    public function medicines()
    {
        return $this->hasManyThrough(Ordonnance::class, Visite::class);
    }
    protected $table = 'patients';
    protected $guarded = [];
    public $timestamps = false;
    public $incrementing = true;
}
