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
                            <div class="panel-title">
                                <h5>Ubah Daftar Test</h5>
                            </div>
                            <form action="<?= base_url('test/prosestest') ?>" method="POST">
                                <div class="row panel">
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
                                                        <option value="<?= $data->id ?>" <?php if ($daftartest->id_soal == $data->id) {
                                                                                                echo "selected";
                                                                                            } ?>><?= $data->judul_soal ?></option>
                                                    <?php }
                                                    ?>
                                                </select>
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
                                                        <option value="<?= $data->ruang ?>" <?php if ($daftartest->ruang == $data->ruang) {
                                                                                                echo "selected";
                                                                                            } ?>><?= $data->ruang ?></option>
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
                                                        <option value="<?= $data->rombel ?>" <?php if ($daftartest->rombel == $data->rombel) {
                                                                                                    echo "selected";
                                                                                                } ?>><?= $data->rombel ?></option>
                                                    <?php }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group has-feedback">
                                                <label for="name5">Durasi*</label>
                                                <input type="time" name="durasi" class="form-control" required value="<?= $daftartest->durasi ?>">
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
                                </div>
                            </form>
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