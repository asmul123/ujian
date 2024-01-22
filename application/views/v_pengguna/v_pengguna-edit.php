<div class="main-page">
    <div class="container-fluid bg-white">
        <div class="row page-title-div">
            <div class="col-sm-6">
                <h2 class="title">Ubah Data Pengguna</h2>
                <p class="sub-title">UJIAN - SMK NEGERI 1 GARUT</p>
            </div>
            <div class="row">
                <div class="col-lg-9">
                    <?= $this->session->flashdata('alert'); ?>
                </div>
            </div>
        </div>
        <form method="post" action="<?= base_url('pengguna/edt_process')  ?>" enctype="multipart/form-data">
            <div class="row panel">
                <div class="panel-body">
                    <div class="col-md-12">
                        Akun Pengguna
                        <div class="form-group has-feedback">
                            <label for="name5">Nama Lengkap*</label>
                            <input type="hidden" name="id" value="<?= $datapengguna['id'] ?>">
                            <input type="text" class="form-control" name="nama" value="<?= $datapengguna['nama'] ?>" required autofocus>
                            <span class="fa fa-user form-control-feedback"></span>
                            <span class="help-block">Masukan Nama Pengguna</span>
                        </div>
                        <div class="form-group has-feedback">
                            <label for="name5">Nama Pengguna*</label>
                            <input type="text" class="form-control" name="username" value="<?= $datapengguna['username'] ?>" required>
                            <span class="fa fa-user form-control-feedback"></span>
                            <span class="help-block">Masukan Nama Pengguna</span>
                        </div>
                        <div class="form-group has-feedback">
                            <label for="name5">Kata Sandi</label>
                            <input type="password" class="form-control" name="password">
                            <span class="fa fa-key form-control-feedback"></span>
                            <span class="help-block">Kosongkan jika tidak ingin merubah Kata Sandi</span>
                        </div>
                        <div class="form-group has-feedback">
                            <label for="name5">Konfirmasi Kata Sandi</label>
                            <input type="password" class="form-control" name="password2">
                            <span class="fa fa-key form-control-feedback"></span>
                            <span class="help-block">Masukan Lagi Kata Sandi</span>
                        </div>
                        <div class="form-group has-feedback">
                            <label for="name5">Level Pengguna</label>
                            <select name="user_level" class="form-control">
                                <?php $levelpengguna = $this->Mpengguna->getlevelpengguna();
                                foreach ($levelpengguna as $lv) :
                                ?>
                                    <option value="<?= $lv->id ?>" <?php if ($datapengguna['user_level'] == $lv->id) {
                                                                        echo "selected";
                                                                    } ?>><?= $lv->userlevel ?></option>
                                <?php endforeach; ?>
                            </select>
                            <span class="fa fa-key form-control-feedback"></span>
                            <span class="help-block">Pilih Level Pengguna</span>
                        </div>
                        <div class="form-group has-feedback">
                            <a href="<?= base_url('pengguna') ?>" class="btn btn-primary btn-labeled"><i class="fa fa-arrow-left"></i>Kembali</a>
                            <button type="Submit" class="btn btn-warning btn-labeled">
                                <i class="fa fa-save"></i> Simpan Data Pengguna
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!-- /.row -->
    </div>
</div>
<!-- /.main-page -->
<!-- /.right-sidebar -->
</div>
<!-- /.content-container -->
</div>