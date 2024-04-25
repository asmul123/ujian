<div class="main-page">
    <div class="container-fluid">
        <div class="row page-title-div">
            <div class="col-sm-6">
                <h2 class="title">DETAIL SOAL</h2>
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
                                            <h4 class="modal-title" id="myModalLabel">Tambahkan Soal<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                                        </div>
                                        <form action="<?= base_url('soal/tambah_detail') ?>" method="POST">
                                            <div class="modal-body">
                                                <div class="form-group has-feedback">
                                                    <label for="username5">Pertanyaan</label>
                                                    <input type="hidden" name="id_soal" value="<?= $id_soal ?>">
                                                    <textarea class="textarea" name="pertanyaan" placeholder="Silahkan tulis pertanyaan anda" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                                                </div>
                                                <div class="form-group has-feedback">
                                                    <label for="username5">Jawaban</label>
                                                    <?php
                                                    for ($i = 1; $i <= 5; $i++) {
                                                    ?>
                                                        <div class="row">
                                                            <div class="col-lg-1">
                                                                <input type="radio" name="kunci" value="<?= $i ?>">
                                                            </div>
                                                            <div class="col-lg-11">
                                                                <textarea class="textarea" name="jawaban<?= $i ?>" placeholder="Silahkan tuliskan Jawaban disini" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                                                            </div>
                                                        </div>

                                                    <?php } ?>
                                                </div>
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
                                        <th class="text-center">Pertanyaan</th>
                                        <th class="text-center">Jawaban</th>
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
                                            <td><?= $s->pertanyaan ?></td>
                                            <td class="text-center">
                                                <ol type="a">
                                                    <?php
                                                    $op = explode("[#_#]", $s->jawaban);
                                                    $lb = 'A';
                                                    for ($i = 0; $i <= 4; $i++) {
                                                        $isiop = explode("[_#_]", $op[$i]);
                                                        echo "<li>" . $isiop['1'] . " ";
                                                        if ($s->kunci == $lb) {
                                                            echo "&#10004;";
                                                        }
                                                        echo "</li>";
                                                        $lb++;
                                                    } ?>
                                                </ol>
                                            </td>
                                            <td style="min-width: 40px">
                                                <div class="btn-group">
                                                    <a href="#" class="btn btn-warning" data-toggle="modal" data-target="#modalEdit<?= $s->id ?>"><i class="fa fa-edit"></i></a>
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="modalEdit<?= $s->id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title" id="myModalLabel">Ubah Soal<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                                                                </div>
                                                                <form action="<?= base_url('soal/ubah_detail') ?>" method="POST">
                                                                    <div class="modal-body">
                                                                        <div class="form-group has-feedback">
                                                                            <label for="username5">Pertanyaan</label>
                                                                            <input type="hidden" name="id_soal" value="<?= $id_soal ?>">
                                                                            <input type="hidden" name="id" value="<?= $s->id ?>">
                                                                            <textarea class="textarea" name="pertanyaan" placeholder="Silahkan tulis pertanyaan anda" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?= $s->pertanyaan ?></textarea>
                                                                        </div>
                                                                        <div class="form-group has-feedback">
                                                                            <label for="username5">Jawaban</label>
                                                                            <?php
                                                                            for ($i = 1; $i <= 5; $i++) {
                                                                                $isiop = explode("_#_", $op[$i]);
                                                                            ?>
                                                                                <div class="row">
                                                                                    <div class="col-lg-1">
                                                                                        <input type="radio" name="kunci" value="<?= $i ?>" <?php if ($s->kunci == $i) {
                                                                                                                                                echo 'checked';
                                                                                                                                            } ?>>
                                                                                    </div>
                                                                                    <div class="col-lg-11">
                                                                                        <textarea class="textarea" name="jawaban<?= $i ?>" placeholder="Silahkan tuliskan Jawaban disini" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?= $isiop['1'] ?></textarea>
                                                                                    </div>
                                                                                </div>

                                                                            <?php } ?>
                                                                        </div>
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
                                                    <a href="<?= base_url('soal/hapus_detail/') . $s->id . '/' . $id_soal;  ?>" class="btn btn-danger" onclick="return confirm('Yakin untuk menghapus?')"><i class="fa fa-trash"></i></a>
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