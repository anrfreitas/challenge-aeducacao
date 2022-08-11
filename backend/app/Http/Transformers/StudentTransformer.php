<?php

namespace App\Http\Transformers;

use App\Transformers\AbstractTransFormer;
use App\Models\Student;

class StudentTransformer extends AbstractTransFormer
{

    /**
     * @param Student $student
     * @return array
     */
    public function transform(Student $student): array
    {
        return [
            'id' => $student->id,
            'name' => $student->name,
            'cpf' => $student->cpf,
        ];
    }
}
