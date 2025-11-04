<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RiwayatSkrining;

class CheckFirstLogin
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // Pastikan pengguna login
        if (!$user) {
            return redirect()->route('login');
        }

        $user->markProfileCompletedIfEligible();

        $isLivewireRequest = $request->routeIs('livewire.update');

        $profileRoutes = [
            'profile.edit',
            'profile.update',
            'profile.destroy',
        ];

        if (! $user->profile_completed && ! ($request->routeIs($profileRoutes) || $isLivewireRequest)) {
            return redirect()->route('profile.edit');
        }

        $pretestCompleted = $user->has_completed_pretest;

        if (! $pretestCompleted) {
            $pretestCompleted = RiwayatSkrining::where('user_id', $user->id)
                ->where('jenis_sesi', 'Pretest')
                ->where('status', 'Completed')
                ->exists();

            if ($pretestCompleted) {
                $user->forceFill(['has_completed_pretest' => true])->save();
            }
        }

        if (! $pretestCompleted && ! ($request->routeIs(['pretest.*']) || $isLivewireRequest)) {
            return redirect()->route('pretest.disclaimer');
        }

        if ($pretestCompleted && $request->routeIs(['pretest.test'])) {
            return redirect()->route('home');
        }

        if ($pretestCompleted && ! $user->has_read_leaflet && ! ($request->routeIs('show.video') || $isLivewireRequest)) {
            return redirect()->route('show.video', ['kembali' => false]);
        }

        if ($user->has_read_leaflet && ! $user->has_downloaded_leaflet && ! ($request->routeIs(['show.video', 'leaflet.download']) || $isLivewireRequest)) {
            return redirect()->route('show.video', ['kembali' => false]);
        }

        if ($user->has_downloaded_leaflet && ! $user->has_submitted_measurement && ! ($request->routeIs(['measurement.form']) || $isLivewireRequest)) {
            return redirect()->route('measurement.form');
        }

        if ($user->has_submitted_measurement && ! $user->has_submitted_risk) {
            $hasRiskAssessment = $user->latestRiskAssessment()->exists();

            if ($hasRiskAssessment) {
                $user->forceFill(['has_submitted_risk' => true])->save();
            } elseif (! ($request->routeIs(['risk.form']) || $isLivewireRequest)) {
                return redirect()->route('risk.form');
            }
        }

        $posttestCompleted = $user->has_completed_posttest;

        if (! $posttestCompleted) {
            $posttestCompleted = RiwayatSkrining::where('user_id', $user->id)
                ->where('jenis_sesi', 'Post Test')
                ->where('status', 'Completed')
                ->exists();

            if ($posttestCompleted) {
                $user->forceFill(['has_completed_posttest' => true])->save();
            }
        }

        if (! $posttestCompleted && ! ($request->routeIs(['posttest.*']) || $isLivewireRequest)) {
            return redirect()->route('posttest.disclaimer');
        }

        return $next($request);
    }
}
