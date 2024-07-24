<?php

namespace App\Models;

use App\Models\User;
use App\Models\Document;
use App\Models\Subsection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Division extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
    ];

     public function users()
    {
        return $this->hasMany(User::class);
    }
    public function subsections()
    {
        return $this->belongsToMany(Subsection::class, 'division_subsection');
    }
    // app/Models/Division.php
    public function documents()
    {
        return $this->hasMany(Document::class);
    }

}
