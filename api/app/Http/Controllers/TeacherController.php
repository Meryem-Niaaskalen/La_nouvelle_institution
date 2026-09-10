<?php

namespace App\Http\Controllers;

use App\Http\Resources\TeacherResource;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index(): JsonResponse
    {
        $teachers = Teacher::active()
            ->with('user')
            ->ordered()
            ->paginate(10);

        return response()->json([
            'data' => TeacherResource::collection($teachers->items()),
            'pagination' => [
                'total' => $teachers->total(),
                'per_page' => $teachers->perPage(),
                'current_page' => $teachers->currentPage(),
                'last_page' => $teachers->lastPage(),
            ],
        ]);
    }

    public function show(Teacher $teacher): JsonResponse
    {
        $teacher->load('user');

        return response()->json([
            'data' => new TeacherResource($teacher),
        ]);
    }

    public function bySpecialization(string $specialization): JsonResponse
    {
        $teachers = Teacher::active()
            ->where('specialization', $specialization)
            ->with('user')
            ->ordered()
            ->get();

        return response()->json([
            'data' => TeacherResource::collection($teachers),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        if (!auth()->user()->can('manage_teachers')) {
            throw new AuthorizationException();
        }

        $rules = [
            'user_id' => ['nullable', 'exists:users,id', 'unique:teachers,user_id'],
            'specialization' => ['required', 'string', 'max:255'],
            'diploma' => ['nullable', 'string', 'max:255'],
            'experience_years' => ['required', 'integer', 'min:0', 'max:70'],
            'bio' => ['nullable', 'string'],
            'phone' => ['nullable', 'string', 'max:20'],
            'hire_date' => ['nullable', 'date'],
        ];

        // Only validate `status` if the underlying table has that column.
        try {
            if (\Illuminate\Support\Facades\Schema::hasColumn((new Teacher())->getTable(), 'status')) {
                $rules['status'] = ['required', 'in:active,inactive,on_leave'];
            }
        } catch (\Throwable $e) {
            // ignore schema check failures and skip status validation
        }

        $validated = $request->validate($rules);

        $teacher = Teacher::create($validated);
        $teacher->load('user');

        return response()->json([
            'message' => 'Enseignant créé avec succès',
            'data' => new TeacherResource($teacher),
        ], 201);
    }

    public function update(Teacher $teacher, Request $request): JsonResponse
    {
        if (!auth()->user()->can('manage_teachers')) {
            throw new AuthorizationException();
        }

        $rules = [
            'specialization' => ['sometimes', 'string', 'max:255'],
            'diploma' => ['nullable', 'string', 'max:255'],
            'experience_years' => ['sometimes', 'integer', 'min:0', 'max:70'],
            'bio' => ['nullable', 'string'],
            'phone' => ['nullable', 'string', 'max:20'],
            'hire_date' => ['nullable', 'date'],
        ];

        try {
            if (\Illuminate\Support\Facades\Schema::hasColumn((new Teacher())->getTable(), 'status')) {
                $rules['status'] = ['sometimes', 'in:active,inactive,on_leave'];
            }
        } catch (\Throwable $e) {
            // ignore
        }

        $validated = $request->validate($rules);

        $teacher->update($validated);
        $teacher->load('user');

        return response()->json([
            'message' => 'Enseignant mis à jour',
            'data' => new TeacherResource($teacher),
        ]);
    }

    public function destroy(Teacher $teacher): JsonResponse
    {
        if (!auth()->user()->can('manage_teachers')) {
            throw new AuthorizationException();
        }

        $teacher->delete();

        return response()->json([
            'message' => 'Enseignant supprimé',
        ]);
    }
}
