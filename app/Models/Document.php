<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    // app/Models/Document.php

    protected $fillable = [
        'title',
        'description',
        'file_path',
        'uploaded_by',
        'person_in_charge_id',
        'document_status_id',
        'year',
        'code'
    ];

    public $table = 'documents';
    public function personInCharge()
    {
        return $this->belongsTo(PersonInCharge::class, 'person_in_charge_id');
    }

    public function documentStatus()
    {
        return $this->belongsTo(DocumentStatus::class, 'document_status_id');
    }
}
