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

class Document extends Model
{
    use HasFactory;
    public $table = 'documents';

    // app/Models/Document.php

    protected $fillable = [
        'title',
        'description',
        'file_path',
        'document_creation_date',
        'uploaded_by',
        'person_in_charge_id',
        'document_status_id',
        'classification_code_id',
        'subsection_id',
        'division_id',
    ];



    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function personInCharge()
    {
        return $this->belongsTo(PersonInCharge::class, 'person_in_charge_id');
    }

    public function documentStatus()
    {
        return $this->belongsTo(DocumentStatus::class, 'document_status_id');
    }

    public function subsection()
    {
        return $this->belongsTo(Subsection::class, 'subsection_id');
    }

    public function division()
    {
        return $this->belongsTo(Division::class, 'division_id');
    }

    // Model Document
    public function classificationCode()
    {
        return $this->belongsTo(ClassificationCode::class, 'classification_code_id');
    }

}
