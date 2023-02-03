<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visite extends Model
{
    use HasFactory;


    public function patient() {
        return $this->belongsTo(Patient::class,'patient_id','id');
    }

    public function drugs() {
        return $this->hasMany(Ordonnance::class);
    }
    protected $table = 'visites';
    public $incrementing = true;
    protected $guarded = [];
    public $timestamps = false;
}
