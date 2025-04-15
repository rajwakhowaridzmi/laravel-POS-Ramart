<div class="card mb-3">
    <div class="card-body">
        <div class="pt-4 pb-2">
            <h5 class="card-title text-center pb-0 fs-4">Login ke Ramart</h5>
            <p class="text-center small">Masukkan Email & Password untuk Login</p>
        </div>


        <form wire:submit.prevent="login" class="row g-3 needs-validation" novalidate>
            <div class="col-12">
                <label for="yourUsername" class="form-label">Email</label>
                <input type="text"
                       wire:model.lazy="email"
                       class="form-control @if($error) is-invalid animate__animated animate__shakeX @endif"
                       id="yourUsername"
                       required>
                <div class="invalid-feedback">
                    Email salah atau tidak ditemukan.
                </div>
            </div>

            <div class="col-12">
                <label for="yourPassword" class="form-label">Password</label>
                <input type="password"
                       wire:model.lazy="password"
                       class="form-control @if($error) is-invalid animate__animated animate__shakeX @endif"
                       id="yourPassword"
                       required>
                <div class="invalid-feedback">
                    Password salah.
                </div>
            </div>

            <div class="col-12">
                <button class="btn btn-primary w-100" type="submit">Login</button>
            </div>
        </form>
    </div>
</div>
x