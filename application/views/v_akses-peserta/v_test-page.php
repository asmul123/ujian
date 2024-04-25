<div class="content-wrapper">
    <div class="content-container">
        <div class="main-page">
            <div class="container-fluid">
                <div class="row page-title-div">
                    <div class="col-md-12">
                        <h2 class="title"><?= $data_test->judul_soal ?>
                            <div style="float: right;">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                    Daftar Soal
                                </button>
                            </div>
                        </h2>
                    </div>
                </div>
            </div>
            <form action="<?= base_url('aksespeserta/soal_test') ?>" method="POST">
                <section class="section">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel">
                                    <div class="panel-heading">
                                        <div class="panel-title">
                                            <h4 class="mt-10">Soal No : <button class="btn btn-info"><?= $no ?></button>
                                                <div class="btn-group" style="float: right;">
                                                    <button class="btn btn-default">Sisa Waktu : </button>
                                                    <button class="btn btn-info" id="demo"></button>
                                                </div>
                                            </h4>
                                            <hr>
                                            <?php
                                            $es = explode('#', $rekaman);
                                            $akhir = count($es);
                                            $ia = explode('-', $es[$no]);
                                            $jmluraian = count($ia);
                                            $soal = $this->Msoal->getPertanyaan($ia[0]);
                                            $jw = explode('[#_#]', $soal->jawaban);
                                            ?>
                                            <input type="hidden" name="soal" value="<?= $ia[0] ?>">
                                            <input type="hidden" name="no_soal" value="<?= $no ?>">
                                            <p>
                                            <h5><?= $soal->pertanyaan ?></h5>
                                            </p>
                                            <?php
                                            if($soal->id_jenissoal==1){
                                            ?>
                                            <?php for ($j = 0; $j <= 4; $j++) {
                                                $jawaban = explode("[_#_]", $jw[$j]);
                                                if ($jawaban[1] != "") {
                                            ?>
                                                    <table width="100%">
                                                        <tr>
                                                            <td valign="top" width="5%"><input type="radio" name="jawaban" class="blue-style" value="<?= $jawaban[0] ?>" <?php if ($jawaban[0] == $ia[1]) {
                                                                                                                                                                                echo "checked";
                                                                                                                                                                            } ?>></td>
                                                            <td valign="top" width="95%"><?= $jawaban[1] ?></td>
                                                        </tr>
                                                    </table>
                                            <?php }
                                            } 
                                        } else if ($soal->id_jenissoal==3){
                                            ?>
                                            <textarea class="textarea" name="jawaban" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">
                                            <?php 
                                            if($ia[1]!=0){ 
                                                if($jmluraian>2){
                                                    $ju = $ia[1];
                                                    for($j=2;$j<$jmluraian;$j++){
                                                        $ju = $ju."-".$ia[$j];
                                                    }
                                                    echo $ju;
                                                } else {
                                                    echo $ia[1];
                                                } 
                                            }
                                            ?>
                                        </textarea>
                                            <?php
                                        }
                                            if ($no != 1) {
                                            ?>
                                                <button type="submit" class="btn btn-primary mb-3" value="<?= $no - 1 ?>" name="no">
                                                    < Sebelumnya</button>
                                                    <?php } else {
                                                    ?>
                                                        <button class="btn btn-primary mb-3" disabled>
                                                            < Sebelumnya</button>
                                                            <?php
                                                        }
                                                        if ($no != $akhir - 1) { ?>
                                                                <button type="submit" class="btn btn-primary" style="float:right;" value="<?= $no + 1 ?>" name="no">Selanjutnya ></button>
                                                            <?php } else { ?>
                                                                <button type="submit" class="btn btn-danger" style="float:right;" value="akhir" name="no" onclick="return confirm('Yakin untuk mengakhiri test, test tidak dapat diulangi?')">Akhiri</button>
                                                            <?php } ?>

                                                            <!-- Modal -->
                                                            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h4 class="modal-title" id="myModalLabel">Nomor Soal <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></h4>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <table width="100%" cellpadding="0" cellspacing="0">
                                                                                <tr>
                                                                                    <?php
                                                                                    for ($i = 1; $i < count($es); $i++) {
                                                                                        $cia = explode('-', $es[$i]);
                                                                                        $btn = "default";
                                                                                        if ($no == $i) {
                                                                                            $btn = "info";
                                                                                        } else if ($cia[1] != 0) {
                                                                                            $btn = "success";
                                                                                        }
                                                                                    ?>
                                                                                        <td>
                                                                                            <button type="submit" name="no" value="<?= $i ?>" class="btn btn-<?= $btn ?> btn-xs btn-block"><?= $i ?></button>
                                                                                        </td>
                                                                                        <?php
                                                                                        if ($i % 5 == 0) {
                                                                                            echo "</tr><tr>";
                                                                                        }
                                                                                        ?>

                                                                                    <?php

                                                                                    } ?>
                                                                                </tr>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </section>
            </form>
        </div>
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
            window.location.href = "<?= base_url('aksespeserta/soal_test/akhir') ?>";
        }
    }, 1000);
</script>