<div>
    <div>
        <div>
            <main id="main" class="main">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="pagetitle">
                        <h1>Daftar Produk</h1>
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                                <li class="breadcrumb-item">Pages</li>
                                <li class="breadcrumb-item active">Blank</li>
                            </ol>
                        </nav>
                    </div>
                    <!-- Alert -->
                    <x-alert type="success" :message="session('success')" />
                    <x-alert type="error" :message="session('error')" />
                </div>

                <section class="section">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="card-title">Produk</h5>
                                        <button wire:click="showTambahProdukModal" class="btn btn-primary">Tambah Produk</button>

                                    </div>
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Nama Produk</th>
                                                <th scope="col">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($produk as $loopIndex => $produks)
                                            <tr>
                                                <th scope="row">{{ $produk->firstItem() + $loopIndex }}</th>
                                                <td>{{ $produks->nama_produk ?? '-'}}</td>
                                                <td>
                                                    <a wire:click="editProduk('{{ $produks->produk_id }}')" class="bi bi-pencil-square fs-3"></a>
                                                    <a wire:click="confirmDelete('{{ $produks->produk_id }}')" class="bi bi-trash fs-3 cursor-pointer" data-bs-toggle="modal" data-bs-target="#konfirmasiHapusModal"></a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    {{ $produk->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </main>
            <!-- Modal Tambah Produk -->
            <div wire:ignore.self class="modal fade" id="tambahProdukModal" tabindex="-1" aria-labelledby="tambahProdukModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-md" style="margin-top: 150px;">
                    <div class="modal-content">
                        <form wire:submit.prevent="store">
                            <div class="modal-header">
                                <h5 class="modal-title" id="tambahProdukModalLabel">Tambah Produk</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="nama_produk" class="form-label">Nama Produk</label>
                                    <input type="text" class="form-control @error('nama_produk') is-invalid @enderror" id="nama_produk" wire:model.defer="nama_produk">
                                    @error('nama_produk') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal Edit Produk -->
            <div wire:ignore.self class="modal fade" id="editProdukModal" tabindex="-1" aria-labelledby="editProdukModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-md" style="margin-top: 150px;">
                    <div class="modal-content">
                        <div class="modal-header flex-column align-items-center">
                            <h5 class="modal-title text-center" id="editProdukModalLabel">Edit Produk</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                        </div>
                        <div class="modal-body">
                            <form wire:submit.prevent="update">
                                <div class="mb-3">
                                    <label for="nama_produk" class="form-label">Nama Produk</label>
                                    <input type="text" class="form-control @error('nama_produk') is-invalid @enderror" id="nama_produk" wire:model.defer="nama_produk">
                                    @error('nama_produk') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                        </div>
                        <div class="modal-footer d-flex gap-2 w-100">
                            <button type="button" class="btn btn-outline-primary flex-fill" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary flex-fill">Simpan</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>

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
        // Event untuk menutup semua modal dan menghapus backdrop
        Livewire.on('closeModal', () => {
            // Menutup semua modal
            ['konfirmasiHapusModal', 'tambahProdukModal', 'editProdukModal'].forEach(id => {
                const modalElement = document.getElementById(id);
                const modalInstance = bootstrap.Modal.getInstance(modalElement);
                if (modalInstance) {
                    modalInstance.hide(); // Menutup modal
                }
            });

            // Menghapus backdrop secara eksplisit jika ada
            const backdropElements = document.querySelectorAll('.modal-backdrop');
            backdropElements.forEach(backdrop => {
                backdrop.classList.remove('show'); // Menghapus class 'show' pada backdrop
                backdrop.style.display = 'none'; // Menyembunyikan backdrop
            });

            document.body.classList.remove('modal-open');
        });

        Livewire.on('openEditModal', () => {
            const modal = new bootstrap.Modal(document.getElementById('editProdukModal'));
            modal.show();
        });

        Livewire.on('openTambahModal', () => {
            const modal = new bootstrap.Modal(document.getElementById('tambahProdukModal'));
            modal.show();
        });
    });
</script>