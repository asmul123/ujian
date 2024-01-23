<div class="main-page">
    <div class="container-fluid">
        <div class="row page-title-div">
            <div class="col-sm-6">
                <h2 class="title">Kop Surat</h2>
                <p class="sub-title">UJIAN - SMKS YPPT GARUT</p>
            </div>
            <!-- /.col-sm-6 -->
            <!-- <div class="col-sm-6 right-side">
                <a class="btn bg-black toggle-code-handle tour-four" role="button">Toggle Code!</a>
            </div> -->
            <!-- /.col-sm-6 text-right -->
        </div>
        <!-- /.row -->
        <div class="row breadcrumb-div">
            <div class="col-sm-6">
                <ul class="breadcrumb">
                    <li><a href="<?php echo base_url('/') ?>"><i class="fa fa-home"></i>Beranda</a></li>
                    <li>Pengaturan</li>
                    <li class="active">Kop Surat</li>
                </ul>
            </div>
            <!-- /.col-sm-6 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
    <section class="section">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-9">
                    <?= $this->session->flashdata('alert'); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h5>Kop Surat</h5>
                            </div>
                        </div>
                        <div class="panel-body p-20">

                            <table id="dataSiswaIndex" class="display table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">Logo Kiri</th>
                                        <th class="text-center">Identitas</th>
                                        <th class="text-center">Logo Kanan</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-center"><img src="<?= base_url() ?>assets/img/kop/<?= $kopsurat->logo_kiri ?>" width="100px" )></td>
                                        <td class="text-center"><?= $kopsurat->isi; ?></td>
                                        <td class="text-center"><img src="<?= base_url() ?>assets/img/kop/<?= $kopsurat->logo_kanan ?>" width="100px" )></td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <a href="<?= base_url('kopsurat/ubah') ?>" class="btn btn-warning"><i class="fa fa-pencil"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.section -->
</div>
</div>
</div>