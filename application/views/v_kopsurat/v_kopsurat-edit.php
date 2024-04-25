<div class="main-page">
    <div class="container-fluid bg-white">
        <div class="row page-title-div">
            <div class="col-sm-6">
                <h2 class="title">Edit Kop Surat</h2>
                <p class="sub-title">UJIAN - SMKN 1 GARUT</p>
            </div>
            <div class="row">
                <div class="col-lg-9">
                    <?= $this->session->flashdata('alert'); ?>
                </div>
            </div>
        </div>
        <form method="post" action="<?= base_url('kopsurat/edt_process')  ?>" enctype="multipart/form-data">
            <div class="row panel">
                <div class="panel-body">
                    <div class="col-md-12">
                        <i>( * ) Wajib di Isi</i>

                        <div class="form-group has-feedback">
                            <img src="<?= base_url() ?>assets/img/kop/<?= $kopsurat->logo_kiri ?>" width="100px">
                            <label for="exampleInputPassword5">Logo Kiri</label>
                            <input type="hidden" name="logo_kiri_lama" value="<?= $kopsurat->logo_kiri ?>">
                            <input type="file" class="form-control" name="logo_kiri">
                            <span class="glyphicon glyphicon-user form-control-feedback"></span>
                            <span class="help-block">Kosongkan jika tidak ingin merubah Logo</span>
                        </div>
                        <div class="form-group has-feedback">
                            <label for="name5">Identitas</label>
                            <textarea class="form-control" name="isi"><?= $kopsurat->isi ?></textarea>
                            <span class="fa fa-pencil form-control-feedback"></span>
                            <span class="help-block">Isi Identitas pada KOP Surat</span>
                        </div>
                        <div class="form-group has-feedback">
                            <img src="<?= base_url() ?>assets/img/kop/<?= $kopsurat->logo_kanan ?>" width="100px">
                            <label for="exampleInputPassword5">Logo Kanan</label>
                            <input type="hidden" name="logo_kanan_lama" value="<?= $kopsurat->logo_kanan ?>">
                            <input type="file" class="form-control" name="logo_kanan">
                            <span class="glyphicon glyphicon-user form-control-feedback"></span>
                            <span class="help-block">Kosongkan jika tidak ingin merubah Logo</span>
                        </div>
                        <div class="form-group has-feedback">
                            <a href="<?= base_url('kopsurat') ?>" class="btn btn-primary btn-labeled"><i class="fa fa-arrow-left"></i>Kembali</a>
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