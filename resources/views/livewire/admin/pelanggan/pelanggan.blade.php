<div>
    @php
    $statusMapping = [
    '0' => 'Nonaktif',
    '1' => 'Aktif'
    ];
    @endphp
    <div>
        <div>
            <main id="main" class="main">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="pagetitle">
                        <h1>Pelanggan</h1>
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                                <li class="breadcrumb-item">Pages</li>
                                <li class="breadcrumb-item active">Blank</li>
                            </ol>
                        </nav>
                    </div>
                    <!-- Alert Success -->
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
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="card-title">Daftar Pelanggan</h5>
                                        <button class="btn btn-primary" wire:navigate href="/tambah-pelanggan">Tambah Pelanggan</button>
                                    </div>
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Kode Pelanggan</th>
                                                <th scope="col">Nama</th>
                                                <th scope="col">Alamat</th>
                                                <th scope="col">Nomor Telpon</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">Status Member</th>
                                                <th scope="col">Total Poin</th>
                                                <th scope="col">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($pelanggans as $index => $pelanggan)
                                            <tr>
                                                <th scope="row">{{ $pelanggans->firstItem() + $index }}</th>
                                                <td>{{ $pelanggan->kode_pelanggan ?? '-'}}</td>
                                                <td>{{ $pelanggan->nama ?? '-'}}</td>
                                                <td>{{ $pelanggan->alamat ?? '-'}}</td>
                                                <td>{{ $pelanggan->no_telp ?? '-'}}</td>
                                                <td>{{ $pelanggan->email ?? '-'}}</td>
                                                <td>{{ $statusMapping[$pelanggan->member_status] ?? '-'}}</td>
                                                <td>{{ $pelanggan->total_poin ?? '-'}}</td>
                                                <td class="d-flex align-items-center gap-2">
                                                    <a wire:navigate href="/edit-pelanggan/{{ $pelanggan->pelanggan_id}}" class="bi bi-pencil-square fs-3"></a>
                                                    <a wire:click="confirmDelete('{{ $pelanggan->pelanggan_id }}')" class="bi bi-trash fs-3 cursor-pointer" data-bs-toggle="modal" data-bs-target="#konfirmasiHapusModal"></a>
                                                    <a wire:click="confirmToggleStatus('{{ $pelanggan->pelanggan_id }}')" class="btn btn-sm {{ $pelanggan->member_status == '1' ? 'btn-danger' : 'btn-success' }}">
                                                        {{ $pelanggan->member_status == '1' ? 'Nonaktifkan' : 'Aktifkan' }}
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="">
                                        {{ $pelanggans->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </main>
            <div wire:ignore.self class="modal fade" id="konfirmasiHapusModal" tabindex="-1" aria-labelledby="konfirmasiHapusModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-md" style="margin-top: 150px">
                    <div class="modal-content">
                        <div class="modal-header flex-column align-items-center">
                            <h5 class="modal-title text-center" id="konfirmasiHapusModalLabel">Konfirmasi Hapus</h5>
                            <div style="width: 50%; height: 4px; background-color: var(--bs-primary); margin: 5px auto -2px auto; border-radius: 8px;"></div>
                        </div>
                        <div class="modal-body d-flex flex-column align-items-center justify-content-center text-center mt-3">
                            <p>Apakah Anda yakin ingin Menghapus data ini?</p>
                        </div>

                        <div class="modal-footer d-flex justify-content-center gap-1">
                            <button type="button" class="btn btn-outline-primary flex-fill" data-bs-dismiss="modal">Tidak</button>
                            <button type="button" class="btn btn-primary flex-fill" wire:click="delete()">Hapus</button>
                        </div>
                    </div>
                </div>
            </div>

            <div wire:ignore.self class="modal fade" id="toggleStatusModal" tabindex="-1" aria-labelledby="toggleStatusModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-md" style="margin-top: 150px;">
                    <div class="modal-content">
                        <div class="modal-header flex-column align-items-center">
                            <h5 class="modal-title text-center" id="toggleStatusModalLabel">Konfirmasi Ubah Status</h5>
                            <div style="width: 50%; height: 4px; background-color: var(--bs-primary); margin: 5px auto -2px auto; border-radius: 8px;"></div>
                        </div>
                        <div class="modal-body d-flex flex-column align-items-center justify-content-center text-center mt-3">
                            <p>Apakah Anda yakin untuk merubah status ini?</p>
                        </div>

                        <div class="modal-footer d-flex justify-content-center gap-1">
                            <button type="button" class="btn btn-outline-primary flex-fill" data-bs-dismiss="modal">Tidak</button>
                            <button type="button" class="btn btn-primary flex-fill" wire:click="toggleMemberStatus()">Yakin</button>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        Livewire.on('closeModal', () => {
            var modalElement = document.getElementById('konfirmasiHapusModal');
            var modalInstance = bootstrap.Modal.getInstance(modalElement);
            if (modalInstance) {
                modalInstance.hide();
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        Livewire.on('closeModal', () => {
            let modalElement = document.getElementById('toggleStatusModal');
            let modalInstance = bootstrap.Modal.getInstance(modalElement);
            if (modalInstance) {
                modalInstance.hide();
            }
        });

        window.addEventListener('showToggleStatusModal', () => {
            let modalElement = new bootstrap.Modal(document.getElementById('toggleStatusModal'));
            modalElement.show();
        });
    });
</script>