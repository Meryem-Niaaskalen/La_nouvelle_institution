<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\GalleryImage;
use App\Models\Program;
use App\Models\Teacher;
use App\Models\Activity;
use App\Models\Testimonial;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    public function overview(): JsonResponse
    {
        $today = Carbon::today();
        $lastWeek = $today->copy()->subDays(6);

        $messageCounts = ContactMessage::selectRaw('DATE(created_at) as date, count(*) as total')
            ->where('created_at', '>=', $lastWeek)
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('total', 'date')
            ->toArray();

        $messagesByDay = [];
        for ($i = 0; $i < 7; $i++) {
            $date = $lastWeek->copy()->addDays($i);
            $messagesByDay[] = [
                'label' => $date->format('D'),
                'date' => $date->toDateString(),
                'value' => (int) ($messageCounts[$date->toDateString()] ?? 0),
            ];
        }

        return response()->json([
            'data' => [
                'messages_total' => ContactMessage::count(),
                'messages_unread' => ContactMessage::where('status', 'new')->count(),
                'messages_last_7_days' => ContactMessage::where('created_at', '>=', $lastWeek)->count(),
                'programs_total' => Program::published()->count(),
                'teachers_active' => Teacher::active()->count(),
                'gallery_images_total' => GalleryImage::where('is_visible', true)->count(),
                'activities_upcoming_total' => Activity::whereDate('event_date', '>=', $today)->count(),
                'testimonials_published_total' => Testimonial::where('is_published', true)->count(),
                'messages_by_day' => $messagesByDay,
            ],
        ]);
    }
}
