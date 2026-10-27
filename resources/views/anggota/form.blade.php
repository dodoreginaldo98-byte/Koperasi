<div class="row g-3">

    <div class="col-md-6">
        <label class="form-label">Nomor Anggota</label>
        <input type="text" name="no_anggota"
            class="form-control @error('no_anggota') is-invalid @enderror"
            value="{{ old('no_anggota', $anggota->no_anggota ?? '') }}"
            required>
        @error('no_anggota')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">NIK (16 digit)</label>
        <input type="text" name="nik" maxlength="16"
            inputmode="numeric"
            class="form-control @error('nik') is-invalid @enderror"
            value="{{ old('nik', $anggota->nik ?? '') }}"
            required>
        @error('nik')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">Nama Lengkap</label>
        <input type="text" name="nama"
            class="form-control @error('nama') is-invalid @enderror"
            value="{{ old('nama', $anggota->nama ?? '') }}"
            required>
        @error('nama')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">Jenis Kelamin</label>
        <select name="jenis_kelamin" class="form-select" required>
            <option value="">-- Pilih --</option>
            <option value="L" @selected(old('jenis_kelamin', $anggota->jenis_kelamin ?? '') === 'L')>
                Laki-laki
            </option>
            <option value="P" @selected(old('jenis_kelamin', $anggota->jenis_kelamin ?? '') === 'P')>
                Perempuan
            </option>
        </select>
        @error('jenis_kelamin')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">Tempat Lahir</label>
        <input type="text" name="tempat_lahir"
            class="form-control"
            value="{{ old('tempat_lahir', $anggota->tempat_lahir ?? '') }}">
    </div>

    <div class="col-md-6">
        <label class="form-label">Tanggal Lahir</label>
        <input type="date" name="tanggal_lahir"
            class="form-control"
            value="{{ old('tanggal_lahir', isset($anggota) && $anggota->tanggal_lahir ? $anggota->tanggal_lahir->format('Y-m-d') : '') }}">
        @error('tanggal_lahir')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">Nomor HP</label>
        <input type="text" name="no_hp"
            class="form-control @error('no_hp') is-invalid @enderror"
            value="{{ old('no_hp', $anggota->no_hp ?? '') }}"
            required>
        @error('no_hp')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">Email</label>
        <input type="email" name="email"
            class="form-control @error('email') is-invalid @enderror"
            value="{{ old('email', $anggota->email ?? '') }}">
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">Tanggal Bergabung</label>
        <input type="date" name="tanggal_bergabung"
            class="form-control @error('tanggal_bergabung') is-invalid @enderror"
            value="{{ old('tanggal_bergabung', isset($anggota) && $anggota->tanggal_bergabung ? $anggota->tanggal_bergabung->format('Y-m-d') : now()->format('Y-m-d')) }}"
            required>
        @error('tanggal_bergabung')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">Status Anggota</label>
        <select name="status" class="form-select" required>
            <option value="aktif"
                @selected(old('status', $anggota->status ?? 'aktif') === 'aktif')>
                Aktif
            </option>
            <option value="nonaktif"
                @selected(old('status', $anggota->status ?? 'aktif') === 'nonaktif')>
                Nonaktif
            </option>
        </select>
        @error('status')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <label class="form-label">Alamat Lengkap</label>
        <textarea name="alamat" rows="3"
            class="form-control @error('alamat') is-invalid @enderror"
            required>{{ old('alamat', $anggota->alamat ?? '') }}</textarea>
        @error('alamat')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

</div>

<div class="mt-4 d-flex gap-2">
    <button type="submit" class="btn btn-primary">
        <i class="bi bi-save"></i> Simpan
    </button>
    <a href="{{ route('anggota.index') }}" class="btn btn-secondary">
        Batal
    </a>
</div>