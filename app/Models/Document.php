<?php

namespace App\Models;

use App\Models\User;
use App\Models\Division;
use App\Models\Subsection;
use App\Models\DocumentStatus;
use App\Models\PersonInCharge;
use App\Models\ClassificationCode;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Document extends Model
{
    use HasFactory;

    protected $table = 'documents';

    // UUID sebagai primary key
    protected $keyType = 'string'; // Set key type to string for UUID
    public $incrementing = false; // UUID is not incrementing

    protected $fillable = [
        'number',
        'title',
        'description',
        'file_path',
        'document_creation_date',
        'uploaded_by',
        'person_in_charge_id',
        'document_status_id',
        'classification_code_id',
        'subsection_id',
        'division_id', // Pastikan kolom ini ada jika diperlukan
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

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by'); // Foreign key dengan UUID
    }

    public function personInCharge()
    {
        return $this->belongsTo(PersonInCharge::class, 'person_in_charge_id'); // Foreign key dengan UUID
    }

    public function documentStatus()
    {
        return $this->belongsTo(DocumentStatus::class, 'document_status_id'); // Foreign key dengan UUID
    }

    public function subsection()
    {
        return $this->belongsTo(Subsection::class, 'subsection_id'); // Foreign key dengan UUID
    }

    public function division()
    {
        return $this->belongsTo(Division::class, 'division_id'); // Foreign key dengan UUID
    }

    public function classificationCode()
    {
        return $this->belongsTo(ClassificationCode::class, 'classification_code_id'); // Foreign key dengan UUID
    }
}
