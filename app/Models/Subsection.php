<?php

namespace App\Models;

use App\Models\Division;
use App\Models\Document;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subsection extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
    ];

    // protected $table = 'subsections';
    public function divisions()
    {
        return $this->belongsToMany(Division::class, 'division_subsection', 'subsection_id', 'division_id');
    }

    // Relasi many-to-many dengan User melalui tabel pivot subsection_user
    public function users()
    {
        return $this->belongsToMany(User::class, 'subsection_user', 'subsection_id', 'user_id');
    }
    // App\Models\Subsection.php
    public function documents()
    {
        return $this->hasMany(Document::class, 'subsection_id');
    }
}
