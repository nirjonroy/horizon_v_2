<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PremiumCourse extends Model
{
   protected $fillable = [
        'title',
        'meta_title',
        'meta_description',
        'meta_image',
        'author',
        'publisher',
        'copyright',
        'site_name',
        'keywords',
        'slug',
        'instructor',
        'duration',
        'effort',
        'questions',
        'format',
        'price',
        'old_price',
        'type',
        'link',
        'short_description',
        'long_description',
        'image',
        'status',
    ];

    public function modules()
    {
        return $this->hasMany(PremiumCourseModule::class);
    }

    public function enrollments()
    {
        return $this->hasMany(PremiumCourseEnrollment::class);
    }
}
