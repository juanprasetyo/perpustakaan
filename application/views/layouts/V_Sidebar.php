<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?= base_url('dashboard') ?>" class="brand-link">
        <img src="<?= base_url('assets/') ?>img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" loading="lazy" style="opacity: .8">
        <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image" id="profile">
                <a data-toggle="modal" data-target="#mdlPreviewImage">
                    <img src="<?= ($user['image'] == 'default_male.png' || $user['image'] == 'default_female.png') ? base_url('assets/img/profile/') . $user['image'] : base_url('assets/img/profile/'). $user['email'] . '/' . $user['image'] ?>" class="img-circle elevation-2" alt="User Image">
                </a>
            </div>
            <div id="profile-dialog"></div>
            <div class="info">
                <a href="#" class="d-block"><?= ucwords($user['name']) ?></a>
                <input type="hidden" class="id-user" value="<?= $user['id'] ?>" name="id-user">
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item <?= $title == 'home' || $title == 'profile' ? '' : 'menu-open' ?>">
                    <a href="#" class="nav-link <?= $title == 'books' || $title == 'pinjam' || $title == 'grafik' ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-book"></i>
                        <p>
                            Buku
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item nav-single">
                            <a href="<?= base_url('books') ?>" class="nav-link <?= $title == 'books' ? 'active' : '' ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Semua Buku</p>
                            </a>
                        </li>
                        <li class="nav-item nav-single">
                            <a href="<?= base_url('pinjam') ?>" class="nav-link <?= $title == 'pinjam' ? 'active' : '' ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Dipinjam</p>
                            </a>
                        </li>
                        <li class="nav-item nav-single">
                            <a href="<?= base_url('grafik') ?>" class="nav-link <?= $title == 'grafik' ? 'active' : '' ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Grafik</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item nav-single">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Widgets
                            <span class="right badge badge-danger">New</span>
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

<!-- Modal -->
<div class="modal fade" id="mdlPreviewImage" data-backdrop="static" data-keyboard="false" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Foto Profile</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center" style="height: 400px;">
                <img src="<?= ($user['image'] == 'default_male.png' || $user['image'] == 'default_female.png') ? base_url('assets/img/profile/') . $user['image'] : base_url('assets/img/profile/'). $user['email'] . '/' . $user['image'] ?>" class="img-circle elevation-2" alt="User Image" loading="lazy" style="height: 100%;">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>