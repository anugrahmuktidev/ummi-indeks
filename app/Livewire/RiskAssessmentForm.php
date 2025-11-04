<?php

namespace App\Livewire;

use App\Models\UserRiskAssessment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Component;

class RiskAssessmentForm extends Component
{
    private const INTERCEPT = -1.177142;

    private const COEF = [
        'umur' => [0 => 0.0, 1 => -0.823209, 2 => 0.475034],
        'paritas' => [0 => 0.0, 1 => 0.287520, 2 => 0.379854],
        'kontrasepsi' => [0 => 0.0, 1 => -0.822340, 2 => -0.847305],
        'penyakitInfeksi' => [0 => 0.0, 1 => 0.023537, 2 => 1.024556],
        'aktivitasFisik' => [0 => 0.0, 1 => 0.349680, 2 => -0.115967],
        'statusPekerjaan' => [0 => 0.0, 1 => -0.380670],
        'statusKawin' => [0 => 0.0, 1 => 0.702878],
        'sosialEkonomi' => [0 => 0.0, 1 => 0.209056],
    ];

    private const SKOR = [
        'umur' => [0 => 0, 1 => -40, 2 => 20],
        'paritas' => [0 => 0, 1 => 10, 2 => 13],
        'kontrasepsi' => [0 => 0, 1 => -33, 2 => -34],
        'penyakitInfeksi' => [0 => 0, 1 => 1, 2 => 28],
        'aktivitasFisik' => [0 => 0, 1 => 19, 2 => -4],
        'statusPekerjaan' => [0 => 0, 1 => -20],
        'statusKawin' => [0 => 0, 1 => 28],
        'sosialEkonomi' => [0 => 0, 1 => 10],
    ];

    #[Validate('nullable|numeric|min:0|max:100')]
    public $probabilitas;

    #[Validate('nullable|string|max:255')]
    public $kategori;

    #[Validate('nullable|string|max:500')]
    public $catatan;

    #[Validate('required|integer|in:0,1,2')]
    public $umur;

    #[Validate('required|integer|in:0,1,2')]
    public $paritas;

    #[Validate('required|integer|in:0,1,2')]
    public $kontrasepsi;

    #[Validate('required|integer|in:0,1,2')]
    public $penyakit_infeksi;

    #[Validate('required|integer|in:0,1,2')]
    public $aktifitas_fisik;

    #[Validate('required|integer|in:0,1')]
    public $status_pekerjaan;

    #[Validate('required|integer|in:0,1')]
    public $status_kawin;

    #[Validate('required|integer|in:0,1')]
    public $status_ekonomi;

    public array $debugLog = [];
    public ?int $totalSkor = null;
    public ?string $kategoriOtomatis = null;

    public function mount(): void
    {
        $user = Auth::user();

        if ($latest = $user->latestRiskAssessment()->first()) {
            $this->probabilitas = $latest->probabilitas;
            $this->kategori = $latest->kategori;
            $this->catatan = $latest->catatan;
            $this->totalSkor = $latest->total_skor;
            $this->umur = $latest->umur;
            $this->paritas = $latest->paritas;
            $this->kontrasepsi = $latest->kontrasepsi;
            $this->penyakit_infeksi = $latest->penyakit_infeksi;
            $this->aktifitas_fisik = $latest->aktifitas_fisik;
            $this->status_pekerjaan = $latest->status_pekerjaan;
            $this->status_kawin = $latest->status_kawin;
            $this->status_ekonomi = $latest->status_ekonomi;
        }

        $this->updateDebugLog();
    }

    public function updated($field): void
    {
        if (Str::startsWith($field, [
            'umur',
            'paritas',
            'kontrasepsi',
            'penyakit_infeksi',
            'aktifitas_fisik',
            'status_pekerjaan',
            'status_kawin',
            'status_ekonomi',
        ])) {
            $this->updateDebugLog();
        }
    }

