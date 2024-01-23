<div class="main-page">
    <div class="container-fluid bg-white">
        <div class="row page-title-div">
            <div class="col-sm-6">
                <h2 class="title">Edit Data Asesi</h2>
                <p class="sub-title">UJIAN - SMKS YPPT GARUT</p>
            </div>
            <div class="row">
                <div class="col-lg-9">
                    <?= $this->session->flashdata('alert'); ?>
                </div>
            </div>
        </div>
        <form method="post" action="<?= base_url('asesi/edt_process')  ?>" enctype="multipart/form-data">
            <div class="row panel">
                <div class="panel-body">
                    <div class="col-md-12">
                        <i>( * ) Wajib di Isi</i>
                        <div class="form-group has-feedback">
                            <label for="username5">Tahun Aktif*</label>
                            <select name="tahun_aktif" class="form-control">
                                <?php
                                foreach ($tahunaktif as $ta) :
                                ?>
                                    <option value="<?= $ta['tahun_aktif'] ?>" <?php if ($dataasesi['tahun_aktif'] == $ta['tahun_aktif']) {
                                                                                    echo "selected";
                                                                                } ?>><?= $ta['tahun_aktif'] ?></option>
                                <?php
                                endforeach;
                                ?>
                            </select>
                            <span class="help-block">Pilih Tahun Aktif</span>
                        </div>
                        <div class="form-group has-feedback">
                            <label for="username5">No Peserta*</label>
                            <input type="hidden" class="form-control" name="id" value="<?= $idasesi ?>">
                            <input type="hidden" class="form-control" name="foto_lama" value="<?= $dataasesi['foto'] ?>">
                            <input type="text" class="form-control" name="no_peserta" value="<?= $dataasesi['no_peserta'] ?>" required autofocus>
                            <input type="text" class="form-control" name="id_user" value="<?= $dataasesi['id_user'] ?>" required autofocus>
                            <span class="fa fa-graduation-cap form-control-feedback"></span>
                            <span class="help-block">Masuk Nomor Peserta</span>
                        </div>
                        <div class="form-group has-feedback">
                            <label for="name5">Nama Lengkap*</label>
                            <input type="text" class="form-control" name="nama" value="<?= $dataasesi['nama'] ?>" required>
                            <span class="fa fa-pencil form-control-feedback"></span>
                            <span class="help-block">Masukkan nama Asesi</span>
                        </div>
                        <div class="form-group has-feedback">
                            <label for="name5">Kelas*</label>
                            <input type="text" class="form-control" name="kelas" value="<?= $dataasesi['kelas'] ?>" required>
                            <span class="fa fa-pencil form-control-feedback"></span>
                            <span class="help-block">Masukkan kelas Asesi</span>
                        </div>
                        <div class="form-group has-feedback">
                            <img src="<?= base_url() ?>assets/img/asesi/<?= $dataasesi['foto'] ?>" width="100px">
                            <label for="exampleInputPassword5">Foto</label>
                            <input type="file" class="form-control" name="foto">
                            <span class="glyphicon glyphicon-user form-control-feedback"></span>
                            <span class="help-block">Kosongkan jika tidak ingin merubah Foto</span>
                        </div>
                        Akun Asesi
                        <div class="form-group has-feedback">
                            <label for="name5">Nama Pengguna*</label>
                            <input type="text" class="form-control" name="username" value="<?= $dataasesi['username'] ?>" required>
                            <span class="fa fa-user form-control-feedback"></span>
                            <span class="help-block">Masukan Nama Pengguna</span>
                        </div>
                        <div class="form-group has-feedback">
                            <label for="name5">Kata Sandi*</label>
                            <input type="password" class="form-control" name="password">
                            <span class="fa fa-key form-control-feedback"></span>
                            <span class="help-block">Kosongkan jika tidak ingin merubah Kata Sandi</span>
                        </div>
                        <div class="form-group has-feedback">
                            <label for="name5">Konfirmasi Kata Sandi*</label>
                            <input type="password" class="form-control" name="password2">
                            <span class="fa fa-key form-control-feedback"></span>
                            <span class="help-block">Masukan Lagi Kata Sandi</span>
                        </div>
                        <div class="form-group has-feedback">
                            <a href="<?= base_url('asesi') ?>" class="btn btn-primary btn-labeled"><i class="fa fa-arrow-left"></i>Kembali</a>
                            <button type="Submit" class="btn btn-warning btn-labeled">
                                <i class="fa fa-save"></i> Simpan Data Asesi
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