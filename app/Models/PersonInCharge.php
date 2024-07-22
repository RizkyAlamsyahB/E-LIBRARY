<?php

namespace App\Models;

use App\Models\Document;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PersonInCharge extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    protected $table = 'persons_in_charge';

    public function documents()
    {
        return $this->hasMany(Document::class, 'person_in_charge_id');
    }
}
