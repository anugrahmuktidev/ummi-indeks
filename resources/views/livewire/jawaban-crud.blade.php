<div>
    <h2 class="mt-4">Manajemen Jawaban</h2>

    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <div class="col-lg-8 mb-3">
        <label for="jenis_soal" class="form-label">Filter Jenis Soal:</label>
        <div class="filter-dropdown">
            <select id="filter" wire:model.live="filter" name="filter" class="form-control">
                <option value="">Semua Jenis Soal</option>
                <option value="Pre Test">Pre Test</option>
                <option value="Post Test">Post Test</option>
                <option value="Skrining">Skrining</option>
            </select>
        </div>
    </div>

    {{-- <button wire:click="applyFilter" class="btn btn-outline-success">Terapkan Filter</button> --}}

    <button wire:click="openModal()" class="btn btn-primary">Tambah Jawaban</button>

    {{-- @if ($isOpen)
        @include('admin.jawaban.modal')
    @endif --}}

    <hr>

    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Soal</th>
                <th>Jawaban</th>
                <th>Kunci Jawaban</th>
                <th>Poin Soal</th>
                <th>Jenis Soal</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @php
                $currentSoalId = null;
            @endphp
            @forelse ($jawabans as $jawaban)
                <tr>
                    {{-- Tampilkan soal hanya sekali per soal_id --}}
                    @if ($currentSoalId !== $jawaban->soal_id)
                        @php
                            $currentSoalId = $jawaban->soal_id;
                        @endphp
                        <td rowspan="{{ $jawabans->where('soal_id', $jawaban->soal_id)->count() }}">
                            {{ $jawaban->soal->nomor_soal }}
                        </td>
                        <td rowspan="{{ $jawabans->where('soal_id', $jawaban->soal_id)->count() }}">
                            {{ $jawaban->soal->soal }}
                        </td>
                    @endif
                    <td>{{ $jawaban->jawaban }}</td>
                    <td>{{ $jawaban->kunci_jawaban ? 'Ya' : 'Tidak' }}</td>
                    <td>{{ $jawaban->poin_soal }}</td>
                    <td>{{ $jawaban->soal->jenis_soal }}</td>
                    <td>
                        <button wire:click="edit({{ $jawaban->id }})" class="btn btn-warning">Edit</button>
                        <button wire:click="delete({{ $jawaban->id }})" class="btn btn-danger">Hapus</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>

    </table>
    @if ($isOpen)
        <div class="modal fade show" style="display: block;" aria-modal="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="text-lg font-bold">
                            {{ $jawaban_id ? 'Edit Jawaban' : 'Tambah Jawaban' }}</h2>
                        <button type="button" class="close" wire:click="closeModal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group mb-4">
                                <label for="soal">Pilih Soal:</label>
                                <select wire:model="soal_id" class="form-control">
                                    <option value="">Pilih Soal</option>
                                    @foreach ($soals as $soal)
                                        <option value="{{ $soal->id }}">{{ $soal->nomor_soal }}.
                                            {{ $soal->soal }}</option>
                                    @endforeach
                                </select>
                                @error('soal_id')
                                    <span style="color: red;">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group mb-4">
                                <label for="jawaban">Jawaban:</label>
                                <input type="text" class="form-control" wire:model="jawaban">
                                @error('jawaban')
                                    <span style="color: red;">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group mb-4">
                                <label for="poin_soal">Poin Soal:</label>
                                <input type="number" class="form-control" wire:model="poin_soal"
                                    placeholder="Jika tidak menggunakan sistem poin, isi angka 0">
                                @error('poin_soal')
                                    <span style="color: red;">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" wire:model="kunci_jawaban">
                                <label class="form-check-label" for="kunci_jawaban">
                                    Kunci Jawaban
                                </label>
                            </div>
                            <div class="modal-footer">
                                {{-- <button type="button" class="btn btn-secondary" wire:click="closeModal">Tutup</button>s --}}
                                <button wire:click.prevent="store()" class="btn btn-success mt-4">Simpan</button>
                                <button wire:click.prevent="closeModal()" class="btn btn-secondary mt-4">Batal</button>
                            </div>
                        </form>

                    </div>

                </div>
            </div>
        </div>
        <!-- Overlay to close modal -->
        <div class="modal-backdrop fade show" wire:click="closeModal"></div>
    @endif
</div>
