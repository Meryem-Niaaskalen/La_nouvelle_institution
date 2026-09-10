<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function public(): JsonResponse
    {
        $settings = Setting::whereIn('key', [
            'school_name',
            'school_motto',
            'school_address',
            'school_phone',
            'school_phone_secondary',
            'school_phone_tertiary',
            'school_email',
            'school_facebook',
            'total_students',
            'total_teachers',
            'total_graduates',
            'years_of_operation',
        ])->pluck('value', 'key');

        return response()->json([
            'data' => $settings,
        ]);
    }

    public function all(): JsonResponse
    {
        if (!auth()->user()->can('settings.manage') && !auth()->user()->can('manage_settings')) {
            throw new AuthorizationException();
        }

        $settings = Setting::all();

        return response()->json([
            'data' => $settings,
        ]);
    }

    public function update(string $key, Request $request): JsonResponse
    {
        if (!auth()->user()->can('settings.manage') && !auth()->user()->can('manage_settings')) {
            throw new AuthorizationException();
        }

        $validated = $request->validate([
            'value' => ['nullable', 'string'],
        ]);

        $setting = Setting::updateOrCreate(
            ['key' => $key],
            ['value' => $validated['value']]
        );

        return response()->json([
            'message' => 'Paramètre mis à jour',
            'data' => $setting,
        ]);
    }
}
