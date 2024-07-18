<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'status', // Ensure this field name is consistent
    ];
    protected $table = 'document_status';
}
