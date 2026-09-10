<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\Setting;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function send(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
        ], [
            'name.required' => 'Le nom est requis',
            'email.required' => 'L\'email est requis',
            'email.email' => 'Email invalide',
            'subject.required' => 'Le sujet est requis',
            'message.required' => 'Le message est requis',
        ]);

        $contact = ContactMessage::create($validated);

        return response()->json([
            'message' => 'Message envoyé avec succès',
            'data' => $contact,
        ], 201);
    }

    public function info(): JsonResponse
    {
        $info = [
            'address' => Setting::where('key', 'school_address')->value('value'),
            'phone' => Setting::where('key', 'school_phone')->value('value'),
            'phone_secondary' => Setting::where('key', 'school_phone_secondary')->value('value'),
            'phone_tertiary' => Setting::where('key', 'school_phone_tertiary')->value('value'),
            'email' => Setting::where('key', 'school_email')->value('value'),
            'facebook' => Setting::where('key', 'school_facebook')->value('value'),
            'lat' => Setting::where('key', 'school_coordinates_lat')->value('value'),
            'lng' => Setting::where('key', 'school_coordinates_lng')->value('value'),
        ];

        return response()->json([
            'data' => $info,
        ]);
    }

    public function messages(): JsonResponse
    {
        if (!auth()->user()->can('messages.manage')) {
            throw new AuthorizationException();
        }

        $messages = ContactMessage::orderByDesc('created_at')->paginate(10);

        return response()->json([
            'data' => $messages->items(),
            'pagination' => [
                'total' => $messages->total(),
                'per_page' => $messages->perPage(),
                'current_page' => $messages->currentPage(),
                'last_page' => $messages->lastPage(),
            ],
        ]);
    }

    public function updateMessage(ContactMessage $contactMessage, Request $request): JsonResponse
    {
        if (!auth()->user()->can('messages.manage')) {
            throw new AuthorizationException();
        }

        $validated = $request->validate([
            'status' => ['required', 'in:new,read,responded,archived'],
            'response' => ['nullable', 'string'],
        ]);

        if ($validated['status'] === 'responded') {
            $validated['responded_at'] = now();
        }

        $contactMessage->update($validated);

        return response()->json([
            'message' => 'Message mis à jour',
            'data' => $contactMessage,
        ]);
    }

    public function destroyMessage(ContactMessage $contactMessage): JsonResponse
    {
        if (!auth()->user()->can('messages.manage')) {
            throw new AuthorizationException();
        }

        $contactMessage->delete();

        return response()->json(['message' => 'Message supprimé']);
    }
}
