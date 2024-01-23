<div class="main-page">
    <div class="container-fluid">
        <div class="row page-title-div">
            <div class="col-sm-6">
                <h2 class="title">Daftar Test Ujian Sekolah</h2>
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
                    <li>Referensi</li>
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
                                <h5>Daftar Test Ujian Sekolah</h5>
                            </div>
                        </div>
                        <div class="panel-body p-20">
                            <table id="dataSiswaIndex" class="display table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Mata Pelajaran</th>
                                        <th class="text-center">Rombel</th>
                                        <th class="text-center">Durasi</th>
                                        <th class="text-center">Waktu Mulai</th>
                                        <th class="text-center">Waktu Akhir</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1;
                                    foreach ($daftartest as $data) :
                                    ?>
                                        <tr>
                                            <td class="text-center"><?= $no++; ?></td>
                                            <td><?= $data['judul_soal'] ?></td>
                                            <td><?= $data['rombel'] ?></td>
                                            <td><?= $data['durasi'] ?></td>
                                            <td><?= $data['start_at'] ?></td>
                                            <td><?= $data['finish_at'] ?></td>
                                            <td><a href="<?= base_url('aksespengawas/list_test/') . $data['idtest'] ?>" class="btn btn-success"><i class="fa fa-list"></i> Lihat</a></td>
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