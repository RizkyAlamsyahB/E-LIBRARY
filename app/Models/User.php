<?php

namespace App\Models;

use App\Models\Division;
use App\Models\Document;
use App\Models\Subsection; // Pastikan untuk mengimpor model Subsection
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

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

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class, 'uploaded_by');
    }

    // Relasi many-to-many dengan Subsection melalui tabel pivot subsection_user
    public function userSubsections()
    {
        return $this->belongsToMany(Subsection::class, 'subsection_user', 'user_id', 'subsection_id');
    }
}
