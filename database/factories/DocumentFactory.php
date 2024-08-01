<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\PersonInCharge;
use App\Models\DocumentStatus;
use App\Models\ClassificationCode;
use App\Models\Subsection;

class DocumentFactory extends Factory
{
    protected $model = \App\Models\Document::class;

    public function definition()
    {
        return [
            'number' => $this->faker->unique()->numerify('DOC-#####'),
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'file_path' => $this->faker->filePath,
            'document_creation_date' => $this->faker->date,
            'uploaded_by' => User::inRandomOrder()->value('id'),
            'person_in_charge_id' => PersonInCharge::inRandomOrder()->value('id'),
            'document_status_id' => DocumentStatus::inRandomOrder()->value('id'),
            'classification_code_id' => ClassificationCode::inRandomOrder()->value('id'),
            'subsection_id' => Subsection::inRandomOrder()->value('id'),
        ];
    }
}
