<?php

namespace App\Models;

use App\Http\Controllers\api\ParticipantController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'description','questions'];

    protected $casts = [
        'questions' => 'array'
        ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function responses()
    {
        return $this->hasMany(Participant::class);
    }
}
