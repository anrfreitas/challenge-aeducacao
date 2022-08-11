<?php

namespace App\Services\Student;

use Illuminate\Http\Response;
use App\Models\Student;
use Carbon\Carbon;
use Exception;

/**
 * Class StudentService
 * @package App\Services\Student
 */
class StudentService
{

    /**
     * @return Student[]
     */
    public function all(): Object
    {
        try {
            $students = Student::get();
            return $students;
        }
        catch(\Exception $e) {
            abort(Response::HTTP_UNPROCESSABLE_ENTITY, "Couldn't fetch students");
        }
    }

    public function get(int $id): Student
    {
        try {
            $student = Student::findOrFail($id);
            return $student;
        }
        catch(\Exception $e) {
            abort(Response::HTTP_NOT_FOUND, "Couldn't fetch student by id");
        }
    }

    /**
     * @return Student[]
     */
    public function filter(string $name): Object
    {
        try {
            return Student::query()->where('name', 'LIKE', "%{$name}%")->get();
        }
        catch(\Exception $e) {
            abort(Response::HTTP_UNPROCESSABLE_ENTITY, "Couldn't fetch students");
        }
    }

    public function create(array $data): Student
    {
        try {
            return Student::create(array(
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ) + $data);
        }
        catch(\Exception $e) {
            abort(Response::HTTP_UNPROCESSABLE_ENTITY, "Couldn't create student");
        }
    }

    public function update(array $data, int $id): Student
    {
        try {
            $input = (object) $data;
            $student = Student::findOrFail($id);
            $student->name = $input->name;
            $student->cpf = $input->cpf;
            $student->save();
            return $student;
        }
        catch(\Exception $e) {
            abort(Response::HTTP_NOT_FOUND, "Couldn't update student");
        }
    }

    public function delete(int $id): void
    {
        try {
            $student = Student::findOrFail($id);
            $student->delete();
        }
        catch(\Exception $e) {
            abort(Response::HTTP_NOT_FOUND, "Couldn't delete student");
        }
    }

}
