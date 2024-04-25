<div class="main-page">
    <div class="container-fluid">
        <div class="row page-title-div">
            <div class="col-sm-6">
                <h2 class="title">Daftar Test Ujian Sekolah</h2>
                <p class="sub-title">UJIAN - SMKN 1 GARUT</p>
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
                    <li>Ujian Sekolah</li>
                    <li class="active">Daftar Test</li>
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
                                <h5>Daftar Ujian Sekolah</h5>
                            </div>
                        </div>
                        <div class="panel-body p-20">
                            <table id="dataSiswaIndex" class="display table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Kode Soal</th>
                                        <th class="text-center">Mata Pelajaran</th>
                                        <th class="text-center">Durasi</th>
                                        <th class="text-center">Waktu Mulai</th>
                                        <th class="text-center">Waktu Akhir</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1;
                                    foreach ($daftartest as $data) :
                                        $now = date('Y-m-d H:i:s');
                                    ?>
                                        <tr>
                                            <td class="text-center"><?= $no++; ?></td>
                                            <td><?= $data->kode_soal ?></td>
                                            <td><?= $data->mata_pelajaran ?></td>
                                            <td><?= $data->durasi ?></td>
                                            <td><?= $data->start_at ?></td>
                                            <td><?= $data->finish_at ?></td>
                                            <td class="text-center">
                                                <?php

                                                $status_test = $this->Maksespeserta->gettestpeserta($idpeserta, $data->idtest)->row();
                                                if ($status_test) {
                                                    if ($status_test->status_test == 2) {
                                                ?>
                                                        <button class="btn btn-success">Selesai</button>
                                                    <?php } elseif ($status_test->status_test == 1) { ?>
                                                        <a href="<?= base_url('aksespeserta/mulai_test/') . $data->idtest ?>" class="btn btn-warning">Sedang Mengerjakan</a>
                                                    <?php }
                                                } else {
                                                    if ($data->start_at <= $now and $data->finish_at >= $now) {
                                                    ?>
                                                        <a href="<?= base_url('aksespeserta/mulai_test/') . $data->idtest ?>" class="btn btn-info">Mulai</a>
                                                    <?php } else if ($data->start_at >= $now) { ?>
                                                        <button class="btn btn-primary">Belum Mulai</button>
                                                    <?php } else { ?>
                                                        <button class="btn btn-danger">Ditutup</button>
                                                <?php }
                                                } ?>
                                            </td>
                                        </tr>
                                    <?php
                                    endforeach; ?>
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