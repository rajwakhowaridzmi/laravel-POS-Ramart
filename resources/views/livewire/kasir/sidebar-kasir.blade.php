<aside id="sidebar" class="sidebar">

  <ul class="sidebar-nav" id="sidebar-nav">

    <li class="nav-item">
      <a class="nav-link collapsed" wire:navigate href="/kasir/dashboard">
        <i class="bi bi-grid"></i>
        <span>Dashboard Kasir</span>
      </a>
    </li><!-- End Dashboard Nav -->

    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-menu-button-wide"></i><span>Penjualan</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
          <a wire:navigate href="/kasir/penjualan">
            <i class="bi bi-circle"></i><span>Riwayat Penjualan</span>
          </a>
        </li>
        <li>
          <a wire:navigate href="/kasir/tambah-penjualan">
            <i class="bi bi-circle"></i><span>Tambah Penjualan</span>
          </a>
        </li>
      </ul>
    </li><!-- End Components Nav -->

    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-journal-text"></i><span>Pelanggan</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
          <a wire:navigate href="/kasir/pelanggan">
            <i class="bi bi-circle"></i><span>Daftar Pelanggan</span>
          </a>
        </li>
        <li>
          <a wire:navigate href="/kasir/tambah-pelanggan">
            <i class="bi bi-circle"></i><span>Tambah Pelanggan</span>
          </a>
        </li>
      </ul>
    </li><!-- End Forms Nav -->

    <li class="nav-heading">Pages</li>

    <li class="nav-item">
      <a class="nav-link collapsed" wire:navigate href="/kasir/pengajuan">
        <i class="bi bi-person"></i>
        <span>Pengajuan</span>
      </a>
    </li><!-- End Profile Page Nav -->

    <!-- End Blank Page Nav -->

  </ul>

</aside><!-- End Sidebar-->