<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PlataformUsageRegister;
use App\Models\Session;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(): Response
    {
        $sessions = $this->plataformUsageRegisters();
        $sessionsActive = $this->useersSessionActiveCount();
        return Inertia::render('Dashboard/Dashboard',[
            'sessions' => $sessions,
            'sessionsActive' => $sessionsActive,
        ]);
    }

    public function plataformUsageRegisters(): Collection
    {
        $start = Carbon::now()->subDays(7)->format('Y-m-d');
        $end = Carbon::now()->format('Y-m-d');
        $sessions = PlataformUsageRegister::whereBetween('date', [$start, $end])->get();
        $sessions = $sessions->map(function ($session) {
            return [
                'date' => $session->date->format('d/m'),
                'users_count' => $session->users_count,
            ];
        });

        return $sessions;
    }

    public function useersSessionActiveCount(): Collection
    {
        $lastSessionActive = Session::where('last_activity', '>=', Carbon::now()->subMinutes(10)->timestamp)->distinct('user_id')->count();
        $allSessionsActive = Session::where('user_id', '!=', null)->distinct('user_id')->count();
        $sessionsActive = collect([
            'lastSessionActive' => $lastSessionActive,
            'allSessionsActive' => $allSessionsActive,
        ]);
        return $sessionsActive;
    }
}
