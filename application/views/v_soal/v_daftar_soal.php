<div class="main-page">
    <div class="container-fluid">
        <div class="row page-title-div">
            <div class="col-sm-6">
                <h2 class="title">DAFTAR SOAL</h2>
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
                    <li>Referensi</li>
                    <li class="active">SOAL</li>
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
                            </div>
                        </div>
                        <div class="panel-body p-20">
                            <a href="#" class="btn btn-primary mb-20" data-toggle="modal" data-target="#modalTambah">
                                <i class="fa fa-plus text-white"></i>
                                Tambah Soal
                            </a>
                            <!-- Modal -->
                            <div class="modal fade" id="modalTambah" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="myModalLabel">Tambahkan Soal Baru <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                                        </div>
                                        <form action="<?= base_url('soal/tambah') ?>" method="POST">
                                            <div class="modal-body">
                                                <input type="text" name="kode_soal" class="form-control" placeholder="Masukan Kode Soal">
                                                <textarea name="mata_pelajaran" class="form-control" placeholder="Masukan Mata Pelajaran"></textarea>
                                            </div>
                                            <div class="modal-footer">
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-gray btn-wide btn-rounded" data-dismiss="modal"><i class="fa fa-times"></i>Batal</button>
                                                    <button type="submit" class="btn bg-success btn-wide btn-rounded"><i class="fa fa-check"></i>Simpan</button>
                                                </div>
                                                <!-- /.btn-group -->
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <table id="dataSiswaIndex" class="display table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Kode Soal</th>
                                        <th class="text-center">Mata Pelajaran</th>
                                        <th class="text-center">Jumlah Soal</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($soal as $s) {
                                    ?>
                                        <tr>
                                            <td class="text-center"><?= $no++ ?></td>
                                            <td><?= $s->kode_soal ?></td>
                                            <td><?= $s->mata_pelajaran ?></td>
                                            <td class="text-center"><?php
                                                                    echo $this->Msoal->getQSoal($s->id)->jml;
                                                                    ?></td>
                                            <td class="text-center" style="min-width: 60px">
                                                <div class="btn-group">
                                                    <a href="<?= base_url('soal/detail/') . $s->id;  ?>" class="btn btn-success"><i class="fa fa-list"></i></a>
                                                    <a href="#" class="btn btn-warning" data-toggle="modal" data-target="#editModal<?= $s->id ?>"><i class="fa fa-edit"></i></a>
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="editModal<?= $s->id ?>" tabindex="-1" role="dialog" aria-labelledby="editModal<?= $s->id ?>">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title" id="editModal<?= $s->id ?>">Ubah Soal<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                                                                </div>
                                                                <form action="<?= base_url('soal/ubah') ?>" method="POST">
                                                                    <div class="modal-body">
                                                                        <textarea name="judul_soal" class="form-control"><?= $s->judul_soal ?></textarea>
                                                                        <input type="hidden" name="id_soal" value="<?= $s->id ?>">
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <div class="btn-group" role="group">
                                                                            <button type="button" class="btn btn-gray btn-wide btn-rounded" data-dismiss="modal"><i class="fa fa-times"></i>Batal</button>
                                                                            <button type="submit" class="btn bg-success btn-wide btn-rounded"><i class="fa fa-check"></i>Simpan</button>
                                                                        </div>
                                                                        <!-- /.btn-group -->
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <a href="<?= base_url('soal/hapus/') . $s->id;  ?>" class="btn btn-danger" onclick="return confirm('Yakin untuk menghapus?')"><i class="fa fa-trash"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php } ?>
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