<div>
    <main id="main" class="main">
        <div class="d-flex align-items-center justify-content-between">
            <div class="pagetitle">
                <h1>Daftar Pengajuan</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item">Pages</li>
                        <li class="breadcrumb-item active">Pengajuan</li>
                    </ol>
                </nav>
            </div>
            @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show ms-3" role="alert" style="min-width: 300px;">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
        </div>

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center pt-2 pb-3">
                                <button class="btn btn-primary" wire:click="showModal"><i class="bi bi-plus-square-fill me-2"></i>Tambah Pengajuan</button>
                                <div class="d-flex gap-2">
                                    <button wire:click="exportPdf" class="btn btn-danger"><i class="bi bi-file-earmark-pdf-fill me-2"></i>Export PDF</button>
                                    <button wire:click="exportExcel" class="btn btn-success"> <i class="bi bi-file-excel-fill me-1"></i> Export Excel</button>
                                </div>
                            </div>

                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Pengaju</th>
                                        <th>Nama Barang</th>
                                        <th>Tanggal Pengajuan</th>
                                        <th>Jumlah</th>
                                        <th>Terpenuhi</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pengajuan as $loopIndex => $pengajuans)
                                    <tr>
                                        <th>{{ $pengajuan->firstItem() + $loopIndex }}</th>
                                        <td>{{ $pengajuans->pelanggan->nama ?? '-' }}</td>
                                        <td>{{ $pengajuans->nama_barang ?? '-' }}</td>
                                        <td>{{ $pengajuans->tgl_pengajuan ?? '-' }}</td>
                                        <td>{{ $pengajuans->jumlah ?? '-' }}</td>
                                        <td class="text-center">
                                            <div class="mx-4">
                                                <div class="form-check form-switch">
                                                    <input type="checkbox" class="form-check-input" style="transform: scale(1.8);"
                                                        wire:click="toggleTerpenuhi({{ $pengajuans->pengajuan_id }})"
                                                        @if($pengajuans->status == '1') checked @endif>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $pengajuans->status == '1' ? 'Terpenuhi' : 'Belum Terpenuhi' }}</td>
                                        <td>
                                            <a wire:click="edit({{ $pengajuans->pengajuan_id }})" class="bi bi-pencil-square fs-3 text-primary cursor-pointer" data-bs-toggle="modal" data-bs-target="#editPengajuanModal"></a>
                                            <a wire:click="confirmDelete('{{ $pengajuans->pengajuan_id }}')" class="bi bi-trash fs-3 cursor-pointer" data-bs-toggle="modal" data-bs-target="#konfirmasiHapusModal"></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $pengajuan->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Modal Pengajuan -->
    <div wire:ignore.self class="modal fade" id="pengajuanModal" tabindex="-1" aria-labelledby="pengajuanModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="margin-top: 150px">
            <div class="modal-content">
                <div class="modal-header flex-column align-items-center">
                    <h5 class="modal-title text-center" id="editPengajuanModalLabel">Tambah Pengajuan</h5>
                    <div style="width: 50%; height: 4px; background-color: var(--bs-primary); margin: 5px auto -2px auto; border-radius: 8px;"></div>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="store">
                        <div class="mb-3">
                            <label for="pelanggan_id" class="form-label">Pelanggan</label>
                            <div class="dropdown">
                                <div class="input-group">
                                    <input type="text" wire:model.live="searchPelanggan" class="form-control" placeholder="Cari Pelanggan..." @if($pelanggan_id) readonly @endif>
                                    @if($pelanggan_id)
                                    <button class="btn btn-danger" type="button" wire:click="resetPelanggan">X</button>
                                    @endif
                                </div>
                                @if(!empty($filteredPelanggan) && !empty($searchPelanggan) && !$pelanggan_id)
                                <div class="dropdown-menu w-100 show" style="max-height: 200px; overflow-y: auto;">
                                    @foreach ($filteredPelanggan as $pelanggans)
                                    <a class="dropdown-item" href="#" wire:click.prevent="selectPelanggan('{{ $pelanggans->pelanggan_id }}', '{{ $pelanggans->nama }}')">
                                        {{ $pelanggans->nama }}
                                    </a>
                                    @endforeach
                                </div>
                                @endif
                                <input type="hidden" wire:model="pelanggan_id">
                            </div>
                            @error('pelanggan_id')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="nama_barang" class="form-label">Nama Barang</label>
                            <input type="text" class="form-control" id="nama_barang" wire:model="nama_barang">
                            @error('nama_barang')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="jumlah" class="form-label">Jumlah</label>
                            <input type="number" class="form-control" id="jumlah" wire:model="jumlah">
                            @error('jumlah')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="modal-footer d-flex gap-2 w-100 px-0">
                            <button type="button" class="btn btn-outline-primary flex-fill" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary flex-fill">Tambah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Pengajuan -->
    <div wire:ignore.self class="modal fade" id="editPengajuanModal" tabindex="-1" aria-labelledby="editPengajuanModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="margin-top: 150px">
            <div class="modal-content">
                <div class="modal-header flex-column align-items-center">
                    <h5 class="modal-title text-center" id="editPengajuanModalLabel">Edit Pengajuan</h5>
                    <div style="width: 50%; height: 4px; background-color: var(--bs-primary); margin: 5px auto -2px auto; border-radius: 8px;"></div>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="update">
                        <input type="hidden" wire:model="pengajuan_id">

                        <div class="mb-3">
                            <label for="edit_nama_pelanggan" class="form-label">Nama Pelanggan</label>
                            <input type="text" class="form-control" id="edit_nama_pelanggan" wire:model="nama" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="edit_nama_barang" class="form-label">Nama Barang</label>
                            <input type="text" class="form-control" id="edit_nama_barang" wire:model="nama_barang">
                            @error('nama_barang')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="edit_jumlah" class="form-label">Jumlah</label>
                            <input type="number" class="form-control" id="edit_jumlah" wire:model="jumlah">
                            @error('jumlah')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="modal-footer d-flex gap-2 w-100 px-0">
                            <button type="button" class="btn btn-outline-primary flex-fill" data-bs-dismiss="modal" wire:click="closeEditModal">Batal</button>
                            <button type="submit" class="btn btn-primary flex-fill">Simpan</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div wire:ignore.self class="modal fade" id="konfirmasiHapusModal" tabindex="-1" aria-labelledby="konfirmasiHapusModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="margin-top: 150px">
            <div class="modal-content">
                <div class="modal-header flex-column align-items-center">
                    <h5 class="modal-title text-center" id="konfirmasiHapusModalLabel">Konfirmasi Hapus</h5>
                    <div style="width: 50%; height: 4px; background-color: var(--bs-primary); margin: 5px auto -2px auto; border-radius: 8px;"></div>
                </div>
                <div class="modal-body d-flex flex-column align-items-center justify-content-center text-center mt-3">
                    <p>Apakah Anda yakin ingin menghapus pengajuan ini?</p>
                </div>
                <div class="modal-footer d-flex gap-1 w-100">
                    <button type="button" class="btn btn-outline-primary flex-fill" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary flex-fill" wire:click="deletePengajuan">Hapus</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        Livewire.on('show-pengajuan-modal', () => {
            var modal = new bootstrap.Modal(document.getElementById('pengajuanModal'));
            modal.show();
        });

        Livewire.on('close-pengajuan-modal', () => {
            var modalElement = document.getElementById('pengajuanModal');
            var modalInstance = bootstrap.Modal.getInstance(modalElement);
            if (modalInstance) {
                modalInstance.hide();
                Livewire.emit('resetForm');
            }
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        Livewire.on('show-edit-modal', () => {
            var modal = new bootstrap.Modal(document.getElementById('editPengajuanModal'));
            modal.show();
        });

        Livewire.on('close-edit-modal', () => {
            var modalElement = document.getElementById('editPengajuanModal');
            var modalInstance = bootstrap.Modal.getInstance(modalElement);
            if (modalInstance) {
                modalInstance.hide();
            }
            document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Livewire.on('close-hapus-modal', () => {
            var modalElement = document.getElementById('konfirmasiHapusModal');
            var modalInstance = bootstrap.Modal.getInstance(modalElement);
            if (modalInstance) {
                modalInstance.hide();
            }
        });
    });
</script>