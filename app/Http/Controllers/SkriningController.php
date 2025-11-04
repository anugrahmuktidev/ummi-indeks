<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Soal;
use App\Models\RiwayatSkrining;
use App\Models\Skrining;
use Illuminate\Support\Facades\Log;

class SkriningController extends Controller
{
    public function startTest()
{
    $user = Auth::user();

    RiwayatSkrining::where('user_id', $user->id)
    ->where('jenis_sesi', 'Skrining')
    ->where('status', 'In Progress')
    ->update(['status' => 'Completed']);

    // Buat atau ambil riwayat skrining (riwayat_skrining)
    $riwayatSkrining = RiwayatSkrining::create([
        'user_id' => $user->id,
        'jenis_sesi' => 'Skrining',
        'tanggal' => now(),
        'status' => 'In Progress',
    ]);


    // Redirect ke pertanyaan pertama
    return redirect()->route('skrining.show', ['questionNumber' => 1]);
}
    public function showQuestion($nomorSoal)
    {
        $user = Auth::user();

        // Validasi nomor soal
        if ($nomorSoal < 1 || $nomorSoal > 9) {
            return redirect()->route('skrining.show', ['questionNumber' => 1]);
        }

        // Ambil soal berdasarkan nomor soal
        $question = Soal::where('jenis_soal', 'Skrining')->skip($nomorSoal - 1)->first();

        if (!$question) {
            return redirect()->route('skrining.result'); // Jika soal habis, arahkan ke hasil
        }

        $riwayatSkrining = RiwayatSkrining::where('user_id', $user->id)
        ->where('jenis_sesi', 'Skrining')
        ->where('status', 'In Progress')
        ->first();

        if ($riwayatSkrining) {
            // Ambil jawaban sebelumnya untuk soal ini
            $previousAnswer = Skrining::where('soal_id', $question->id)
                ->where('riwayat_skrining_id', $riwayatSkrining->id)
                ->first();
        } else {
            $previousAnswer = null;
        }

         // Hapus jawaban untuk soal ini jika ada, karena pengguna kembali ke nomor sebelumnya
         if ($riwayatSkrining) {
            Skrining::where('soal_id', $question->id)
            ->where('riwayat_skrining_id', $riwayatSkrining->id)
            ->delete();
        }

        // Ambil jawaban yang sesuai dengan soal
        $answers = $question->jawaban;

        return view('user.skrining.skrining-test', [
            'question' => $question,
            'answers' => $answers,
            'previous' => $previousAnswer ? $previousAnswer->jawaban_id : null,
            'currentQuestionNumber' => $nomorSoal
        ]);
    }

    public function submitSkriningAnswer(Request $request)
    {
        // Validasi jawaban
        $request->validate([
            'jawaban_id' => 'required|exists:jawaban,id',
            'question_id' => 'required|exists:soal,id',
            'question_number' => 'required|integer'
        ]);

        $user = Auth::user();

        // Cek apakah ada riwayat skrining yang sedang berjalan
        $riwayatSkrining = RiwayatSkrining::where('user_id', $user->id)
            ->where('jenis_sesi', 'Skrining')
            ->where('status', 'In Progress')
            ->first();

        if (!$riwayatSkrining) {
            // Jika tidak ada riwayat yang aktif, ambil riwayat terakhir yang sudah completed
            $riwayatSkrining = RiwayatSkrining::where('user_id', $user->id)
                ->where('jenis_sesi', 'Skrining')
                ->where('status', 'Completed')
                ->orderBy('tanggal', 'desc')
                ->first();

            if ($riwayatSkrining) {

                // Tampilkan hasil riwayat skrining terakhir
                return view('user.skrining.result', [

                    'statusRisiko' => $riwayatSkrining->statusRisiko
                ]);
            }

            // Jika tidak ada riwayat sama sekali
            return redirect()->route('skrining.start')->with('error', 'Tidak ada sesi skrining aktif atau riwayat sebelumnya.');
        }

        // Simpan jawaban jika belum ada
        $existingAnswer = Skrining::where('soal_id', $request->input('question_id'))
            ->where('riwayat_skrining_id', $riwayatSkrining->id)
            ->first();

        if (!$existingAnswer) {
            $jawabanCount = Skrining::where('riwayat_skrining_id', $riwayatSkrining->id)->count();

            if ($jawabanCount < 10) {
                Skrining::create([
                    'soal_id' => $request->input('question_id'),
                    'jawaban_id' => $request->input('jawaban_id'),
                    'riwayat_skrining_id' => $riwayatSkrining->id,
                ]);
            }
        }

        $nextQuestionNumber = $request->input('question_number') + 1;

        if ($nextQuestionNumber > 9) {
            $riwayatSkrining->update(['status' => 'Completed']);

            // Mengambil semua jawaban dari skrining
            $jawabanSkrining = Skrining::where('riwayat_skrining_id', $riwayatSkrining->id)
                ->whereHas('soal', function ($query) {
                    $query->where('jenis_soal', 'Skrining'); // Pastikan jenis soal adalah Skrining
                })
                ->with(['jawaban', 'soal']) // Memuat jawaban dan soal
                ->get();

            // Inisialisasi status risiko
            $jawabanNomor1 = false;
            $jawabanNomor2 = false;

            // Memeriksa jawaban untuk nomor soal 1 dan 2
            foreach ($jawabanSkrining as $soal) {
                if ($soal->soal->nomor_soal == 1 && $soal->jawaban->kunci_jawaban) {
                    $jawabanNomor1 = true; // Soal nomor 1 dijawab benar
                }
                if ($soal->soal->nomor_soal == 2 && $soal->jawaban->kunci_jawaban) {
                    $jawabanNomor2 = true; // Soal nomor 2 dijawab benar
                }
            }

            // Tentukan status risiko berdasarkan jawaban yang terdeteksi
            $statusRisiko = 'Rendah'; // Default
            if ($jawabanNomor1 && $jawabanNomor2) {
                $statusRisiko = 'Tinggi';
            } elseif ($jawabanNomor1 && !$jawabanNomor2) {
                $statusRisiko = 'Sedang';
            }

            // Simpan status risiko ke database
            $riwayatSkrining->update(['status_risiko' => $statusRisiko]);

            $user = Auth::user();
            $user->is_first_login = false;
            $user->save();

            // Tampilkan hasil skrining
            return view('user.skrining.result', [
                'statusRisiko' => $statusRisiko
            ]);
        }




        return redirect()->route('skrining.show', ['questionNumber' => $nextQuestionNumber]);
    }




    public function viewSkriningHistory()
    {
        $user = Auth::user();

        $riskAssessments = $user->riskAssessments()
            ->orderByDesc('created_at')
            ->get();

        return view('user.riwayat-skrining', [
            'riskAssessments' => $riskAssessments,
        ]);
    }





}
