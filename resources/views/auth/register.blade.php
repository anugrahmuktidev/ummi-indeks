@extends('layouts.basic')
@section('content')
    <style>
        .register-card {
            background-color: rgba(255, 255, 255, 0.9);
            border: none;
            border-radius: 24px;
            box-shadow: 0 15px 35px rgba(15, 23, 42, 0.2);
            backdrop-filter: blur(3px);
        }

        .register-card .form-control,
        .register-card .form-select,
        .register-card textarea {
            background-color: rgba(255, 255, 255, 0.85);
            border-color: rgba(148, 163, 184, 0.4);
        }
    </style>
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-12 col-xl-8">
            <div class="card mt-4 register-card">
                <div class="card-body p-4">
                    <div class="text-center mt-2">
                        <h5 class="text-primary">Daftar Akun Baru</h5>
                        <p class="text-muted">Isi formulir berikut untuk mendaftar.</p>
                    </div>
                    <div class="p-2 mt-4">
                        <!-- Alert untuk pesan sukses -->
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                            </div>
                            <script>
                                // Redirect ke halaman login setelah 5 detik
                                setTimeout(function() {
                                    window.location.href = "{{ url('/login') }}?clearsession=true";
                                }, 5000); // 5000 milidetik = 5 detik
                            </script>
                        @endif

                        <!-- Alert untuk pesan error -->
                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ old('name') }}" placeholder="Masukkan Nama Lengkap" required>
                                @error('name')
                                    <span style="color: red;">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="no_hp" class="form-label">Nomor Hp</label>
                                <input type="text" class="form-control" id="no_hp" name="no_hp"
                                    value="{{ old('no_hp') }}" placeholder="Masukkan Nomor Hp" required>
                                @error('no_hp')
                                    <span style="color: red;">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir"
                                    value="{{ old('tanggal_lahir') }}" placeholder="Masukkan Tanggal Lahir" required>
                                @error('tanggal_lahir')
                                    <span style="color: red;">{{ $message }}</span>
                                @enderror
                            </div>



                            <div class="mb-3">
                                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                <select name="jenis_kelamin" class="form-control">
                                    <option value="Laki-laki"
                                        {{ old('jenis_kelamin', 'Perempuan') == 'Laki-laki' ? 'selected' : '' }}>
                                        Laki-laki</option>
                                    <option value="Perempuan"
                                        {{ old('jenis_kelamin', 'Perempuan') == 'Perempuan' ? 'selected' : '' }}>
                                        Perempuan</option>
                                </select>
                                @error('jenis_kelamin')
                                    <span style="color: red;">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="pendidikan" class="form-label">Pendidikan</label>
                                <select id="pendidikan" name="pendidikan" class="form-control">
                                    <option value="">-- Pilih Pendidikan --</option>
                                    <option value="SD" {{ old('pendidikan') == 'SD' ? 'selected' : '' }}>SD</option>
                                    <option value="SMP" {{ old('pendidikan') == 'SMP' ? 'selected' : '' }}>SMP</option>
                                    <option value="SMA" {{ old('pendidikan') == 'SMA' ? 'selected' : '' }}>SMA</option>
                                    <option value="PERGURUAN TINGGI"
                                        {{ old('pendidikan') == 'PERGURUAN TINGGI' ? 'selected' : '' }}>
                                        PERGURUAN TINGGI</option>
                                    <option value="TIDAK PERNAH SEKOLAH"
                                        {{ old('pendidikan') == 'TIDAK PERNAH SEKOLAH' ? 'selected' : '' }}>
                                        TIDAK PERNAH SEKOLAH</option>
                                </select>
                                @error('pendidikan')
                                    <span style="color: red;">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="pekerjaan" class="form-label">Pekerjaan</label>
                                <select id="pekerjaan" name="pekerjaan" class="form-control" onchange="toggleOtherInput()">
                                    <option value="">-- Pilih Pekerjaan --</option>
                                    <option value="ASN" {{ old('pekerjaan') == 'ASN' ? 'selected' : '' }}>ASN</option>
                                    <option value="TNI/POLRI" {{ old('pekerjaan') == 'TNI/POLRI' ? 'selected' : '' }}>
                                        TNI/POLRI
                                    </option>
                                    <option value="Tani" {{ old('pekerjaan') == 'Tani' ? 'selected' : '' }}>Tani
                                    </option>
                                    <option value="Dagang" {{ old('pekerjaan') == 'Dagang' ? 'selected' : '' }}>Dagang
                                    </option>
                                    <option value="Buruh" {{ old('pekerjaan') == 'Buruh' ? 'selected' : '' }}>Buruh
                                    </option>
                                    <option value="Tidak Bekerja"
                                        {{ old('pekerjaan') == 'Tidak Bekerja' ? 'selected' : '' }}>Tidak
                                        Bekerja</option>
                                    <option value="Lainnya" {{ old('pekerjaan') == 'Lainnya' ? 'selected' : '' }}>Lainnya
                                    </option>
                                </select>
                                @error('pekerjaan')
                                    <span style="color: red;">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3" id="pekerjaan-lain" style="display: none;">
                                <label for="pekerjaan_lain" class="form-label">Sebutkan Pekerjaan
                                    Lainnya</label>
                                <input type="text" class="form-control" id="pekerjaan_lain" name="pekerjaan_lain"
                                    value="{{ old('pekerjaan_lain') }}" placeholder="Masukkan Pekerjaan Lainnya">
                                @error('pekerjaan_lain')
                                    <span style="color: red;">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat</label>
                                <textarea id="alamat" name="alamat" class="form-control" value="{{ old('alamat') }}"
                                    placeholder="Masukkan Alamat">{{ old('alamat') }}</textarea>
                                @error('alamat')
                                    <span style="color: red;">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="norumah" class="form-label">Nomor Rumah</label>
                                <input type="text" class="form-control" id="norumah" name="norumah"
                                    value="{{ old('norumah') }}" placeholder="Masukkan Nomor Rumah">
                                @error('norumah')
                                    <span style="color: red;">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="rt" class="form-label">RT</label>
                                <input type="text" class="form-control" id="rt" name="rt"
                                    value="{{ old('rt') }}" placeholder="Masukkan RT">
                                @error('rt')
                                    <span style="color: red;">{{ $message }}</span>
                                @enderror
                            </div>



                            <div class="mb-3">
                                <label for="kelurahan" class="form-label">Kelurahan</label>
                                <input type="text" class="form-control" id="kelurahan" name="kelurahan"
                                    value="{{ old('kelurahan') }}" placeholder="Masukkan Kelurahan">
                                @error('kelurahan')
                                    <span style="color: red;">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="kecamatan" class="form-label">Kecamatan</label>
                                <input type="text" class="form-control" id="kecamatan" name="kecamatan"
                                    value="{{ old('kecamatan') }}" placeholder="Masukkan Kecamatan">
                                @error('kecamatan')
                                    <span style="color: red;">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="kabupaten" class="form-label">Kabupaten</label>
                                <input type="text" class="form-control" id="kabupaten" name="kabupaten"
                                    value="{{ old('kabupaten') }}" placeholder="Masukkan Kabupaten">
                                @error('kabupaten')
                                    <span style="color: red;">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="provinsi" class="form-label">Provinsi</label>
                                <input type="text" class="form-control" id="provinsi" name="provinsi"
                                    value="{{ old('provinsi') }}" placeholder="Masukkan Provinsi">
                                @error('provinsi')
                                    <span style="color: red;">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="berat_badan" class="form-label">Berat Badan (kg)</label>
                                <input type="number" step="0.1" class="form-control" id="berat_badan"
                                    name="berat_badan" value="{{ old('berat_badan') }}"
                                    placeholder="Masukkan Berat Badan">
                                @error('berat_badan')
                                    <span style="color: red;">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="tinggi_badan" class="form-label">Tinggi Badan (cm)</label>
                                <input type="number" step="0.1" class="form-control" id="tinggi_badan"
                                    name="tinggi_badan" value="{{ old('tinggi_badan') }}"
                                    placeholder="Masukkan Tinggi Badan">
                                @error('tinggi_badan')
                                    <span style="color: red;">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mt-4">
                                <button class="btn btn-success w-100" type="submit">Daftar</button>
                            </div>
                        </form>
                        <div class="mt-4 text-center">
                            <p class="mb-0">Sudah punya akun ? <a href="{{ route('login') }}"
                                    class="fw-semibold text-primary text-decoration-underline">Login</a></p>
                        </div>
                    </div>
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->



        </div>
    </div>
    <script>
        function toggleOtherInput() {
            const pekerjaanSelect = document.getElementById('pekerjaan');
            const otherPekerjaanDiv = document.getElementById('pekerjaan-lain');
            if (pekerjaanSelect.value === 'Lainnya') {
                otherPekerjaanDiv.style.display = 'block';
            } else {
                otherPekerjaanDiv.style.display = 'none';
            }
        }
    </script>
@endsection
