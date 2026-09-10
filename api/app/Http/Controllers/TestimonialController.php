<?php

namespace App\Http\Controllers;

use App\Http\Resources\TestimonialResource;
use App\Models\Testimonial;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function index(): JsonResponse
    {
        $testimonials = Testimonial::where('is_published', true)
            ->orderBy('order')
            ->paginate(10);

        return response()->json([
            'data' => TestimonialResource::collection($testimonials->items()),
            'pagination' => [
                'total' => $testimonials->total(),
                'per_page' => $testimonials->perPage(),
                'current_page' => $testimonials->currentPage(),
                'last_page' => $testimonials->lastPage(),
            ],
        ]);
    }

    public function featured(): JsonResponse
    {
        $testimonials = Testimonial::where('is_published', true)
            ->where('featured', true)
            ->orderBy('order')
            ->limit(4)
            ->get();

        return response()->json([
            'data' => TestimonialResource::collection($testimonials),
        ]);
    }

    public function byType(string $type): JsonResponse
    {
        $testimonials = Testimonial::where('is_published', true)
            ->where('testimonial_type', $type)
            ->orderBy('order')
            ->paginate(10);

        return response()->json([
            'data' => TestimonialResource::collection($testimonials->items()),
            'pagination' => [
                'total' => $testimonials->total(),
                'per_page' => $testimonials->perPage(),
                'current_page' => $testimonials->currentPage(),
                'last_page' => $testimonials->lastPage(),
            ],
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        if (!auth()->user()->can('manage_testimonials')) {
            throw new AuthorizationException();
        }

        $validated = $request->validate([
            'author_name' => ['required', 'string', 'max:255'],
            'author_role' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string', 'max:2000'],
            'avatar' => ['nullable', 'url'],
            'testimonial_type' => ['required', 'in:parent,student,former_student'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'is_published' => ['boolean'],
            'featured' => ['boolean'],
        ]);

        $testimonial = Testimonial::create($validated);

        return response()->json([
            'message' => 'Témoignage créé',
            'data' => new TestimonialResource($testimonial),
        ], 201);
    }

    public function update(Testimonial $testimonial, Request $request): JsonResponse
    {
        if (!auth()->user()->can('manage_testimonials')) {
            throw new AuthorizationException();
        }

        $validated = $request->validate([
            'author_name' => ['sometimes', 'string', 'max:255'],
            'author_role' => ['sometimes', 'string', 'max:255'],
            'content' => ['sometimes', 'string', 'max:2000'],
            'avatar' => ['nullable', 'url'],
            'testimonial_type' => ['sometimes', 'in:parent,student,former_student'],
            'rating' => ['sometimes', 'integer', 'min:1', 'max:5'],
            'is_published' => ['boolean'],
            'featured' => ['boolean'],
        ]);

        $testimonial->update($validated);

        return response()->json([
            'message' => 'Témoignage mis à jour',
            'data' => new TestimonialResource($testimonial),
        ]);
    }

    public function destroy(Testimonial $testimonial): JsonResponse
    {
        if (!auth()->user()->can('manage_testimonials')) {
            throw new AuthorizationException();
        }

        $testimonial->delete();

        return response()->json(['message' => 'Témoignage supprimé']);
    }
}
