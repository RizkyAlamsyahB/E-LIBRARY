<?php

namespace App\Models;

use App\Models\Division;
use App\Models\Document;
use App\Models\Subsection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Support\Str;

class User extends Authenticatable implements MustVerifyEmailContract
{
    use HasFactory, Notifiable;

    // UUID sebagai primary key
    protected $keyType = 'string'; // Set key type to string for UUID
    public $incrementing = false; // UUID is not incrementing

    protected $fillable = [
        'name',
        'email',
        'password',
        'photo',
        'gender',
        'date_of_birth',
        'phone',
        'role',
        'email_verified_at',
        'division_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
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

    public function division()
    {
        return $this->belongsTo(Division::class, 'division_id'); // Foreign key dengan UUID
    }

    public function documents()
    {
        return $this->hasMany(Document::class, 'uploaded_by'); // Foreign key dengan UUID
    }

    public function subsections()
    {
        return $this->belongsToMany(Subsection::class, 'subsection_user', 'user_id', 'subsection_id'); // Foreign key dengan UUID
    }
}
