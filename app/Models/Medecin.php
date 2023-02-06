<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medecin extends Model
{
    use HasFactory;

    public function user() {
        return $this->hasOne(User::class,'id','idUser');
    }

    protected $guarded = ['password'];
    public const UPDATED_AT = null;
    public const CREATED_AT = 'dateInscription';

}
