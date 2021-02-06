<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Profile</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">User Profile</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="row">
                        <div class="col-lg-4 d-flex justify-content-center align-items-center">
                            <img src="<?= ($user['image'] == 'default_male.png' || $user['image'] == 'default_female.png') ? base_url('assets/img/profile/') . $user['image'] : base_url('assets/img/profile/'). $user['email'] . '/' . $user['image'] ?>" id="profile-image" alt="" loading="lazy" srcset="" style="width: 100%;">
                        </div>
                        <div class="col-lg-8">
                            <!-- <form method="post" action="<?= base_url('editProfile') ?>"> -->
                            <?php echo form_open_multipart('editProfile');?>
                            <input type="hidden" class="id-user" value="<?= $user['id'] ?>" name="id-user">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="inputNama">Nama</label>
                                    <input type="text" class="form-control" id="inputNama" name="inputNama" value="<?= $user['name'] ?>" required>
                                    <?= form_error('inputNama', '<small class="text-danger">', '</small>') ?>
                                    <div class="text-danger small"><?= form_error('nama') ?></div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail">Email address</label>
                                    <input type="email" class="form-control" id="inputEmail" name="inputEmail" value="<?= $user['email'] ?>" readonly required>
                                    <?= form_error('inputEmail', '<small class="text-danger">', '</small>') ?>
                                </div>
                                <div class="form-group">
                                    <label for="inputPhone">No Handphone</label>
                                    <input type="number" class="form-control" id="inputPhone" name="inputPhone" value="<?= $user['phone'] ?>" placeholder="08xxxxxxxxxx" max="9999999999999" required>
                                </div>
                                <div class="form-group">
                                    <label for="inputAddress">Alamat</label>
                                    <input type="text" class="form-control" id="inputAddress" name="inputAddress" value="<?= $user['address'] ?>" placeholder="Masukkan Nama Kota Anda" required>
                                </div>
                                <div class="text-danger small"><?= form_error('inputAddreess') ?></div>
                                <div class="form-group">
                                    <label for="inputImage">Foto Profile</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="inputImage" id="inputImage">
                                            <label class="custom-file-label" for="inputImage">Choose file</label>
                                        </div>
                                        <input type="hidden" value="<?= $user['image'] ?>" name="old-image">
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary btn-editProfile">Save Changes</button>
                            </div>
                            <?php echo form_close(); ?>
                            <!-- </form> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>