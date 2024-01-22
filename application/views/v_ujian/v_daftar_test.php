<div class="main-page">
    <div class="container-fluid">
        <div class="row page-title-div">
            <div class="col-sm-6">
                <h2 class="title">Daftar Test Ujian Sekolah</h2>
                <p class="sub-title">UJIAN - SMK NEGERI 1 GARUT</p>
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
                            <div class="btn-group">
                                <a href="<?= base_url('welcome')  ?>" class="btn btn-warning mb-20">
                                    <i class="fa fa-arrow-left text-white"></i>
                                    Kembali
                                </a>
                                <button type="button" class="btn btn-info btn-animated btn-wide" data-toggle="modal" data-target="#modalTambah">
                                    <span class="visible-content">Jadwalkan Test</span>
                                    <span class="hidden-content"><i class="fa fa-plus"></i></span>
                                </button>
                            </div>
                            <!-- Modal -->
                            <div class="modal fade" id="modalTambah" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="myModalLabel">Tambah Test<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                                        </div>
                                        <form action="<?= base_url('test/prosestest') ?>" method="POST">
                                            <div class="panel-body">
                                                <div class="col-md-12">
                                                    <i>( * ) Wajib di Isi</i>
                                                    <div class="form-group has-feedback">
                                                        <label for="username5">Pilih Soal</label>
                                                        <?php
                                                        $ds = $this->db->get('tb_soal')->result();
                                                        ?>
                                                        <select class="form-control" name="id_soal">
                                                            <?php
                                                            foreach ($ds as $data) {
                                                            ?>
                                                                <option value="<?= $data->id ?>"><?= $data->judul_soal ?></option>
                                                            <?php }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group has-feedback">
                                                        <label for="name5">Jadwalkan Untuk Semua Ruang dan Rombel</label>
                                                        <input type="checkbox" class="js-switch-warning" name="semua_ruang" value="1">
                                                    </div>
                                                    <div class="form-group has-feedback">
                                                        <label for="username5">Ruang</label>
                                                        <?php
                                                        $dr = $this->db->get('tb_ruang')->result();
                                                        ?>
                                                        <select class="form-control" name="ruang">
                                                            <?php
                                                            foreach ($dr as $data) {
                                                            ?>
                                                                <option value="<?= $data->ruang ?>"><?= $data->ruang ?></option>
                                                            <?php }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group has-feedback">
                                                        <label for="username5">Rombel</label>
                                                        <?php
                                                        $dr = $this->db->get('tb_rombel')->result();
                                                        ?>
                                                        <select class="form-control" name="rombel">
                                                            <?php
                                                            foreach ($dr as $data) {
                                                            ?>
                                                                <option value="<?= $data->rombel ?>"><?= $data->rombel ?></option>
                                                            <?php }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group has-feedback">
                                                        <label for="name5">Durasi*</label>
                                                        <input type="time" name="durasi" class="form-control" required>
                                                    </div>
                                                    <div class="form-group has-feedback">
                                                        <label for="name5">Waktu Mulai*</label>
                                                        <div class="col-md-6">
                                                            <input type="date" name="date_start_at" class="form-control" required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="time" name="time_start_at" class="form-control" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group has-feedback">
                                                        <label for="name5">Waktu Selesai (Ditutup)</label>
                                                        <div class="col-md-6">
                                                            <input type="date" name="date_finish_at" class="form-control" required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="time" name="time_finish_at" class="form-control" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group has-feedback">
                                                        <label for="name5">Random Soal</label>
                                                        <input type="checkbox" class="js-switch-warning" name="random_soal" value="1">
                                                    </div>
                                                    <div class="form-group has-feedback">
                                                        <label for="name5">Random Jawaban</label>
                                                        <input type="checkbox" class="js-switch-warning" name="random_jawaban" value="1">
                                                    </div>
                                                    <div class="form-group has-feedback">
                                                        <button type="Submit" class="btn btn-success btn-labeled">
                                                            <i class="fa fa-save"></i> Simpan Data Jadwal
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <table id="dataSiswaIndex" class="display table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Mata Pelajaran</th>
                                        <th class="text-center">Ruang</th>
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
                                            <td><?= $data['ruang'] ?></td>
                                            <td><?= $data['rombel'] ?></td>
                                            <td><?= $data['durasi'] ?></td>
                                            <td><?= $data['start_at'] ?></td>
                                            <td><?= $data['finish_at'] ?></td>
                                            <td style="min-width: 110px">
                                                <div class="btn-group">
                                                    <a href="<?= base_url('test/list_test/') . $data['idtest'] ?>" class="btn btn-success"><i class="fa fa-list"></i></a>
                                                    <a href="<?= base_url('test/ubah_test/') . $data['idtest'] ?>" class="btn btn-warning"><i class="fa fa-pencil"></i></a>
                                                    <a href="<?= base_url('test/hapus_test/') . $data['idtest'] ?>" class="btn btn-danger" onclick="return confirm('Yakin untuk menghapus?')"><i class="fa fa-trash"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
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