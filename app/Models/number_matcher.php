<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class number_matcher extends Model
{
    use HasFactory;
    protected $fillable = [
        'number','customerType','plan','number','post_or_pre','five_five'
    ];
}
