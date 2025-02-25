<div class="card mb-3">

    <div class="card-body">

        <div class="pt-4 pb-2">
            <h5 class="card-title text-center pb-0 fs-4">Login ke Ramart</h5>
            <p class="text-center small">Masukan Nama & Password untuk Login</p>
        </div>

        <form wire:submit.prevent="login" class="row g-3 needs-validation" novalidate>
            <div class="col-12">
                <label for="yourUsername" class="form-label">Username</label>
                <div class="input-group has-validation">
                    <input type="text" wire:model="nama" class="form-control" id="yourUsername" required>
                    <div class="invalid-feedback">Please enter your username.</div>
                </div>
            </div>

            <div class="col-12">
                <label for="yourPassword" class="form-label">Password</label>
                <input type="password" wire:model="password" class="form-control" id="yourPassword" required>
                <div class="invalid-feedback">Please enter your password!</div>
            </div>

            <div class="col-12">
                <button class="btn btn-primary w-100" type="submit">Login</button>
            </div>
        </form>

    </div>
</div>