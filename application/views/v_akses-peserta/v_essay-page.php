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
            <form action="<?= base_url('aksesasesi/essay_test') ?>" method="POST">
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
                                if ($data_test->id_jenis == 3) {
                                    $es = explode('#', $rekaman);
                                    $akhir = count($es);
                                    $soal = $this->Mfria06->getdetailfria06($es[$no]);
                                    $jawaban = $this->db->get_where('fr_ia_06', array('id_asesi' => $idasesi, 'id_ia' => $es[$no]))->row()->jawaban;
                                ?>
                                    <input type="hidden" name="soal" value="<?= $es[$no] ?>">
                                    <input type="hidden" name="unit" value="<?= $soal['id_unit'] ?>">
                                    <p>
                                    <h5><?= $soal['pertanyaan'] ?></h5>
                                    </p>
                                    Jawaban Anda :
                                    <textarea class="textarea" name="jawaban" value=""><?php if ($jawaban) {
                                                                                            echo $jawaban;
                                                                                        } ?></textarea>
                                <?php
                                }
                                if ($no != 1) {
                                ?>
                                    <button type="submit" class="btn btn-primary" value="<?= $no - 1 ?>" name="no">
                                        < Sebelumnya</button>
                                        <?php }
                                    if ($no != $akhir - 1) { ?>
                                            <button type="submit" class="btn btn-primary" style="float:right;" value="<?= $no + 1 ?>" name="no">Selanjutnya ></button>
                                        <?php } else { ?>
                                            <button type="submit" class="btn btn-danger" style="float:right;" value="akhir" name="no" onclick="return confirm('Yakin untuk mengakhiri test, test tidak dapat diulangi?')">Akhiri</button>
                                        <?php } ?>
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
                                            $cekjawaban = $this->db->get_where('fr_ia_06', array('id_asesi' => $idasesi, 'id_ia' => $es[$i]))->num_rows();
                                            if ($no == $i) {
                                                $btn = "info";
                                            } else if ($cekjawaban > 0) {
                                                $btn = "success";
                                            }
                                        ?>
                                            <td>
                                                <button type="submit" name="no" value="<?= $i ?>" class="btn btn-<?= $btn ?> btn-xs btn-block"><?= $i ?></button>
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
                            </div>
                        </div>
                        <!-- /.sidebar -->
                    </div>
                    <!-- /.sidebar-internal -->
                </section>
                <!-- /.section -->
            </form>
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
                window.location.href = "<?= base_url('aksesasesi/essay_test/akhir') ?>";
            }
        }, 1000);
    </script>