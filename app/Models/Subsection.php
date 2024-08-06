<?php

namespace App\Models;

use App\Models\Division;
use App\Models\Document;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Subsection extends Model
{
    use HasFactory;

    // UUID sebagai primary key
    protected $keyType = 'string'; // Set key type to string for UUID
    public $incrementing = false; // UUID is not incrementing

    protected $fillable = [
        'name',
    ];

    protected $table = 'subsections'; // Pastikan nama tabel sesuai

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid(); // Generate UUID
            }
        });
    }

    public function divisions()
    {
        return $this->belongsToMany(Division::class, 'division_subsection', 'subsection_id', 'division_id'); // Foreign key dengan UUID
    }

    // Relasi many-to-many dengan User melalui tabel pivot subsection_user
    public function users()
    {
        return $this->belongsToMany(User::class, 'subsection_user', 'subsection_id', 'user_id'); // Foreign key dengan UUID
    }

    public function documents()
    {
        return $this->hasMany(Document::class, 'subsection_id'); // Foreign key dengan UUID
    }
}
