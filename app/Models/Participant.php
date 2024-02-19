<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    use HasFactory;

    protected $fillable = ['participant_name','responses'];
    
    protected $casts = [
        'responses' => 'array'
        ];

    public function sondage(){
        return $this->belongsTo(Post::class);
    }
}
