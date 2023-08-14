<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Repositories\Todo\EloquentTodoRepository;
use Illuminate\Http\Request;
use App\Models\Todo;

class TodoController extends Controller
{
    /**
     * @var EloquentTodoRepository
     */
    protected $repository;

    /**
     * _constructor.
     */
    public function __construct(EloquentTodoRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get todo List.
     * 
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        return response()->json($this->repository->getAll());
    }

    /**
     * Create todo.
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $this->repository->create($request->all());

        return response()->json($this->repository->getAll());
    }

    /**
     * Destroy todo.
     * 
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(Request $request, int $id): JsonResponse
    {
        if ($this->repository->destroy($request->all())) {
            return response()->json([
                'status' => true
            ]);
        }

        return response()->json([
            'status' => false
        ]);
    }
}
