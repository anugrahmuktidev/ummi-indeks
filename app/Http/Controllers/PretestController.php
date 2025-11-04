<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class PretestController extends Controller
{
    public function showVideo($kembali = null)
    {
        return $this->renderLeafletPage('kek', $kembali);
    }

    public function showLeaflet(string $leaflet, $kembali = null)
    {
        return $this->renderLeafletPage($leaflet, $kembali);
    }

    protected function renderLeafletPage(string $slug, $kembali = null)
    {
        $leaflets = $this->leaflets();

        if (! array_key_exists($slug, $leaflets)) {
            abort(404, 'Leaflet tidak ditemukan.');
        }

        $user = Auth::user();

        if (! $user->has_read_leaflet) {
            $user->forceFill(['has_read_leaflet' => true])->save();
        }

        $sessionKey = $this->downloadSessionKey($user->id);
        $downloadedLeaflets = collect(session($sessionKey, []))->unique()->values()->all();
        $totalLeaflets = count($leaflets);

        if ($user->has_downloaded_leaflet && count($downloadedLeaflets) < $totalLeaflets) {
            $downloadedLeaflets = array_keys($leaflets);
            session([$sessionKey => $downloadedLeaflets]);
        }

        $allLeafletsDownloaded = $user->has_downloaded_leaflet || count($downloadedLeaflets) >= $totalLeaflets;

        $bisakembali = (bool) ($kembali ?? false);

        return view('user.pretest.video.play-video', [
            'kembali' => $bisakembali,
            'hasDownloaded' => $allLeafletsDownloaded,
            'leaflets' => $leaflets,
            'activeLeaflet' => $slug,
            'leaflet' => $leaflets[$slug],
            'downloadedLeaflets' => $downloadedLeaflets,
            'totalLeaflets' => $totalLeaflets,
            'allLeafletsDownloaded' => $allLeafletsDownloaded,
        ]);
    }

    public function downloadLeaflet(string $leaflet)
    {
        $leaflets = $this->leaflets();

        if (! array_key_exists($leaflet, $leaflets)) {
            abort(404, 'Leaflet tidak ditemukan.');
        }

        $fileName = $leaflets[$leaflet]['file'];
        $filePath = public_path($fileName);

        if (! file_exists($filePath)) {
            abort(404, 'Leaflet tidak ditemukan.');
        }

        $user = Auth::user();
        $sessionKey = $this->downloadSessionKey($user->id);
        $downloaded = collect(session($sessionKey, []))
            ->push($leaflet)
            ->unique()
            ->values()
            ->all();

        session([$sessionKey => $downloaded]);

        if (count($downloaded) >= count($leaflets) && ! $user->has_downloaded_leaflet) {
            $user->forceFill(['has_downloaded_leaflet' => true])->save();
        }

        return response()->download($filePath, $fileName);
    }

    protected function leaflets(): array
    {
        return [
            'kek' => [
                'slug' => 'kek',
                'title' => 'Leaflet KEK',
                'file' => 'Leaflet KEK.pdf',
                'description' => 'Ringkasan indikator KEK dan panduan gizi harian.',
            ],
            'rasio' => [
                'slug' => 'rasio',
                'title' => 'Leaflet Rasio KEK',
                'file' => 'Leaflet Rasio KEK.pdf',
                'description' => 'Cara membaca rasio indikator Risiko KEK dan tindak lanjut.',
            ],
        ];
    }

    protected function downloadSessionKey(int $userId): string
    {
        return 'downloaded_leaflets:' . $userId;
    }
}
