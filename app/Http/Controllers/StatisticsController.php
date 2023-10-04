<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    public function index()
    {
        // Fetch top 10 users with the highest task counts
        $topUsers = User::withCount('tasks')->orderByDesc('tasks_count')->take(10)->get();

        return view('statistics.index', compact('topUsers'));
    }
}
