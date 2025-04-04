<div>
    <div>
        <div>
            <main id="main" class="main">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="pagetitle">
                        <h1>Penjualan</h1>
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
                                        <h5 class="card-title">Daftar Penjualan</h5>
                                        <button class="btn btn-primary" wire:navigate href="/tambah-penjualan">Tambah Penjualan</button>
                                    </div>
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Nomor Faktur</th>
                                                <th scope="col">Tanggal</th>
                                                <th scope="col">Total Bayar</th>
                                                <th scope="col">Pelanggan</th>
                                                <th scope="col">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($penjualan as $loopIndex => $penjualans)
                                            <tr>
                                                <th scope="row">{{ $penjualan->firstItem() +$loopIndex }}</th>
                                                <td>{{ $penjualans->no_faktur ?? '-'}}</td>
                                                <td>{{ $penjualans->tgl_faktur ?? '-'}}</td>
                                                <td>{{ $penjualans->total_bayar ?? '-'}}</td>
                                                <td>{{ $penjualans->pelanggan->nama ?? '-'}}</td>
                                                <td>
                                                    <a wire:navigate href="/detail-penjualan/{{ $penjualans->penjualan_id}}" class="bi bi-pencil-square fs-3"></a>
                                                </td>
                                            </tr>
                                            @endforeach 
                                        </tbody>
                                    </table>
                                    {{ $penjualan->links() }}
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
</script>