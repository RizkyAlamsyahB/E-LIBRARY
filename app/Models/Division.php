<?php

namespace App\Models;

use App\Models\User;
use App\Models\Document;
use App\Models\Subsection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Division extends Model
{
    use HasFactory;

    // UUID sebagai primary key
    protected $keyType = 'string'; // Set key type to string for UUID
    public $incrementing = false; // UUID is not incrementing

    protected $fillable = [
        'name',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid(); // Generate UUID
            }
        });
    }

    public function users()
    {
        return $this->hasMany(User::class, 'division_id'); // Sesuaikan jika menggunakan UUID
    }

    public function subsections()
    {
        return $this->belongsToMany(Subsection::class, 'division_subsection', 'division_id', 'subsection_id'); // Sesuaikan jika menggunakan UUID
    }

    public function documents()
    {
        return $this->hasMany(Document::class, 'division_id'); // Sesuaikan jika menggunakan UUID
    }
}
