<div>
    <div class="container">
        <h2 class="mt-4">Manajemen Soal</h2>

        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif

        <!-- Filter Jenis Soal -->
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


        <button wire:click="create()" class="btn btn-primary mb-3">Tambah Soal</button>


        <table class="table table-bordered">
            <thead>
                <tr>
                    {{-- <th>ID</th> --}}
                    <th>Soal</th>
                    <th>Jenis Soal</th>
                    <th>Nomor Soal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if ($soals->isEmpty())
                    <tr>
                        <td colspan="5" class="text-center text-muted">Tidak ada data soal.</td>
                    </tr>
                @else
                    @foreach ($soals as $soal)
                        <tr>
                            {{-- <td>{{ $soal->id }}</td> --}}
                            <td>{{ $soal->soal }}</td>
                            <td>{{ $soal->jenis_soal }}</td>
                            <td>{{ $soal->nomor_soal }}</td>
                            <td>
                                <button wire:click="edit({{ $soal->id }})" class="btn btn-warning">Edit</button>
                                <button wire:click="delete({{ $soal->id }})" class="btn btn-danger">Hapus</button>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        @if ($isOpen)
            <div class="modal fade show" style="display: block;" aria-modal="true">
                <div class="modal-dialog modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="text-xl">{{ $id ? 'Edit Soal' : 'Tambah Soal' }}</h4>
                            <button type="button" class="close" wire:click="closeModal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <!-- Soal -->
                                <div class="form-group mb-4">
                                    <label for="soal">Soal:</label>
                                    <textarea id="soal" wire:model="soal" class="form-control w-full border rounded"></textarea>
                                    @error('soal')
                                        <span style="color: red;">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Jenis Soal -->
                                <div class="form-group mb-4">
                                    <label for="jenis_soal">Jenis Soal:</label>
                                    <select id="jenis_soal" wire:model="jenis_soal"
                                        class="form-control w-full border rounded">
                                        <option value="">Pilih Jenis Soal</option>
                                        <option value="Pre Test">Pre Test</option>
                                        <option value="Post Test">Post Test</option>
                                        <option value="Skrening">Skrening</option>
                                    </select>
                                    @error('jenis_soal')
                                        <span style="color: red;">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Nomor Soal -->
                                <div class="form-group mb-4">
                                    <label for="nomor_soal">Nomor Soal (Otomatis)</label>
                                    <input id="nomor_soal" type="number" wire:model="nomor_soal"
                                        class="form-control w-full border rounded" readonly>
                                </div>

                                <!-- Buttons -->
                                <div class="modal-footer">
                                    <div class="flex gap-2 mt-4">
                                        <button wire:click.prevent="store()" class="btn btn-primary">Simpan</button>
                                        <button wire:click.prevent="closeModal()"
                                            class="btn btn-secondary">Batal</button>
                                    </div>
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
</div>