    public function save(): void
    {
        $this->validate();

        $this->updateDebugLog(force: true);

        $log = $this->debugLog;
        $probabilitas = $this->probabilitas ?? 0.0;
        $totalSkor = $log['totalSkor'] ?? 0;

        $kategori = $this->determineKategori($totalSkor);

        $user = Auth::user();

        $assessment = UserRiskAssessment::create([
            'user_id' => $user->id,
            'probabilitas' => $probabilitas,
            'kategori' => $kategori,
            'catatan' => $this->catatan,
            'total_skor' => $totalSkor,
            'umur' => $this->normalize($this->umur),
            'paritas' => $this->normalize($this->paritas),
            'kontrasepsi' => $this->normalize($this->kontrasepsi),
            'penyakit_infeksi' => $this->normalize($this->penyakit_infeksi),
            'aktifitas_fisik' => $this->normalize($this->aktifitas_fisik),
            'status_pekerjaan' => $this->normalize($this->status_pekerjaan),
            'status_kawin' => $this->normalize($this->status_kawin),
            'status_ekonomi' => $this->normalize($this->status_ekonomi),
        ]);

        session()->put('risk_assessment_id', $assessment->id);

        $this->kategori = $kategori;
        $user->forceFill(['has_submitted_risk' => true])->save();

        session()->flash('status', 'Penilaian risiko KEK berhasil disimpan.');

        $this->redirectRoute('risk.result', navigate: true);
    }

    public function render()
    {
        return view('livewire.risk-assessment-form')
            ->layout('layouts.basic');
    }

    protected function collectInputs(): array
    {
        return [
            'umur' => $this->normalize($this->umur),
            'paritas' => $this->normalize($this->paritas),
            'kontrasepsi' => $this->normalize($this->kontrasepsi),
            'penyakitInfeksi' => $this->normalize($this->penyakit_infeksi),
            'aktivitasFisik' => $this->normalize($this->aktifitas_fisik),
            'statusPekerjaan' => $this->normalize($this->status_pekerjaan),
            'statusKawin' => $this->normalize($this->status_kawin),
            'sosialEkonomi' => $this->normalize($this->status_ekonomi),
        ];
    }

    protected function generateLog(array $inputs): array
    {
        $perFaktor = [];
        $totalSkor = 0;
        $linear = self::INTERCEPT;

        foreach (self::COEF as $faktor => $map) {
            $value = $inputs[$faktor] ?? 0;
            $coef = $map[$value] ?? 0.0;
            $skor = self::SKOR[$faktor][$value] ?? 0;
            $prob = $value === 0 ? 0.0 : $this->sigmoid(self::INTERCEPT + $coef);

            $perFaktor[$faktor] = [
                'value' => $value,
                'coef' => $coef,
                'skor' => $skor,
                'probability' => round($prob, 6),
            ];

            $totalSkor += $skor;
            $linear += $coef;
        }

        $overallProbability = $this->sigmoid($linear);

        return [
            'perFaktor' => $perFaktor,
            'totalSkor' => $totalSkor,
            'linearSum' => round($linear, 6),
            'overallProbability' => round($overallProbability, 6),
            'overallProbabilityPercent' => round($overallProbability * 100, 2),
        ];
    }

    protected function sigmoid(float $x): float
    {
        return 1 / (1 + exp(-$x));
    }

    protected function updateDebugLog(bool $force = false): void
    {
        $inputs = $this->collectInputs();

        $allSelected = collect($inputs)->every(function ($value) {
            return $value !== null;
        });

        if (! $allSelected && ! $force) {
            $this->debugLog = [];
            $this->totalSkor = null;
            $this->probabilitas = null;
            $this->kategoriOtomatis = null;
            return;
        }

        $log = $this->generateLog($inputs);

        $this->debugLog = $log;
        $this->totalSkor = $log['totalSkor'];
        $this->probabilitas = $log['overallProbabilityPercent'];
        $this->kategoriOtomatis = $this->determineKategori($this->totalSkor);
    }

    protected function normalize($value): ?int
    {
        if ($value === '' || $value === null) {
            return null;
        }

        return (int) $value;
    }

    protected function determineKategori(?int $totalSkor): string
    {
        if ($totalSkor === null) {
            return 'Risiko Rendah KEK';
        }

        return $totalSkor >= 4
            ? 'Risiko Tinggi KEK'
            : 'Risiko Rendah KEK';
    }
}
