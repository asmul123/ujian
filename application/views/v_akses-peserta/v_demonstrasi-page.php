<div class="content-wrapper">
    <div class="content-container">
        <div class="main-page">
            <div class="container-fluid">
                <div class="row page-title-div">
                    <div class="col-md-6">
                        <h2 class="title"><?= $data_test->jenis_test ?></h2>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
            <section class="section">
                <div class="container-fluid">
                    <div class="content-internal">
                        <div class="content">
                            <h4 class="mt-10">Soal No : <button class="btn btn-info"><?= $no ?></button>
                                <div class="btn-group" style="float: right;">
                                    <button class="btn btn-default">Sisa Waktu : </button>
                                    <button class="btn btn-info" id="demo"></button>
                                </div>
                            </h4>
                            <hr>
                            <?php
                            if ($data_test->id_jenis == 1) {
                                $es = explode('#', $rekaman);
                                $akhir = count($es);
                                $soal = $this->Mfria02->getdetailfria02($es[$no]);
                                $daftarunit = explode('#', $soal['daftar_unit']);
                            ?>
                                <table width="100%" border='1' cellpadding="4" cellspacing="0">
                                    <tr>
                                        <td><b>Judul Tugas</b></td>
                                        <td colspan="2"><?= $soal['judul_tugas'] ?></td>
                                    </tr>
                                    <tr>
                                        <td rowspan="<?= count($daftarunit) ?>"><b>Daftar Unit</b></td>
                                        <td><b>Kode Unit</b></td>
                                        <td><b>Judul Unit</b></td>
                                    </tr>
                                    <?php
                                    for ($i = 1; $i < count($daftarunit); $i++) {
                                        $dataunit = $this->Mskema->getunitdetail($daftarunit[$i]);
                                    ?>
                                        <tr>
                                            <td><?= $dataunit["kode_unit"] . $i . $daftarunit[$i] ?></td>
                                            <td><?= $dataunit["judul_unit"] ?></td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </table>
                                <br>
                                <div class="card-body pad">
                                    <div class="mb-3">
                                        <b>A. Petunjuk</b>
                                        <p>
                                            <?= $soal['petunjuk'] ?>
                                        </p>
                                    </div>
                                    <div class="mb-3">
                                        <b>B. Skenario</b>
                                        <p><?= $soal['sekenario'] ?></p>
                                    </div>
                                    <div class="mb-3">
                                        <b>C. Langkah Kerja</b>
                                        <p><?= $soal['langkah_kerja'] ?></p>
                                    </div>
                                </div>
                                <?php if ($data_test->upload_file == '1') {
                                ?>
                                    <div class="btn-group">
                                        <button class="btn btn-default">Daftar File : </button>
                                        <button class="btn btn-primary" data-toggle="modal" data-target="#modalUpload" data-backdrop="false">Upload</button>
                                    </div><!-- Modal -->
                                    <div class="modal fade" id="modalUpload" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="myModalLabel">Upload File disini <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                                                </div>
                                                <?php echo form_open_multipart('aksesasesi/demonstrasi_test'); ?>
                                                <div class="modal-body">
                                                    Judul File (Apabila lebih dari 1 akan ditambahkan nomor)
                                                    <input type="text" name="judul" class="form-control" placeholder="nama file tugas demonstrasi">
                                                    Max (<?= $data_test->max_file ?> Byte)
                                                    <input type="file" name="file[]" class="form-control" multiple>
                                                    <input type="hidden" name="id_test" value="<?= $status_test->id ?>">
                                                    <input type="hidden" name="id_ia" value="<?= $es[$no] ?>">
                                                    <input type="hidden" name="max_file" value="<?= $data_test->max_file ?>">
                                                </div>
                                                <div class="modal-footer">
                                                    <div class="btn-group" role="group">
                                                        <button type="button" class="btn btn-gray btn-wide btn-rounded" data-dismiss="modal"><i class="fa fa-times"></i>Batal</button>
                                                        <button type="submit" class="btn bg-success btn-wide btn-rounded" name="upload" value="upload"><i class="fa fa-check"></i>Simpan</button>
                                                    </div>
                                                    <!-- /.btn-group -->
                                                </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                    $daftarfile = $this->db->get_where('tb_tugas_demonstrasi', array('jenis' => '1', 'id_ia' => '1'));
                                } ?>
                                <?php if ($data_test->link_file == '1') {
                                ?>
                                    <div style="float:right;">
                                        <div class="btn-group">
                                            <button class="btn btn-default">Daftar Link : </button>
                                            <button class="btn btn-primary" data-toggle="modal" data-target="#modalTambah" data-backdrop="false">Tambah</button>
                                        </div>
                                        <div class="modal fade" id="modalTambah" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="myModalLabel">Tambah Link Tugas disini <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                                                    </div>
                                                    <form action="<?= base_url('aksesasesi/demonstrasi_test') ?>" method="POST">
                                                        <div class="modal-body">
                                                            Judul Link
                                                            <input type="text" name="judul" class="form-control" placeholder="nama file tugas demonstrasi">
                                                            Link
                                                            <input type="text" name="link" class="form-control" placeholder="https://www.linktugasanda.com/filetugas.pdf">
                                                            <input type="hidden" name="id_test" value="<?= $status_test->id ?>">
                                                            <input type="hidden" name="id_ia" value="<?= $es[$no] ?>">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <div class="btn-group" role="group">
                                                                <button type="button" class="btn btn-gray btn-wide btn-rounded" data-dismiss="modal"><i class="fa fa-times"></i>Batal</button>
                                                                <button type="submit" class="btn bg-success btn-wide btn-rounded" name="tambah" value="tambah"><i class="fa fa-check"></i>Simpan</button>
                                                            </div>
                                                            <!-- /.btn-group -->
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                } ?>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <?= $this->session->flashdata('alert'); ?>
                                        <table class="table table-striped table-bordered">
                                            <tr>
                                                <th class="text-center">NO</th>
                                                <th class="text-center">File</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                            <?php
                                            $nofile = 1;
                                            $daftar_file = $this->db->get_where('tb_tugas_demonstrasi', array('id_status_test' => $status_test->id, 'jenis' => '1'))->result();
                                            foreach ($daftar_file as $dl) {
                                            ?>
                                                <tr>
                                                    <td class="text-center"><?= $nofile++ ?></td>
                                                    <td><a href="<?= base_url('assets/assesment/demonstrasi/' . $dl->target)  ?>" class="btn btn-default" target="_blank"><i class="fa fa-download"></i> <?= $dl->judul ?></a></td>
                                                    <td class="text-center"><a href="<?= base_url('aksesasesi/hapus_target/' . $dl->id) ?>" class="btn btn-danger" onclick="return confirm('Yakin untuk menghapus file ini?')"><i class="fa fa-trash"></i> Hapus</a></td>
                                                </tr>
                                            <?php } ?>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <table class="table table-striped table-bordered">
                                            <tr>
                                                <th class="text-center">NO</th>
                                                <th class="text-center">Link</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                            <?php
                                            $nolink = 1;
                                            $daftar_link = $this->db->get_where('tb_tugas_demonstrasi', array('id_status_test' => $status_test->id, 'jenis' => '2'))->result();
                                            foreach ($daftar_link as $dl) {
                                            ?>
                                                <tr>
                                                    <td class="text-center"><?= $nolink++ ?></td>
                                                    <td><a href="<?= $dl->target ?>" class="btn btn-default" target="_blank"><?= $dl->judul ?></a></td>
                                                    <td class="text-center"><a href="<?= base_url('aksesasesi/hapus_target/' . $dl->id) ?>" class="btn btn-danger" onclick="return confirm('Yakin untuk menghapus link ini?')"><i class="fa fa-trash"></i> Hapus</a></td>
                                                </tr>
                                            <?php } ?>
                                        </table>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                        <!-- /.content -->
                    </div>
                    <!-- /.content-internal -->

                    <div class=" sidebar-internal" data-spy="affix" data-offset-top="140" data-offset-bottom="200">
                        <div class="sidebar">
                            <h5 class="mt-5">Nomor Soal</h5>
                            <hr>
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <?php
                                    for ($i = 1; $i < count($es); $i++) {
                                        $btn = "default";
                                        if ($no == $i) {
                                            $btn = "info";
                                        }
                                    ?>
                                        <td>
                                            <a href="<?= base_url('aksesasesi/demonstrasi_test/' . $i) ?>" class="btn btn-<?= $btn ?> btn-xs btn-block"><?= $i ?></a>
                                        </td>
                                        <?php
                                        if ($i % 4 == 0) {
                                            echo "</tr><tr>";
                                        }
                                        ?>

                                    <?php

                                    } ?>
                                </tr>
                            </table>
                            <a href="<?= base_url('aksesasesi/demonstrasi_test/akhir') ?>" class="btn btn-danger btn-block" onclick="return confirm('Yakin untuk mengakhiri test, test tidak dapat diulangi?')">Akhiri</a>
                        </div>
                    </div>
                    <!-- /.sidebar -->
                </div>
                <!-- /.sidebar-internal -->
            </section>
            <!-- /.section -->
        </div>
        <!-- /.container-fluid -->


    </div>
    <!-- /.main-page -->


    <script>
        // Set the date we're counting down to
        var countDownDate = new Date("<?= $finish_at->format('M d, Y H:i:s') ?>").getTime();

        // Update the count down every 1 second
        var x = setInterval(function() {

            // Get today's date and time
            var now = new Date().getTime();

            // Find the distance between now and the count down date
            var distance = countDownDate - now;

            // Time calculations for days, hours, minutes and seconds
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Display the result in the element with id="demo"
            document.getElementById("demo").innerHTML = ('00' + hours).slice(-2) + ":" +
                ('00' + minutes).slice(-2) + ":" + ('00' + seconds).slice(-2);

            // If the count down is finished, write some text
            if (distance < 0) {
                clearInterval(x);
                document.getElementById("demo").innerHTML = "00:00:00";
                window.location.href = "<?= base_url('aksesasesi/demonstrasi_test/akhir') ?>";
            }
        }, 1000);
    </script>