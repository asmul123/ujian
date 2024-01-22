<div class="main-page">
    <div class="container-fluid">
        <div class="row page-title-div">
            <div class="col-sm-6">
                <h2 class="title">Daftar Test Kompetensi Peserta didik</h2>
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
                                <h5>Daftar Test Uji Kompetensi</h5>
                                <table width="100%" cellpadding="4" cellspacing="4" border="1">
                                    <tr>
                                        <td>Nama Paket</td>
                                        <td>:</td>
                                        <td><?= $ujikomdetail["nama_paket"] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Judul Skema</td>
                                        <td>:</td>
                                        <td><?= $ujikomdetail["judul_skema"] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Jadwal Ujikom</td>
                                        <td>:</td>
                                        <td><?= date_indo($ujikomdetail["tgl_sertifikasi"]) ?></td>
                                    </tr>
                                    <tr>
                                        <td>TUK</td>
                                        <td>:</td>
                                        <td><?= $ujikomdetail["nama_tuk"] ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="panel-body p-20">
                            <div class="panel-title">
                                <h5>Tambah Test</h5>
                            </div>
                            <form action="<?= base_url('aksesasesor/prosestest') ?>" method="POST">
                                <div class="row panel">
                                    <div class="panel-body">
                                        <div class="col-md-12">
                                            <i>( * ) Wajib di Isi</i>
                                            <div class="form-group has-feedback">
                                                <label for="username5">Jenis Test</label>
                                                <input type="hidden" class="form-control" name="id_paket" value="<?= $id_paket ?>">
                                                <input type="hidden" class="form-control" name="id_jenis" value="<?= $jenis_test ?>">
                                                <?php
                                                $dj = $this->Maksesasesor->getJenisTest($jenis_test);
                                                ?>
                                                <input type="text" class="form-control" value="<?= $dj['jenis_test'] ?>" disabled>
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
                                            <?php if ($jenis_test == 1) { ?>
                                                <div class="form-group">
                                                    <label for="js-states-mul">Pilih Soal*</label>
                                                    <select name="soal_observasi[]" class="js-states form-control" id="js-states-mul" multiple="multiple">
                                                        <?php
                                                        $datasoal = $this->Mfria02->getfria02($ujikomdetail["id_skema"]);
                                                        foreach ($datasoal as $ds) :
                                                        ?>
                                                            <option value="<?= $ds->id ?>"><?= $ds->judul_tugas ?></option>
                                                        <?php
                                                        endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="form-group has-feedback">
                                                    <label for="name5">Aktifkan Upload File</label>
                                                    <input type="checkbox" class="js-switch-warning" name="upload_file" value="1">
                                                </div>
                                                <div class="form-group has-feedback">
                                                    <label for="name5">Ukuran Maksimum File (Byte)</label>
                                                    <input type="number" class="form-control" name="upload_file">
                                                </div>
                                                <div class="form-group has-feedback">
                                                    <label for="name5">Aktifkan Link File</label>
                                                    <input type="checkbox" class="js-switch-warning" name="link_file" value="1">
                                                </div>
                                            <?php } elseif ($jenis_test == 2) { ?>
                                                <div class="form-group has-feedback">
                                                    <label for="name5">Random Soal</label>
                                                    <input type="checkbox" class="js-switch-warning" name="random_soal" value="1">
                                                </div>
                                                <div class="form-group has-feedback">
                                                    <label for="name5">Random Jawaban</label>
                                                    <input type="checkbox" class="js-switch-warning" name="random_jawaban" value="1">
                                                </div>
                                            <?php } else { ?>
                                                <div class="form-group has-feedback">
                                                    <label for="name5">Random Soal</label>
                                                    <input type="checkbox" class="js-switch-warning" name="random_soal" value="1">
                                                </div>
                                            <?php } ?>
                                            <div class="form-group has-feedback">
                                                <a href="<?= base_url('aksesasesor/daftar_test/' . $id_paket) ?>" class="btn btn-primary btn-labeled"><i class="fa fa-arrow-left"></i>Kembali</a>
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