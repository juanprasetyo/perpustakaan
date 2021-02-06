<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dipinjam</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Buku</a></li>
                        <li class="breadcrumb-item active">Dipinjam</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <?php if($books == NULL): ?>
                <div class="text-center" style="min-height: 100%; min-width: 100%;">
                    <h3>Tidak Ada Buku Dipinjam</h3>
                </div>
                <?php endif ?>
                <?php foreach ($books as $book) : ?>
                <div class="card mx-auto" style="width: 18rem;">
                    <a href="<?= base_url('assets/img/books/').$book['image']; ?>" data-toggle="lightbox">
                        <img src="<?= base_url('assets/img/books/').$book['image']; ?>" class="card-img-top" alt="..." loading="lazy">
                    </a>
                    <div class="card-body">
                        <h5 class="card-title"><?= $book['judul'] ?></h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        <div class="row">
                            <button type="button" class="btn btn-primary btn-return" id="<?= $book['id'] ?>" jumlah="<?= $book['dipinjam'] ?>">Kembalikan</button>
                            <p class="ml-auto">
                                Max : <?= date('d M Y', $book['tanggal_kembalikan']) ?>
                            </p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->