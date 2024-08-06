<?php

namespace App\Models;

use App\Models\Document;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class DocumentStatus extends Model
{
    use HasFactory;

    // UUID sebagai primary key
    protected $keyType = 'string'; // Set key type to string for UUID
    public $incrementing = false; // UUID is not incrementing

    protected $fillable = [
        'status', // Ensure this field name is consistent
    ];

    protected $table = 'document_status';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid(); // Generate UUID
            }
        });
    }

    public function documents()
    {
        return $this->hasMany(Document::class, 'document_status_id'); // Foreign key dengan UUID
    }
}
