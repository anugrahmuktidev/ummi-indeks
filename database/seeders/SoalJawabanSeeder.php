<?php

namespace Database\Seeders;

use App\Models\Soal;
use Illuminate\Database\Seeder;

class SoalJawabanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bank = [
            'Pre Test' => [
                [
                    'soal' => 'Apa kepanjangan dari KEK?',
                    'answers' => [
                        ['jawaban' => 'Kurang Energi Kronis', 'benar' => true],
                        ['jawaban' => 'Kelebihan Energi Kronis', 'benar' => false],
                        ['jawaban' => 'Krisis Energi Kelistrikan', 'benar' => false],
                        ['jawaban' => 'Kadar Energi Kabur', 'benar' => false],
                    ],
                ],
                [
                    'soal' => 'KEK terjadi ketika…',
                    'answers' => [
                        ['jawaban' => 'Asupan energi dan protein jangka panjang tidak mencukupi kebutuhan tubuh', 'benar' => true],
                        ['jawaban' => 'Konsumsi air putih berlebihan', 'benar' => false],
                        ['jawaban' => 'Tubuh terlalu banyak bergerak dalam sehari', 'benar' => false],
                        ['jawaban' => 'Seseorang makan tiga kali sehari', 'benar' => false],
                    ],
                ],
                [
                    'soal' => 'Kelompok berikut paling rentan mengalami KEK yaitu…',
                    'answers' => [
                        ['jawaban' => 'Remaja putri dan ibu hamil', 'benar' => true],
                        ['jawaban' => 'Anak laki-laki usia sekolah dasar', 'benar' => false],
                        ['jawaban' => 'Lansia pria', 'benar' => false],
                        ['jawaban' => 'Pekerja kantoran laki-laki', 'benar' => false],
                    ],
                ],
                [
                    'soal' => 'Indikator sederhana untuk mendeteksi risiko KEK di lapangan adalah…',
                    'answers' => [
                        ['jawaban' => 'Lingkar Lengan Atas (LILA)', 'benar' => true],
                        ['jawaban' => 'Lingkar Pinggang', 'benar' => false],
                        ['jawaban' => 'Tekanan darah', 'benar' => false],
                        ['jawaban' => 'Ukuran sepatu', 'benar' => false],
                    ],
                ],
                [
                    'soal' => 'Nilai batas LILA yang menunjukkan risiko KEK pada wanita dewasa adalah…',
                    'answers' => [
                        ['jawaban' => 'Kurang dari 23,5 cm', 'benar' => true],
                        ['jawaban' => 'Antara 24–26 cm', 'benar' => false],
                        ['jawaban' => 'Lebih dari 28 cm', 'benar' => false],
                        ['jawaban' => '40 cm', 'benar' => false],
                    ],
                ],
                [
                    'soal' => 'Gejala yang sering dirasakan seseorang dengan KEK adalah…',
                    'answers' => [
                        ['jawaban' => 'Mudah lelah dan lesu berkepanjangan', 'benar' => true],
                        ['jawaban' => 'Demam tinggi secara berkala', 'benar' => false],
                        ['jawaban' => 'Hidung tersumbat', 'benar' => false],
                        ['jawaban' => 'Mata berair', 'benar' => false],
                    ],
                ],
                [
                    'soal' => 'Dampak KEK pada kehamilan dapat berupa…',
                    'answers' => [
                        ['jawaban' => 'Risiko bayi lahir dengan berat badan rendah', 'benar' => true],
                        ['jawaban' => 'Pertumbuhan janin lebih cepat dari normal', 'benar' => false],
                        ['jawaban' => 'Kehamilan lebih singkat', 'benar' => false],
                        ['jawaban' => 'Tidak memengaruhi janin', 'benar' => false],
                    ],
                ],
                [
                    'soal' => 'Upaya pencegahan KEK yang benar adalah…',
                    'answers' => [
                        ['jawaban' => 'Mengonsumsi makanan bergizi seimbang secara teratur', 'benar' => true],
                        ['jawaban' => 'Mengurangi minum air', 'benar' => false],
                        ['jawaban' => 'Tidak sarapan setiap hari', 'benar' => false],
                        ['jawaban' => 'Menghindari buah dan sayur', 'benar' => false],
                    ],
                ],
                [
                    'soal' => 'Berapa pola makan harian yang dianjurkan untuk mencegah KEK?',
                    'answers' => [
                        ['jawaban' => 'Tiga makan utama dan dua kali selingan', 'benar' => true],
                        ['jawaban' => 'Satu kali makan besar saja', 'benar' => false],
                        ['jawaban' => 'Makan hanya ketika lapar saja', 'benar' => false],
                        ['jawaban' => 'Empat kali minum kopi', 'benar' => false],
                    ],
                ],
                [
                    'soal' => 'Siapa yang dapat membantu memantau status gizi di masyarakat?',
                    'answers' => [
                        ['jawaban' => 'Petugas gizi puskesmas/posyandu', 'benar' => true],
                        ['jawaban' => 'Satpam pasar', 'benar' => false],
                        ['jawaban' => 'Kasir minimarket', 'benar' => false],
                        ['jawaban' => 'Petugas parkir', 'benar' => false],
                    ],
                ],
            ],
            'Post Test' => [
                [
                    'soal' => 'Jika hasil pengukuran LILA Anda 22,5 cm, langkah yang paling tepat adalah…',
                    'answers' => [
                        ['jawaban' => 'Segera berkonsultasi dengan tenaga kesehatan untuk penilaian lanjut', 'benar' => true],
                        ['jawaban' => 'Mengabaikannya karena masih normal', 'benar' => false],
                        ['jawaban' => 'Mengurangi frekuensi makan', 'benar' => false],
                        ['jawaban' => 'Berhenti beraktivitas fisik', 'benar' => false],
                    ],
                ],
                [
                    'soal' => 'Contoh makanan selingan padat energi yang dianjurkan bagi individu berisiko KEK adalah…',
                    'answers' => [
                        ['jawaban' => 'Roti gandum dengan selai kacang', 'benar' => true],
                        ['jawaban' => 'Air putih saja', 'benar' => false],
                        ['jawaban' => 'Permen keras', 'benar' => false],
                        ['jawaban' => 'Kerupuk tanpa lauk', 'benar' => false],
                    ],
                ],
                [
                    'soal' => 'Menu seimbang untuk mencegah KEK sebaiknya terdiri dari…',
                    'answers' => [
                        ['jawaban' => 'Sumber karbohidrat, protein hewani/nabati, sayur, dan buah', 'benar' => true],
                        ['jawaban' => 'Karbohidrat saja', 'benar' => false],
                        ['jawaban' => 'Minuman manis kemasan', 'benar' => false],
                        ['jawaban' => 'Camilan tinggi garam saja', 'benar' => false],
                    ],
                ],
                [
                    'soal' => 'Remaja putri dianjurkan mengonsumsi tablet tambah darah minimal…',
                    'answers' => [
                        ['jawaban' => '1 tablet per minggu secara teratur', 'benar' => true],
                        ['jawaban' => '1 tablet per tahun', 'benar' => false],
                        ['jawaban' => '5 tablet sekaligus saat merasa lemas', 'benar' => false],
                        ['jawaban' => 'Tidak perlu tablet tambah darah', 'benar' => false],
                    ],
                ],
                [
                    'soal' => 'Kapan sebaiknya melakukan pemantauan berat badan dan LILA bagi individu berisiko KEK?',
                    'answers' => [
                        ['jawaban' => 'Secara berkala minimal sekali setiap bulan', 'benar' => true],
                        ['jawaban' => 'Hanya saat sakit', 'benar' => false],
                        ['jawaban' => 'Saat ada kegiatan formal saja', 'benar' => false],
                        ['jawaban' => 'Tidak perlu dipantau', 'benar' => false],
                    ],
                ],
                [
                    'soal' => 'Jika sulit menghabiskan porsi makan besar karena mual, strategi yang dianjurkan adalah…',
                    'answers' => [
                        ['jawaban' => 'Makan porsi kecil tetapi lebih sering', 'benar' => true],
                        ['jawaban' => 'Berpuasa sepanjang hari', 'benar' => false],
                        ['jawaban' => 'Menghilangkan lauk dari menu', 'benar' => false],
                        ['jawaban' => 'Hanya minum air es', 'benar' => false],
                    ],
                ],
                [
                    'soal' => 'Apa manfaat mencatat menu harian dan berat badan saat menjalani perbaikan gizi?',
                    'answers' => [
                        ['jawaban' => 'Membantu mengevaluasi kecukupan energi dan respon tubuh', 'benar' => true],
                        ['jawaban' => 'Hanya menambah pekerjaan', 'benar' => false],
                        ['jawaban' => 'Mencegah tidur nyenyak', 'benar' => false],
                        ['jawaban' => 'Tidak memiliki manfaat', 'benar' => false],
                    ],
                ],
                [
                    'soal' => 'Selain makanan, faktor penting lain dalam pencegahan KEK adalah…',
                    'answers' => [
                        ['jawaban' => 'Istirahat cukup dan aktivitas fisik teratur', 'benar' => true],
                        ['jawaban' => 'Begadang setiap malam', 'benar' => false],
                        ['jawaban' => 'Mengurangi minum air putih', 'benar' => false],
                        ['jawaban' => 'Menghindari konsultasi gizi', 'benar' => false],
                    ],
                ],
                [
                    'soal' => 'Siapa yang sebaiknya dilibatkan untuk membantu keberhasilan perbaikan gizi?',
                    'answers' => [
                        ['jawaban' => 'Keluarga atau pendamping yang mendukung pola makan sehat', 'benar' => true],
                        ['jawaban' => 'Tetangga yang jarang ditemui', 'benar' => false],
                        ['jawaban' => 'Teman yang suka melewatkan makan', 'benar' => false],
                        ['jawaban' => 'Tidak perlu dukungan siapa pun', 'benar' => false],
                    ],
                ],
                [
                    'soal' => 'Apa manfaat konseling gizi bagi individu berisiko KEK?',
                    'answers' => [
                        ['jawaban' => 'Membantu menyusun menu sesuai kebutuhan energi', 'benar' => true],
                        ['jawaban' => 'Mengganti makanan dengan obat-obatan', 'benar' => false],
                        ['jawaban' => 'Mengurangi jam makan', 'benar' => false],
                        ['jawaban' => 'Tidak ada manfaatnya', 'benar' => false],
                    ],
                ],
            ],
            'Skrining' => [
                [
                    'soal' => 'Apakah Lingkar Lengan Atas (LILA) Anda kurang dari 23,5 cm?',
                    'answers' => [
                        ['jawaban' => 'Ya', 'benar' => true],
                        ['jawaban' => 'Tidak', 'benar' => false],
                    ],
                ],
                [
                    'soal' => 'Apakah berat badan Anda menurun dalam 3 bulan terakhir tanpa sebab jelas?',
                    'answers' => [
                        ['jawaban' => 'Ya', 'benar' => true],
                        ['jawaban' => 'Tidak', 'benar' => false],
                    ],
                ],
                [
                    'soal' => 'Apakah Anda sering merasa lelah meskipun aktivitas tidak berat?',
                    'answers' => [
                        ['jawaban' => 'Ya', 'benar' => true],
                        ['jawaban' => 'Tidak', 'benar' => false],
                    ],
                ],
                [
                    'soal' => 'Apakah Anda sering melewatkan makan utama karena tidak ada selera atau waktu?',
                    'answers' => [
                        ['jawaban' => 'Ya', 'benar' => true],
                        ['jawaban' => 'Tidak', 'benar' => false],
                    ],
                ],
                [
                    'soal' => 'Apakah pakaian Anda terasa semakin longgar dalam beberapa bulan terakhir?',
                    'answers' => [
                        ['jawaban' => 'Ya', 'benar' => true],
                        ['jawaban' => 'Tidak', 'benar' => false],
                    ],
                ],
                [
                    'soal' => 'Apakah Anda jarang mengonsumsi lauk sumber protein (ikan, telur, kacang) setiap hari?',
                    'answers' => [
                        ['jawaban' => 'Ya', 'benar' => true],
                        ['jawaban' => 'Tidak', 'benar' => false],
                    ],
                ],
                [
                    'soal' => 'Apakah Anda memiliki penyakit yang membuat sulit makan atau menyerap nutrisi (misalnya maag berat)?',
                    'answers' => [
                        ['jawaban' => 'Ya', 'benar' => true],
                        ['jawaban' => 'Tidak', 'benar' => false],
                    ],
                ],
                [
                    'soal' => 'Apakah lingkungan tempat tinggal Anda memiliki akses pangan bergizi yang terbatas?',
                    'answers' => [
                        ['jawaban' => 'Ya', 'benar' => true],
                        ['jawaban' => 'Tidak', 'benar' => false],
                    ],
                ],
                [
                    'soal' => 'Apakah Anda sedang hamil atau menyusui tanpa tambahan asupan energi harian?',
                    'answers' => [
                        ['jawaban' => 'Ya', 'benar' => true],
                        ['jawaban' => 'Tidak', 'benar' => false],
                    ],
                ],
            ],
        ];

        foreach ($bank as $jenis => $questions) {
            $nomor = 1;
            foreach ($questions as $question) {
                $soal = Soal::updateOrCreate(
                    [
                        'jenis_soal' => $jenis,
                        'nomor_soal' => $nomor,
                    ],
                    [
                        'soal' => $question['soal'],
                    ]
                );

                $soal->jawaban()->delete();

                foreach ($question['answers'] as $answer) {
                    $soal->jawaban()->create([
                        'jawaban' => $answer['jawaban'],
                        'kunci_jawaban' => $answer['benar'],
                        'poin_soal' => $answer['benar'] ? 1 : 0,
                    ]);
                }

                $nomor++;
            }
        }
    }
}
