<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\ActualityController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function (): void {
    // Health check
    Route::get('/health', function () {
        return response()->json([
            'status' => 'ok',
            'app' => config('app.name'),
            'locale' => app()->getLocale(),
        ]);
    });

    // Authentication Routes (Public)
    Route::get('/sanctum/csrf-cookie', [\Laravel\Sanctum\Http\Controllers\CsrfCookieController::class, 'show']);
    Route::post('/auth/login', [AuthController::class, 'login']);

    // Protected Auth Routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/auth/logout', [AuthController::class, 'logout']);
        Route::post('/auth/refresh', [AuthController::class, 'refresh']);
        Route::get('/auth/me', [AuthController::class, 'me']);
    });

    // Public Routes - No Authentication Required
    Route::group([], function () {
        // Programs
        Route::get('/programs', [ProgramController::class, 'index']);
        Route::get('/programs/{program}', [ProgramController::class, 'show']);
        Route::get('/programs/level/{level}', [ProgramController::class, 'byLevel']);

        // Teachers
        Route::get('/teachers', [TeacherController::class, 'index']);
        Route::get('/teachers/{teacher}', [TeacherController::class, 'show']);
        Route::get('/teachers/specialization/{specialization}', [TeacherController::class, 'bySpecialization']);

        // Activities
        Route::get('/activities', [ActivityController::class, 'index']);
        Route::get('/activities/featured', [ActivityController::class, 'featured']);
        Route::get('/activities/{activity}', [ActivityController::class, 'show']);
        Route::get('/activities/category/{categorySlug}', [ActivityController::class, 'byCategory']);

        // Gallery
        Route::get('/gallery/categories', [GalleryController::class, 'categories']);
        Route::get('/gallery/{category}', [GalleryController::class, 'category']);
        Route::get('/gallery/{category}/images', [GalleryController::class, 'images']);

        // Actualities
        Route::get('/actualities', [ActualityController::class, 'index']);

        // Testimonials
        Route::get('/testimonials', [TestimonialController::class, 'index']);
        Route::get('/testimonials/featured', [TestimonialController::class, 'featured']);
        Route::get('/testimonials/type/{type}', [TestimonialController::class, 'byType']);

        // Settings
        Route::get('/settings/public', [SettingController::class, 'public']);

        // Contact
        Route::post('/contact/send', [ContactController::class, 'send']);
        Route::get('/contact/info', [ContactController::class, 'info']);
    });

    // Admin Routes - Protected with Sanctum
    Route::middleware('auth:sanctum')->group(function () {
        // Teachers Management
        Route::post('/admin/teachers', [TeacherController::class, 'store']);
        Route::put('/admin/teachers/{teacher}', [TeacherController::class, 'update']);
        Route::delete('/admin/teachers/{teacher}', [TeacherController::class, 'destroy']);

        // Programs Management
        Route::post('/admin/programs', [ProgramController::class, 'store']);
        Route::put('/admin/programs/{program}', [ProgramController::class, 'update']);
        Route::delete('/admin/programs/{program}', [ProgramController::class, 'destroy']);

        // Activities Management
        Route::post('/admin/activities', [ActivityController::class, 'store']);
        Route::put('/admin/activities/{activity}', [ActivityController::class, 'update']);
        Route::delete('/admin/activities/{activity}', [ActivityController::class, 'destroy']);

        // Gallery Management
        Route::post('/admin/gallery/categories', [GalleryController::class, 'storeCategory']);
        Route::put('/admin/gallery/categories/{category}', [GalleryController::class, 'updateCategory']);
        Route::delete('/admin/gallery/categories/{category}', [GalleryController::class, 'destroyCategory']);

        Route::post('/admin/gallery/images', [GalleryController::class, 'storeImage']);
        Route::put('/admin/gallery/images/{image}', [GalleryController::class, 'updateImage']);
        Route::delete('/admin/gallery/images/{image}', [GalleryController::class, 'destroyImage']);
        Route::get('/admin/gallery/categories', [GalleryController::class, 'adminCategories']);
        Route::get('/admin/gallery/categories/{category}/images', [GalleryController::class, 'adminImages']);

        // Actualities Management
        Route::get('/admin/actualities', [ActualityController::class, 'adminIndex']);
        Route::post('/admin/actualities', [ActualityController::class, 'store']);
        Route::post('/admin/actualities/{actuality}', [ActualityController::class, 'update']);
        Route::delete('/admin/actualities/{actuality}', [ActualityController::class, 'destroy']);

        // Testimonials Management
        Route::post('/admin/testimonials', [TestimonialController::class, 'store']);
        Route::put('/admin/testimonials/{testimonial}', [TestimonialController::class, 'update']);
        Route::delete('/admin/testimonials/{testimonial}', [TestimonialController::class, 'destroy']);

        // Contact Messages Management
        Route::get('/admin/contact/messages', [ContactController::class, 'messages']);
        Route::put('/admin/contact/messages/{contactMessage}', [ContactController::class, 'updateMessage']);
        Route::delete('/admin/contact/messages/{contactMessage}', [ContactController::class, 'destroyMessage']);

        // Settings Management
        Route::get('/admin/settings', [SettingController::class, 'all']);
        Route::put('/admin/settings/{key}', [SettingController::class, 'update']);

        // Dashboard
        Route::get('/admin/dashboard', [DashboardController::class, 'overview']);
    });
});

