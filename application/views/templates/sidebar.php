<nav class="mt-2">
  <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <li class="nav-item" >
      <a href="<?= site_url('home')?>" class="nav-link <?= getActiveFunc('home/index') ?>" >
        <i class="nav-icon fas fa-home"></i>
        <p>
          Home
        </p>
      </a>
    </li>
    <li class="nav-item has-treeview">
      <a href="#" class="nav-link <?= getActiveFunc('barang/index') ?>">
        <i class="nav-icon fas fa-table"></i>
        <p>
          Tables
          <i class="fas fa-angle-left right"></i>
        </p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="<?= site_url('barang')?>" class="nav-link <?= getActiveFunc('barang/index') ?>">
            <i class="far fa-circle nav-icon"></i>
            <p>Barang</p>
          </a>
        </li>
      </ul>
    </li>
    <li class="nav-header">EXAMPLES</li>
  </ul>
</nav>