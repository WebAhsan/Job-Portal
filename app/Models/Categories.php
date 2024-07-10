<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;
    public $table = 'categoris';
    protected $fillable = ['name', 'slug'];

    public function listings()
    {
        return $this->hasMany(Listing::class, 'job_category', 'name');
    }
}
