<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['titre', 'description', 'user_id'];

    public function reponses()
    {
        return $this->hasMany(Reponse::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
