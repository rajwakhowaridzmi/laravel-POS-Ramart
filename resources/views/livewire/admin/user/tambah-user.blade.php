<div>
    <div>
        <div>
            <main id="main" class="main">
                <div class="pagetitle">
                    <h1>Tambah User</h1>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                            <li class="breadcrumb-item">User</li>
                            <li class="breadcrumb-item active">Tambah User</li>
                        </ol>
                    </nav>
                </div><!-- End Page Title -->

                <x-alert type="success" :message="session('success')" />
                <x-alert type="error" :message="session('error')" />

                <section class="section">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Tambah User</h5>

                                    <!-- General Form Elements -->
                                    <form wire:submit.prevent="store">
                                        <div class="row mb-3">
                                            <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="nama" wire:model="nama">
                                                @error('nama')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="email" class="col-sm-2 col-form-label">Email</label>
                                            <div class="col-sm-10">
                                                <input type="email" class="form-control" id="email" wire:model="email">
                                                @error('email')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="password" class="col-sm-2 col-form-label">Password</label>
                                            <div class="col-sm-10">
                                                <div class="input-group">
                                                    <input type="password" class="form-control" id="password" wire:model="password">
                                                    <button class="btn btn-primary" type="button" id="togglePassword">
                                                        <i class="bi bi-eye-slash" id="eyeIcon"></i>
                                                    </button>
                                                </div>
                                                @error('password')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="role" class="col-sm-2 col-form-label">Role</label>
                                            <div class="col-sm-10">
                                                <select class="form-control" id="role" wire:model="role">
                                                    <option value="-">Pilih Role</option>
                                                    <option value="1">Admin</option>
                                                    <option value="0">Kasir</option>
                                                </select>
                                                @error('role')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>


                                        <div class="col-sm-12 text-end">
                                            <a wire:navigate href="/user" class="btn btn-outline-primary">Batal</a>
                                            <button type="submit" class="btn btn-primary">Tambah</button>
                                        </div>

                                    </form><!-- End General Form Elements -->
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </main>
        </div>
    </div>
</div>
<script>
    const togglePassword = document.getElementById("togglePassword");
    const passwordField = document.getElementById("password");
    const eyeIcon = document.getElementById("eyeIcon");

    togglePassword.addEventListener("click", function() {
        // Toggle the type attribute
        const type = passwordField.type === "password" ? "text" : "password";
        passwordField.type = type;

        // Toggle the eye icon
        eyeIcon.classList.toggle("bi-eye");
        eyeIcon.classList.toggle("bi-eye-slash");
    });
</script>