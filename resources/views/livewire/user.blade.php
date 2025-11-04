<div>
    <div class="container">
        <h2 class="mt-4">Manajemen Admin Users</h2>

        {{-- Menampilkan pesan sukses jika ada --}}
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif

        {{-- Tombol untuk menambah user --}}
        <button wire:click="create()" class="btn btn-primary mb-3">Tambah User</button>

        {{-- Tabel data user --}}
        <table class="table table-bordered">
            <thead>
                <tr>
                    {{-- <th>ID</th> --}}
                    <th>Nama</th>
                    <th>Email</th>
                    <th>No HP</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                {{-- Menampilkan pesan jika tidak ada data user --}}
                @if ($users->isEmpty())
                    <tr>
                        <td colspan="4" class="text-center text-muted">Tidak ada data user.</td>
                    </tr>
                @else
                    {{-- Menampilkan daftar user --}}
                    @foreach ($users as $user)
                        <tr>
                            {{-- <td>{{ $user->id }}</td> --}}
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->no_hp }}</td>
                            <td>
                                <button wire:click="edit({{ $user->id }})" class="btn btn-warning">Edit</button>
                                <button wire:click="delete({{ $user->id }})" class="btn btn-danger">Hapus</button>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>

        {{-- Modal Form --}}
        @if ($isOpen)
            <div class="modal fade show" style="display: block;" aria-modal="true">
                <div class="modal-dialog modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="text-xl">{{ $selected_id ? 'Edit User' : 'Tambah User' }}</h4>
                            <button type="button" class="close" wire:click="closeModal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <!-- Nama -->
                                <div class="form-group mb-4">
                                    <label for="name">Nama:</label>
                                    <input id="name" type="text" wire:model="name"
                                        class="form-control w-full border rounded">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div class="form-group mb-4">
                                    <label for="email">Email:</label>
                                    <input id="email" type="email" wire:model="email"
                                        class="form-control w-full border rounded">
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- No HP -->
                                <div class="form-group mb-4">
                                    <label for="no_hp">No HP:</label>
                                    <input id="no_hp" type="text" wire:model="no_hp"
                                        class="form-control w-full border rounded">
                                    @error('no_hp')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Password (ditambahkan hanya untuk tambah user) -->
                                @if (!$selected_id)
                                    <!-- Hanya tampilkan jika menambah user -->
                                    <div class="form-group mb-4">
                                        <label for="password">Password:</label>
                                        <input id="password" type="password" wire:model="password"
                                            class="form-control w-full border rounded">
                                        @error('password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                @endif

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

            <!-- Overlay untuk menutup modal ketika klik di luar modal -->
            <div class="modal-backdrop fade show" wire:click="closeModal"></div>
        @endif
    </div>
</div>
