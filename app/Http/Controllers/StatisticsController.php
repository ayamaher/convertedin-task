<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class StatisticsController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function index(): View|Factory|Application
    {
       $topUsers = User::withCount('tasks')->orderBy('tasks_count', 'DESC')->take(10)->get();
        return view('statistics.index', ['topUsers' => $topUsers]);
    }
}
