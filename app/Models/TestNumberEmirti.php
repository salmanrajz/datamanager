<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestNumberEmirti extends Model
{
    use HasFactory;
    protected $fillable = [
        'number','count_digit','five_four','five_five','five_eight'
    ];
}
