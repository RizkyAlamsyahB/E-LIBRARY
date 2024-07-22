<?php

namespace App\Models;

use App\Models\Document;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DocumentStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'status', // Ensure this field name is consistent
    ];

    protected $table = 'document_status';

    public function documents()
    {
        return $this->hasMany(Document::class, 'document_status_id');
    }
}
