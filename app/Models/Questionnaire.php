<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Questionnaire extends Model
{
    use HasFactory;
    protected $fillable = ['questions', 'post_id'];
    public function questions()
    {
        return $this->hasMany(Questionnaire::class);
    }

}
