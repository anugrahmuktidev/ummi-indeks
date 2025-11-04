<div class="space-y-2">
    <dl class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div>
            <dt class="text-sm text-gray-500">Nama</dt>
            <dd class="text-base font-medium text-gray-900">{{ $user->name }}</dd>
        </div>
        <div>
            <dt class="text-sm text-gray-500">No HP</dt>
            <dd class="text-base font-medium text-gray-900">{{ $user->no_hp ?? '-' }}</dd>
        </div>
        <div>
            <dt class="text-sm text-gray-500">Tanggal Lahir</dt>
            <dd class="text-base font-medium text-gray-900">
                {{ optional($user->tanggal_lahir)->format('d-m-Y') ?? '-' }}
            </dd>
        </div>
        <div>
            <dt class="text-sm text-gray-500">Jenis Kelamin</dt>
            <dd class="text-base font-medium text-gray-900">{{ $user->jenis_kelamin ?? '-' }}</dd>
        </div>
        <div>
            <dt class="text-sm text-gray-500">Berat Badan</dt>
            <dd class="text-base font-medium text-gray-900">
                {{ $user->berat_badan ? $user->berat_badan . ' kg' : '-' }}
            </dd>
        </div>
        <div>
            <dt class="text-sm text-gray-500">Tinggi Badan</dt>
            <dd class="text-base font-medium text-gray-900">
                {{ $user->tinggi_badan ? $user->tinggi_badan . ' cm' : '-' }}
            </dd>
        </div>
        <div>
            <dt class="text-sm text-gray-500">Pendidikan</dt>
            <dd class="text-base font-medium text-gray-900">{{ $user->pendidikan ?? '-' }}</dd>
        </div>
        <div>
            <dt class="text-sm text-gray-500">Pekerjaan</dt>
            <dd class="text-base font-medium text-gray-900">
                @if (($user->pekerjaan ?? '') === 'Lainnya')
                    {{ $user->pekerjaan_lain ? ucwords($user->pekerjaan_lain) : '-' }}
                @else
                    {{ $user->pekerjaan ? ucwords($user->pekerjaan) : '-' }}
                @endif
            </dd>
        </div>
        <div class="sm:col-span-2">
            <dt class="text-sm text-gray-500">Alamat</dt>
            <dd class="text-base font-medium text-gray-900">
                {{ $user->alamat ?? '-' }}
                @php
                    $parts = array_filter([
                        $user->no_rumah ?? null,
                        $user->rt ? 'RT ' . $user->rt : null,
                        $user->kelurahan ?? null,
                        $user->kecamatan ?? null,
                        $user->kabupaten ?? null,
                        $user->provinsi ?? null,
                    ]);
                @endphp
                @if (count($parts))
                    <div class="text-sm text-gray-600">{{ implode(', ', $parts) }}</div>
                @endif
            </dd>
        </div>
    </dl>
</div>
