<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;
    protected $fillable = [
        'job_title', 'job_category', 'job_nature', 'vacancy', 'salary', 'location',
        'description', 'benefits', 'responsibility', 'qualification', 'keywords',
        'company_name', 'company_location', 'company_website',
    ];


    public function Categories()
    {
        return $this->belongsTo(Categories::class, 'job_category', 'name');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jobApplies()
    {
        return $this->hasMany(JobApply::class, 'job_id');
    }
}
