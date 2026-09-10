<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProgramResource;
use App\Models\Program;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function index(): JsonResponse
    {
        $programs = Program::published()
            ->ordered()
            ->paginate(10);

        return response()->json([
            'data' => ProgramResource::collection($programs->items()),
            'pagination' => [
                'total' => $programs->total(),
                'per_page' => $programs->perPage(),
                'current_page' => $programs->currentPage(),
                'last_page' => $programs->lastPage(),
            ],
        ]);
    }

    public function show(Program $program): JsonResponse
    {
        return response()->json([
            'data' => new ProgramResource($program),
        ]);
    }

    public function byLevel(string $level): JsonResponse
    {
        $programs = Program::published()
            ->ordered()
            ->when($level, fn ($query) => $query->where('name', 'like', '%' . $level . '%'))
            ->get();

        return response()->json([
            'data' => ProgramResource::collection($programs),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        if (!auth()->user()->can('programs.manage')) {
            throw new AuthorizationException();
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'unique:programs,slug'],
            'summary' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'icon' => ['nullable', 'string', 'max:255'],
            'image_path' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        $program = Program::create([
            'name' => $validated['title'],
            'slug' => $validated['slug'],
            'description' => $validated['description'] ?? $validated['summary'] ?? null,
            'icon' => $validated['icon'] ?? null,
            'order' => $validated['sort_order'] ?? 0,
            'is_published' => (bool) ($validated['is_published'] ?? true),
        ]);

        return response()->json([
            'message' => 'Programme créé avec succès',
            'data' => new ProgramResource($program),
        ], 201);
    }

    public function update(Program $program, Request $request): JsonResponse
    {
        if (!auth()->user()->can('programs.manage')) {
            throw new AuthorizationException();
        }

        $validated = $request->validate([
            'title' => ['sometimes', 'string', 'max:255'],
            'slug' => ['sometimes', 'string', 'unique:programs,slug,' . $program->id],
            'summary' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'icon' => ['nullable', 'string', 'max:255'],
            'image_path' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        $program->update([
            'name' => $validated['title'] ?? $program->name,
            'slug' => $validated['slug'] ?? $program->slug,
            'description' => $validated['description'] ?? $validated['summary'] ?? $program->description,
            'icon' => $validated['icon'] ?? $program->icon,
            'order' => $validated['sort_order'] ?? $program->order,
            'is_published' => array_key_exists('is_published', $validated) ? (bool) $validated['is_published'] : $program->is_published,
        ]);

        return response()->json([
            'message' => 'Programme mis à jour',
            'data' => new ProgramResource($program),
        ]);
    }

    public function destroy(Program $program): JsonResponse
    {
        if (!auth()->user()->can('programs.manage')) {
            throw new AuthorizationException();
        }

        $program->delete();

        return response()->json([
            'message' => 'Programme supprimé',
        ]);
    }
}
