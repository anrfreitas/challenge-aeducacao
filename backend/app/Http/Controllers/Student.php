<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use App\Http\Requests\Student\FilterStudentRequest;
use App\Http\Requests\Student\StoreStudentRequest;
use App\Http\Transformers\StudentTransformer;
use App\Services\Student\StudentService;

class Student extends Controller
{
    public function getAll(
        StudentTransformer $transformer,
        StudentService $service
    ): Response {
        return $this->response->collection($service->all(), $transformer);
    }

    public function getById(
        StudentTransformer $transformer,
        StudentService $service,
        int $id
    ): Response {
        return $this->response->item($service->get($id), $transformer);
    }

    public function filterByName(
        FilterStudentRequest $request,
        StudentTransformer $transformer,
        StudentService $service
    ): Response {
        $data = $request->all();
        return $this->response->collection($service->filter($request->input('name')), $transformer);
    }

    public function save(
        StoreStudentRequest $request,
        StudentTransformer $transformer,
        StudentService $service
    ): Response {
        $data = $request->all();
        return $this->response->item($service->create($data), $transformer);
    }

    public function update(
        StoreStudentRequest $request,
        StudentTransformer $transformer,
        StudentService $service,
        int $id
    ): Response {
        $data = $request->all();
        return $this->response->item($service->update($data, $id), $transformer);
    }

    public function delete(
        StudentService $service,
        int $id
    ): Response {
        $service->delete($id);
        return $this->response()->noContent();
    }
}
