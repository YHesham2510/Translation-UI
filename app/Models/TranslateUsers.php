<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TranslateUsers extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['id', 'item_code', 'arabic_translation', 'english_translation', 'username'];
}
