<aside id="sidebar" class="sidebar">

  <ul class="sidebar-nav" id="sidebar-nav">

    <li class="nav-item">
      <a class="nav-link collapsed" wire:navigate href="/dashboard-admin">
        <i class="bi bi-grid"></i>
        <span>Dashboard</span>
      </a>
    </li><!-- End Dashboard Nav -->

    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-journal-text"></i><span>Vendor</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
          <a wire:navigate href="/pemasok">
            <i class="bi bi-circle"></i><span>Daftar Pemasok</span>
          </a>
        </li>
        <li>
          <a wire:navigate href="/tambah-pemasok">
            <i class="bi bi-circle"></i><span>Tambah Pemasok</span>
          </a>
        </li>
      </ul>
    </li><!-- End Forms Nav -->

    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-layout-text-window-reverse"></i><span>Produk</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="tables-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
          <a wire:navigate href="/produk">
            <i class="bi bi-circle"></i><span>Daftar Produk</span>
          </a>
        </li>
        <li>
          <a wire:navigate href="/tambah-produk">
            <i class="bi bi-circle"></i><span>Tambah Produk</span>
          </a>
        </li>
      </ul>
    </li><!-- End Tables Nav -->

    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#charts-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-bar-chart"></i><span>Pelanggan</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="charts-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
          <a wire:navigate href="/pelanggan">
            <i class="bi bi-circle"></i><span>Daftar Pelanggan</span>
          </a>
        </li>
        <li>
          <a wire:navigate href="/tambah-pelanggan">
            <i class="bi bi-circle"></i><span>Tambah Pelanggan</span>
          </a>
        </li>
      </ul>
    </li><!-- End Charts Nav -->

    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-menu-button-wide"></i><span>Pembelian</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
          <a wire:navigate href="/pembelian">
            <i class="bi bi-circle"></i><span>Daftar Pembelian</span>
          </a>
        </li>
        <li>
          <a wire:navigate href="/tambah-pembelian">
            <i class="bi bi-circle"></i><span>Tambah Pembelian</span>
          </a>
        </li>
      </ul>
    </li><!-- End Components Nav -->

    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#icons-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-gem"></i><span>Barang</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="icons-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
          <a wire:navigate href="/barang">
            <i class="bi bi-circle"></i><span>Daftar Barang</span>
          </a>
        </li>
        <li>
          <a wire:navigate href="/tambah-barang">
            <i class="bi bi-circle"></i><span>Tambah Barang</span>
          </a>
        </li>
      </ul>
    </li><!-- End Icons Nav -->

    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#penjualan-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-menu-button-wide"></i><span>Penjualan</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="penjualan-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
          <a wire:navigate href="/penjualan">
            <i class="bi bi-circle"></i><span>Riwayat Penjualan</span>
          </a>
        </li>
        <li>
          <a wire:navigate href="/tambah-penjualan">
            <i class="bi bi-circle"></i><span>Tambah Penjualan</span>
          </a>
        </li>
      </ul>
    </li><!-- End Components Nav -->

    <li class="nav-heading">Laporan</li>

    <li class="nav-item">
      <a class="nav-link collapsed" wire:navigate href="/laporan-barang">
        <i class="bi bi-person"></i>
        <span>Laporan Barang</span>
      </a>
    </li><!-- End Profile Page Nav -->

    <li class="nav-item">
      <a class="nav-link collapsed" href="pages-faq.html">
        <i class="bi bi-question-circle"></i>
        <span>F.A.Q</span>
      </a>
    </li><!-- End F.A.Q Page Nav -->

    <li class="nav-item">
      <a class="nav-link collapsed" href="pages-contact.html">
        <i class="bi bi-envelope"></i>
        <span>Contact</span>
      </a>
    </li><!-- End Contact Page Nav -->

    <li class="nav-item">
      <a class="nav-link collapsed" href="pages-register.html">
        <i class="bi bi-card-list"></i>
        <span>Register</span>
      </a>
    </li><!-- End Register Page Nav -->

    <li class="nav-item">
      <a class="nav-link collapsed" href="pages-login.html">
        <i class="bi bi-box-arrow-in-right"></i>
        <span>Login</span>
      </a>
    </li><!-- End Login Page Nav -->

    <li class="nav-item">
      <a class="nav-link collapsed" href="pages-error-404.html">
        <i class="bi bi-dash-circle"></i>
        <span>Error 404</span>
      </a>
    </li><!-- End Error 404 Page Nav -->

    <li class="nav-item">
      <a class="nav-link " href="pages-blank.html">
        <i class="bi bi-file-earmark"></i>
        <span>Blank</span>
      </a>
    </li><!-- End Blank Page Nav -->

  </ul>

</aside><!-- End Sidebar-->