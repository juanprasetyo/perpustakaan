<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Semua Buku</h1>
                    <a class="btn btn-primary" data-toggle="modal" data-target="#mdlAddBook">
                        <i class="fas fa-plus"></i>
                    </a>
                </div><!-- /.col -->
                <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#staticBackdrop">
                    Launch static backdrop modal
                </button> -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Buku</a></li>
                        <li class="breadcrumb-item active">Semua Buku</li>
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
                <?php foreach ($books as $book) : ?>
                <div class="card mx-auto" style="width: 18rem;">
                    <a href="<?= base_url('assets/img/books/').$book['image']; ?>" class="progressive replace" data-toggle="lightbox" data-title="<?= $book['judul'] ?>" data-footer="Karya <?= $book['penulis'] ?>">
                        <img src="<?= base_url('assets/img/books-preview/').$book['image']; ?>" class="preview card-img-top" alt="...">
                    </a>
                    <div class="card-body">
                        <h5 class="card-title"><?= $book['judul'] ?></h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        <div class="row">
                            <button type="button" class="btn btn-primary btn-pinjam" id="<?= $book['id'] ?>" jumlah="<?= $book['dipinjam'] ?>" <?= $book['jumlah'] - $book['dipinjam'] == 0 ? 'disabled': '' ?>>Pinjam</button>
                            <h6 class="ml-auto">Buku Tersedia : <?=' '. $book['jumlah'] - $book['dipinjam'] ?></h6>
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

<!-- Modal -->
<div class="modal fade" id="mdlAddBook" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel"><i class="fas fa-book mx-1"></i> Tambah Buku Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="max-height: 400px">
                <form id="add-book">
                    <div class="form-group">
                        <label for="inputBookName">Nama Buku</label>
                        <input type="text" class="form-control" id="inputBookName" name="inputBookName" required autofocus>
                    </div>
                    <div class="form-group">
                        <label for="inputBookWriter">Penulis</label>
                        <input type="text" class="form-control" id="inputBookWriter" name="inputBookWriter" required>
                    </div>
                    <div class="form-group">
                        <label for="inputBookPublisher">Penerbit</label>
                        <input type="text" class="form-control" id="inputBookPublisher" name="inputBookPublisher" required>
                    </div>
                    <div class="form-group">
                        <label for="inputNumberOfBooks">Jumlah</label>
                        <input type="number" class="form-control" id="inputNumberOfBooks" name="inputNumberOfBooks" min="1" max="99" required>
                    </div>
                    <div class="form-group">
                        <label for="inputImageBook">Sampul</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="inputImageBook" id="inputImageBook">
                                <label class="custom-file-label" for="inputImageBook" name="inputImageBook" required>Choose file</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="inputCheckBook" name="inputCheckBook">
                        <label class="form-check-label" for="inputCheckBook">Saya benar-benar bertanggung jawab atas data buku yang saya tambahkan ini.</label>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary btn-addBook" disabled>Save</button>
            </div>
            </form>
        </div>
    </div>
</div>