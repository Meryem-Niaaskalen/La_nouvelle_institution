<?php

namespace App\Http\Controllers;

use App\Http\Resources\ActivityResource;
use App\Models\Activity;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index(): JsonResponse
    {
        $activities = Activity::where('is_published', true)
            ->with('category')
            ->orderByDesc('activity_date')
            ->paginate(10);

        return response()->json([
            'data' => ActivityResource::collection($activities->items()),
            'pagination' => [
                'total' => $activities->total(),
                'per_page' => $activities->perPage(),
                'current_page' => $activities->currentPage(),
                'last_page' => $activities->lastPage(),
            ],
        ]);
    }

    public function featured(): JsonResponse
    {
        $activities = Activity::where('is_published', true)
            ->where('featured', true)
            ->with('category')
            ->orderByDesc('activity_date')
            ->limit(6)
            ->get();

        return response()->json([
            'data' => ActivityResource::collection($activities),
        ]);
    }

    public function show(Activity $activity): JsonResponse
    {
        if (!$activity->is_published && !auth()->check()) {
            return response()->json(['message' => 'Non trouvé'], 404);
        }

        $activity->load('category');
        $activity->increment('views');

        return response()->json([
            'data' => new ActivityResource($activity),
        ]);
    }

    public function byCategory(string $categorySlug): JsonResponse
    {
        $activities = Activity::whereHas('category', function ($query) use ($categorySlug) {
            $query->where('slug', $categorySlug);
        })
            ->where('is_published', true)
            ->with('category')
            ->orderByDesc('activity_date')
            ->paginate(10);

        return response()->json([
            'data' => ActivityResource::collection($activities->items()),
            'pagination' => [
                'total' => $activities->total(),
                'per_page' => $activities->perPage(),
                'current_page' => $activities->currentPage(),
                'last_page' => $activities->lastPage(),
            ],
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        if (!auth()->user()->can('manage_activities')) {
            throw new AuthorizationException();
        }

        $validated = $request->validate([
            'category_id' => ['required', 'exists:activity_categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'unique:activities,slug'],
            'description' => ['required', 'string', 'max:1000'],
            'full_content' => ['nullable', 'string'],
            'activity_date' => ['required', 'date'],
            'start_time' => ['nullable', 'date_format:H:i'],
            'end_time' => ['nullable', 'date_format:H:i'],
            'location' => ['nullable', 'string', 'max:255'],
            'facebook_link' => ['nullable', 'url'],
            'is_published' => ['boolean'],
            'featured' => ['boolean'],
        ]);

        $activity = Activity::create($validated);
        $activity->load('category');

        return response()->json([
            'message' => 'Activité créée avec succès',
            'data' => new ActivityResource($activity),
        ], 201);
    }

    public function update(Activity $activity, Request $request): JsonResponse
    {
        if (!auth()->user()->can('manage_activities')) {
            throw new AuthorizationException();
        }

        $validated = $request->validate([
            'category_id' => ['sometimes', 'exists:activity_categories,id'],
            'title' => ['sometimes', 'string', 'max:255'],
            'slug' => ['sometimes', 'string', 'unique:activities,slug,' . $activity->id],
            'description' => ['sometimes', 'string', 'max:1000'],
            'full_content' => ['nullable', 'string'],
            'activity_date' => ['sometimes', 'date'],
            'start_time' => ['nullable', 'date_format:H:i'],
            'end_time' => ['nullable', 'date_format:H:i'],
            'location' => ['nullable', 'string', 'max:255'],
            'facebook_link' => ['nullable', 'url'],
            'is_published' => ['boolean'],
            'featured' => ['boolean'],
        ]);

        $activity->update($validated);
        $activity->load('category');

        return response()->json([
            'message' => 'Activité mise à jour',
            'data' => new ActivityResource($activity),
        ]);
    }

    public function destroy(Activity $activity): JsonResponse
    {
        if (!auth()->user()->can('manage_activities')) {
            throw new AuthorizationException();
        }

        $activity->delete();

        return response()->json([
            'message' => 'Activité supprimée',
        ]);
    }
}
