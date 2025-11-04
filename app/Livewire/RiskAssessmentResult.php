<?php

namespace App\Livewire;

use App\Models\UserRiskAssessment;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class RiskAssessmentResult extends Component
{
    private const FAKTOR_LABELS = [
        'umur' => 'Umur',
        'paritas' => 'Paritas',
        'kontrasepsi' => 'Penggunaan Alat Kontrasepsi',
        'penyakitInfeksi' => 'Penyakit Infeksi',
        'aktivitasFisik' => 'Aktivitas Fisik',
        'statusPekerjaan' => 'Status Pekerjaan',
        'statusKawin' => 'Status Kawin',
        'sosialEkonomi' => 'Status Ekonomi',
    ];

    private const FAKTOR_OPTIONS = [
        'umur' => [
            2 => '18 – 20 tahun',
            0 => '20 – 35 tahun',
            1 => '36 – 49 tahun',
        ],
        'paritas' => [
            2 => '≥ 4 kali',
            1 => '1 – 3 anak',
            0 => 'Belum pernah',
        ],
        'kontrasepsi' => [
            2 => 'Menggunakan hormonal',
            1 => 'Pernah/non-hormonal',
            0 => 'Tidak pernah menggunakan',
        ],
        'penyakitInfeksi' => [
            2 => 'Berat',
            1 => 'Ringan',
            0 => 'Tidak ada',
        ],
        'aktivitasFisik' => [
            2 => 'Berat',
            1 => 'Sedang',
            0 => 'Ringan',
        ],
        'statusPekerjaan' => [
            1 => 'Bekerja',
            0 => 'Tidak bekerja',
        ],
        'statusKawin' => [
            1 => 'Belum / tidak menikah',
            0 => 'Menikah',
        ],
        'sosialEkonomi' => [
            1 => 'Rendah',
            0 => 'Tinggi',
        ],
    ];

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

    public UserRiskAssessment $assessment;
    public array $log = [];
    public ?int $totalSkor = null;
    public ?float $probabilitas = null;
    public ?string $kategori = null;
    public array $factors = [];
    public bool $canProceedToPosttest = false;

    public function mount(): void
    {
        $user = Auth::user();
        $assessmentId = session('risk_assessment_id');

        if ($assessmentId) {
            $assessment = UserRiskAssessment::where('user_id', $user->id)->find($assessmentId);
            session()->forget('risk_assessment_id');
        } else {
            $assessment = $user->latestRiskAssessment()->first();
        }

        abort_if(! $assessment, 404);

        $this->assessment = $assessment;

        $log = $this->generateLog($this->collectInputs());
        $this->log = $log;
        $this->totalSkor = $log['totalSkor'];
        $this->probabilitas = $assessment->probabilitas ?? $log['overallProbabilityPercent'];
        $this->kategori = $this->determineKategori($this->totalSkor);
        $this->factors = $this->formatFactors($log['perFaktor']);

        $this->canProceedToPosttest = ! $user->has_completed_posttest;
    }

    public function proceed(): void
    {
        if ($this->canProceedToPosttest) {
            $this->redirectRoute('posttest.disclaimer', navigate: true);
        }
    }

    public function redo(): void
    {
        $this->redirectRoute('risk.form', navigate: true);
    }

    public function render()
    {
        return view('livewire.risk-assessment-result')
            ->layout('layouts.basic');
    }

    protected function collectInputs(): array
    {
        return [
            'umur' => $this->normalize($this->assessment->umur),
            'paritas' => $this->normalize($this->assessment->paritas),
            'kontrasepsi' => $this->normalize($this->assessment->kontrasepsi),
            'penyakitInfeksi' => $this->normalize($this->assessment->penyakit_infeksi),
            'aktivitasFisik' => $this->normalize($this->assessment->aktifitas_fisik),
            'statusPekerjaan' => $this->normalize($this->assessment->status_pekerjaan),
            'statusKawin' => $this->normalize($this->assessment->status_kawin),
            'sosialEkonomi' => $this->normalize($this->assessment->status_ekonomi),
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

    protected function normalize($value): int
    {
        return (int) ($value ?? 0);
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

    protected function formatFactors(array $perFaktor): array
    {
        return collect($perFaktor)
            ->map(function ($detail, $key) {
                $value = $detail['value'] ?? null;

                return [
                    'key' => $key,
                    'label' => self::FAKTOR_LABELS[$key] ?? ucfirst($key),
                    'selection' => self::FAKTOR_OPTIONS[$key][$value] ?? 'Tidak diisi',
                    'score' => $detail['skor'] ?? 0,
                    'coef' => $detail['coef'] ?? 0.0,
                    'probability' => $detail['probability'] ?? 0.0,
                ];
            })
            ->values()
            ->all();
    }
}
