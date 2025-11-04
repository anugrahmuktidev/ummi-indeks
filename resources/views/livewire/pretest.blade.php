<div>
    <!-- Striped Rows -->
    <h2 class="mt-4">Data Pretest Pengguna</h2>
    <button wire:click="exportPretest" class="btn btn-success"><i class="ri-file-excel-2-line" style="font-size: 20px"></i>
        Export Pretest</button>
    <table class="table table-striped">
        <thead class="table-light">
            <tr>
                <th scope="col">No</th>
                <th scope="col">Nama Pengguna</th>
                <th scope="col">Jawaban Benar</th>
            </tr>
        </thead>
        <tbody>
            @if (!empty($pretestResults))
                @foreach ($pretestResults as $index => $result)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $result['user'] }}</td>
                        <td>{{ $result['totalBenar'] }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="3" class="text-center text-muted">Tidak ada data pretest yang tersedia.</td>
                </tr>
            @endif
        </tbody>
    </table>
    @if ($showModal)
        <div class="modal fade show" style="display: block;" aria-modal="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Biodata User</h5>
                        <button type="button" class="close" wire:click="closeModal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @if ($selectedUser)
                            <table class="table table-striped">
                                <tr>
                                    <th>Nama</th>
                                    <td>{{ $selectedUser->name }}</td>
                                </tr>
                                <tr>
                                    <th>No HP</th>
                                    <td>{{ $selectedUser->no_hp }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Lahir</th>
                                    <td>{{ \Carbon\Carbon::parse($selectedUser->tanggal_lahir)->format('d-m-Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Jenis Kelamin</th>
                                    <td>{{ $selectedUser->jenis_kelamin }}</td>
                                </tr>
                                <tr>
                                    <th>Berat badan</th>
                                    <td>{{ $selectedUser->berat_badan }} Kg</td>
                                </tr>
                                <tr>
                                    <th>Tinggi Badan</th>
                                    <td>{{ $selectedUser->tinggi_badan }} Cm</td>
                                </tr>
                                <tr>
                                    <th>Pendidikan</th>
                                    <td>{{ $selectedUser->pendidikan }}</td>
                                </tr>
                                <tr>
                                    <th>Pekerjaan</th>
                                    <td>
                                        @if ($selectedUser->pekerjaan == 'Lainnya')
                                            {{ ucwords($selectedUser->pekerjaan_lain) }}
                                        @else
                                            {{ ucwords($selectedUser->pekerjaan) }}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Alamat</th>
                                    <td>{{ $selectedUser->alamat }}</td>
                                </tr>
                                <tr>
                                    <th>RT/RW</th>
                                    <td>{{ $selectedUser->rt }}/{{ $selectedUser->rw }}</td>
                                </tr>
                                <tr>
                                    <th>Kelurahan</th>
                                    <td>{{ $selectedUser->kelurahan }}</td>
                                </tr>
                                <tr>
                                    <th>Kecamatan</th>
                                    <td>{{ $selectedUser->kecamatan }}</td>
                                </tr>
                                <tr>
                                    <th>Kabupaten</th>
                                    <td>{{ $selectedUser->kabupaten }}</td>
                                </tr>
                                <tr>
                                    <th>Provinsi</th>
                                    <td>{{ $selectedUser->provinsi }}</td>
                                </tr>
                            </table>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeModal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Overlay to close modal -->
        <div class="modal-backdrop fade show" wire:click="closeModal"></div>
    @endif
</div>
