<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <h3 class="fw-bold-text mb-4">Penilaian Probabilitas Risiko KEK</h3>
                <p class="text-muted">Isi formulir sesuai kondisi saat ini. Sistem akan menghitung skor dan probabilitas
                    risiko berdasarkan faktor-faktor yang dipilih.</p>

                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif

                <form wire:submit.prevent="save" class="vstack gap-3">
                    <div>
                        <label class="form-label">Umur</label>
                        <select class="form-select" wire:model="umur">
                            <option value="">Pilih rentang umur</option>
                            <option value="2">18 – 20 tahun</option>
                            <option value="0">20 – 35 tahun</option>
                            <option value="1">36 – 49 tahun</option>
                        </select>
                        @error('umur')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label class="form-label">Paritas</label>
                        <select class="form-select" wire:model="paritas">
                            <option value="">Pilih status paritas</option>
                            <option value="2">≥ 4 kali</option>
                            <option value="1">1 – 3 anak</option>
                            <option value="0">Belum pernah</option>
                        </select>
                        @error('paritas')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label class="form-label">Penggunaan Alat Kontrasepsi</label>
                        <select class="form-select" wire:model="kontrasepsi">
                            <option value="">Pilih kondisi</option>
                            <option value="2">Menggunakan hormonal</option>
                            <option value="1">Pernah / menggunakan non-hormonal</option>
                            <option value="0">Tidak pernah menggunakan</option>
                        </select>
                        @error('kontrasepsi')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label class="form-label">Penyakit Infeksi</label>
                        <select class="form-select" wire:model="penyakit_infeksi">
                            <option value="">Pilih kondisi</option>
                            <option value="2">Berat</option>
                            <option value="1">Ringan</option>
                            <option value="0">Tidak ada</option>
                        </select>
                        @error('penyakit_infeksi')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label class="form-label">Aktivitas Fisik</label>
                        <select class="form-select" wire:model="aktifitas_fisik">
                            <option value="">Pilih tingkat aktivitas</option>
                            <option value="2">Berat</option>
                            <option value="1">Sedang</option>
                            <option value="0">Ringan</option>
                        </select>
                        @error('aktifitas_fisik')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label class="form-label">Status Pekerjaan</label>
                        <select class="form-select" wire:model="status_pekerjaan">
                            <option value="">Pilih status</option>
                            <option value="1">Bekerja</option>
                            <option value="0">Tidak bekerja</option>
                        </select>
                        @error('status_pekerjaan')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label class="form-label">Status Kawin</label>
                        <select class="form-select" wire:model="status_kawin">
                            <option value="">Pilih status</option>
                            <option value="0">Menikah</option>
                            <option value="1">Belum / tidak menikah</option>
                        </select>
                        @error('status_kawin')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label class="form-label">Status Ekonomi</label>
                        <select class="form-select" wire:model="status_ekonomi">
                            <option value="">Pilih status</option>
                            <option value="1">Rendah</option>
                            <option value="0">Tinggi</option>
                        </select>
                        @error('status_ekonomi')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                            <i class="ri-arrow-go-back-line me-1"></i>
                            Batal
                        </a>
                        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                            <i class="ri-save-3-line me-1"></i>
                            Simpan &amp; Lihat Hasil
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
