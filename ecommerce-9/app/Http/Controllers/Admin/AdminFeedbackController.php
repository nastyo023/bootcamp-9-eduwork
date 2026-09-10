<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;

class AdminFeedbackController extends Controller
{
    public function index()
    {
        // 1. Data Feedback dengan Pagination
        $feedbacks = Feedback::with(['user', 'order', 'orderItem'])->latest()->paginate(10);

        // 2. Ringkasan Statistik Keseluruhan
        $totalFeedback = Feedback::count();
        $avgRating = Feedback::avg('rating') ?? 0;
        $satisfiedCount = Feedback::where('rating', '>=', 4)->count();
        $needsAttentionCount = Feedback::where('rating', '<=', 3)->count();

        return view('admin.feedback.index', compact(
            'feedbacks',
            'totalFeedback',
            'avgRating',
            'satisfiedCount',
            'needsAttentionCount'
        ));
    }
}