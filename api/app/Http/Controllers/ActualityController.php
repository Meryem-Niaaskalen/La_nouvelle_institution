<?php

namespace App\Http\Controllers;

use App\Http\Resources\ActualityResource;
use App\Models\Actuality;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ActualityController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'data' => ActualityResource::collection(
                Actuality::visible()->orderByDesc('is_pinned')->orderBy('sort_order')->orderByDesc('created_at')->get(),
            ),
        ]);
    }

    public function adminIndex(): JsonResponse
    {
        $this->authorizeManagement();

        return response()->json([
            'data' => ActualityResource::collection(
                Actuality::orderByDesc('is_pinned')->orderBy('sort_order')->orderByDesc('created_at')->get(),
            ),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $this->authorizeManagement();

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['sometimes', 'string', 'in:Événements,Annonces,Vie scolaire,Activités'],
            'description' => ['nullable', 'string'],
            'image_file' => ['required', 'file', 'image', 'max:10240'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_visible' => ['boolean'],
            'is_pinned' => ['boolean'],
        ]);

        $validated['category'] ??= 'Annonces';

        $validated['image_path'] = $request->file('image_file')->store('actualities', 'public');
        unset($validated['image_file']);

        return response()->json([
            'message' => 'Actualité créée avec succès',
            'data' => new ActualityResource(Actuality::create($validated)),
        ], 201);
    }

    public function update(Actuality $actuality, Request $request): JsonResponse
    {
        $this->authorizeManagement();

        $validated = $request->validate([
            'title' => ['sometimes', 'string', 'max:255'],
            'category' => ['sometimes', 'string', 'in:Événements,Annonces,Vie scolaire,Activités'],
            'description' => ['nullable', 'string'],
            'image_file' => ['nullable', 'file', 'image', 'max:10240'],
            'sort_order' => ['sometimes', 'integer', 'min:0'],
            'is_visible' => ['boolean'],
            'is_pinned' => ['boolean'],
        ]);

        if ($request->hasFile('image_file')) {
            $validated['image_path'] = $request->file('image_file')->store('actualities', 'public');
        }
        unset($validated['image_file']);
        $actuality->update($validated);

        return response()->json([
            'message' => 'Actualité mise à jour',
            'data' => new ActualityResource($actuality),
        ]);
    }

    public function destroy(Actuality $actuality): JsonResponse
    {
        $this->authorizeManagement();
        $actuality->delete();

        return response()->json(['message' => 'Actualité supprimée']);
    }

    private function authorizeManagement(): void
    {
        if (!auth()->user()->can('manage_actualities')) {
            throw new AuthorizationException();
        }
    }
}
