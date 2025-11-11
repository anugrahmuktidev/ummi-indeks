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
                    'soal' => 'Kekurangan Energi Kronis (KEK) adalah keadaan dimana remaja putri/wanita mengalami kekurangan gizi (kalori dan protein) yang berlangsung lama (kronis).',
                    'answers' => [
                        ['jawaban' => 'Ya', 'benar' => true],
                        ['jawaban' => 'Tidak', 'benar' => false],
                    ],
                ],
                [
                    'soal' => 'KEK pada WUS/bumil dapat diketahui dengan  mengukur  Lingkar Lengan  Atas (LiLA)',
                    'answers' => [
                        ['jawaban' => 'Ya', 'benar' => true],
                        ['jawaban' => 'Tidak', 'benar' => false],
                    ],
                ],
                [
                    'soal' => 'Faktor penyebab KEK adalah pola konsumsi yang tidak seimbang dan kondisi sosial ekonomi.',
                    'answers' => [
                        ['jawaban' => 'Ya', 'benar' => true],
                        ['jawaban' => 'Tidak', 'benar' => false],
                    ],
                ],
                [
                    'soal' => 'Gejala KEK antara lain Lingkar Lengan Atas <23,5 cm, kurang cekatan saat bekerja, merasa cepat lelah, lemah, lesu, dan letih.',
                    'answers' => [
                        ['jawaban' => 'Ya', 'benar' => true],
                        ['jawaban' => 'Tidak', 'benar' => false],
                    ],
                ],
                [
                    'soal' => 'Dampak KEK yaitu kematian ibu saat melahirkan, perdarahan saat melahirkan, melahirkan BBLR, anemia pada bayi, bayi mudah terinfeksi, terhambatnya pertumbuhan otak janin, keguguran, cacat bawaan, bayi lahir mati.',
                    'answers' => [
                        ['jawaban' => 'Ya', 'benar' => true],
                        ['jawaban' => 'Tidak', 'benar' => false],
                    ],
                ],
                [
                    'soal' => 'Pencegahan KEK adalah dengan mengonsumsi makanan bergizi seimbang dan beraneka ragam.',
                    'answers' => [
                        ['jawaban' => 'Ya', 'benar' => true],
                        ['jawaban' => 'Tidak', 'benar' => false],
                    ],
                ],
                [
                    'soal' => 'Konsumsi sayur dan buah sebaiknya 5 porsi dalam sehari.',
                    'answers' => [
                        ['jawaban' => 'Ya', 'benar' => true],
                        ['jawaban' => 'Tidak', 'benar' => false],
                    ],
                ],
                [
                    'soal' => 'Wanita Usia Subur (WUS) atau remaja putri lebih beresiko terkena KEK.',
                    'answers' => [
                        ['jawaban' => 'Ya', 'benar' => true],
                        ['jawaban' => 'Tidak', 'benar' => false],
                    ],
                ],
                [
                    'soal' => 'WUS dengan ukuran Lingkar lengan atas < 23,5 cm adalah kondisi normal.',
                    'answers' => [
                        ['jawaban' => 'Ya', 'benar' => true],
                        ['jawaban' => 'Tidak', 'benar' => false],
                    ],
                ],
                [
                    'soal' => 'Wanita hamil yang mengalami KEK berisiko melahirkan bayi dengan berat badan lahir rendah',
                    'answers' => [
                        ['jawaban' => 'Ya', 'benar' => true],
                        ['jawaban' => 'Tidak', 'benar' => false],
                    ],
                ],
                [
                    'soal' => 'Akibat KEK bagi WUS adalah beresiko terkena penyakit infeksi dan gangguan hormonal serta beresiko melahirkan anak BBLR dan stunting',
                    'answers' => [
                        ['jawaban' => 'Ya', 'benar' => true],
                        ['jawaban' => 'Tidak', 'benar' => false],
                    ],
                ],
                [
                    'soal' => 'Terjadinya perdarahan dan anemia merupakan dampak KEK bagi WUS yang sedang hamil',
                    'answers' => [
                        ['jawaban' => 'Ya', 'benar' => true],
                        ['jawaban' => 'Tidak', 'benar' => false],
                    ],
                ],
                [
                    'soal' => 'Pekerjaan berat tanpa asupan gizi yang cukup dapat menyebabkan KEK',
                    'answers' => [
                        ['jawaban' => 'Ya', 'benar' => true],
                        ['jawaban' => 'Tidak', 'benar' => false],
                    ],
                ],
                [
                    'soal' => 'Melewatkan sarapan secara rutin dapat meningkatkan risiko KEK',
                    'answers' => [
                        ['jawaban' => 'Ya', 'benar' => true],
                        ['jawaban' => 'Tidak', 'benar' => false],
                    ],
                ],
                [
                    'soal' => 'Pemantauan berat badan dan LILA secara rutin dapat membantu mencegah KEK',
                    'answers' => [
                        ['jawaban' => 'Ya', 'benar' => true],
                        ['jawaban' => 'Tidak', 'benar' => false],
                    ],
                ],
            ],
            'Post Test' => [
                [
                    'soal' => 'Kekurangan Energi Kronis (KEK) adalah keadaan dimana remaja putri/wanita mengalami kekurangan gizi (kalori dan protein) yang berlangsung lama (kronis).',
                    'answers' => [
                        ['jawaban' => 'Ya', 'benar' => true],
                        ['jawaban' => 'Tidak', 'benar' => false],
                    ],
                ],
                [
                    'soal' => 'KEK pada WUS/bumil dapat diketahui dengan  mengukur  Lingkar Lengan  Atas (LiLA)',
                    'answers' => [
                        ['jawaban' => 'Ya', 'benar' => true],
                        ['jawaban' => 'Tidak', 'benar' => false],
                    ],
                ],
                [
                    'soal' => 'Faktor penyebab KEK adalah pola konsumsi yang tidak seimbang dan kondisi sosial ekonomi.',
                    'answers' => [
                        ['jawaban' => 'Ya', 'benar' => true],
                        ['jawaban' => 'Tidak', 'benar' => false],
                    ],
                ],
                [
                    'soal' => 'Gejala KEK antara lain Lingkar Lengan Atas <23,5 cm, kurang cekatan saat bekerja, merasa cepat lelah, lemah, lesu, dan letih.',
                    'answers' => [
                        ['jawaban' => 'Ya', 'benar' => true],
                        ['jawaban' => 'Tidak', 'benar' => false],
                    ],
                ],
                [
                    'soal' => 'Dampak KEK yaitu kematian ibu saat melahirkan, perdarahan saat melahirkan, melahirkan BBLR, anemia pada bayi, bayi mudah terinfeksi, terhambatnya pertumbuhan otak janin, keguguran, cacat bawaan, bayi lahir mati.',
                    'answers' => [
                        ['jawaban' => 'Ya', 'benar' => true],
                        ['jawaban' => 'Tidak', 'benar' => false],
                    ],
                ],
                [
                    'soal' => 'Pencegahan KEK adalah dengan mengonsumsi makanan bergizi seimbang dan beraneka ragam.',
                    'answers' => [
                        ['jawaban' => 'Ya', 'benar' => true],
                        ['jawaban' => 'Tidak', 'benar' => false],
                    ],
                ],
                [
                    'soal' => 'Konsumsi sayur dan buah sebaiknya 5 porsi dalam sehari.',
                    'answers' => [
                        ['jawaban' => 'Ya', 'benar' => true],
                        ['jawaban' => 'Tidak', 'benar' => false],
                    ],
                ],
                [
                    'soal' => 'Wanita Usia Subur (WUS) atau remaja putri lebih beresiko terkena KEK.',
                    'answers' => [
                        ['jawaban' => 'Ya', 'benar' => true],
                        ['jawaban' => 'Tidak', 'benar' => false],
                    ],
                ],
                [
                    'soal' => 'WUS dengan ukuran Lingkar lengan atas < 23,5 cm adalah kondisi normal.',
                    'answers' => [
                        ['jawaban' => 'Ya', 'benar' => true],
                        ['jawaban' => 'Tidak', 'benar' => false],
                    ],
                ],
                [
                    'soal' => 'Wanita hamil yang mengalami KEK berisiko melahirkan bayi dengan berat badan lahir rendah',
                    'answers' => [
                        ['jawaban' => 'Ya', 'benar' => true],
                        ['jawaban' => 'Tidak', 'benar' => false],
                    ],
                ],
                [
                    'soal' => 'Akibat KEK bagi WUS adalah beresiko terkena penyakit infeksi dan gangguan hormonal serta beresiko melahirkan anak BBLR dan stunting',
                    'answers' => [
                        ['jawaban' => 'Ya', 'benar' => true],
                        ['jawaban' => 'Tidak', 'benar' => false],
                    ],
                ],
                [
                    'soal' => 'Terjadinya perdarahan dan anemia merupakan dampak KEK bagi WUS yang sedang hamil',
                    'answers' => [
                        ['jawaban' => 'Ya', 'benar' => true],
                        ['jawaban' => 'Tidak', 'benar' => false],
                    ],
                ],
                [
                    'soal' => 'Pekerjaan berat tanpa asupan gizi yang cukup dapat menyebabkan KEK',
                    'answers' => [
                        ['jawaban' => 'Ya', 'benar' => true],
                        ['jawaban' => 'Tidak', 'benar' => false],
                    ],
                ],
                [
                    'soal' => 'Melewatkan sarapan secara rutin dapat meningkatkan risiko KEK',
                    'answers' => [
                        ['jawaban' => 'Ya', 'benar' => true],
                        ['jawaban' => 'Tidak', 'benar' => false],
                    ],
                ],
                [
                    'soal' => 'Pemantauan berat badan dan LILA secara rutin dapat membantu mencegah KEK',
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
