<div class="main-page">
    <div class="container-fluid">
        <div class="row page-title-div">
            <div class="col-sm-6">
                <h2 class="title">Dashboard</h2>
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
                    <li><a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a></li>
                    <li class="active">Dashboard</li>
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
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <?php
                    if ($dataapl01) {
                        if ($dataapl01['status'] == 1) {
                            $status = "bg-warning";
                        } else if ($dataapl01['status'] == 2) {
                            $status = "bg-success";
                        } else {
                            $status = "bg-danger";
                        }
                    } else {
                        $status = "bg-info";
                    } ?>
                    <a class="dashboard-stat <?= $status ?>" href="<?php echo base_url('aksesasesi/apl01') ?>">
                        <span class="number counter">APL-01</span>
                        <span class="name"><strong> Permohonan Sertifikasi</strong></span>
                        <span class="bg-icon"><i class="fa fa-users"></i></span>
                    </a>
                </div>
                <!-- /.col-lg-3 col-md-3 col-sm-6 col-xs-12 -->

                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <?php
                    if ($dataapl02) {
                        if ($dataapl02['status_ajuan'] == 1) {
                            $status_ajuan = "bg-warning";
                        } else if ($dataapl02['status_ajuan'] == 2) {
                            $status_ajuan = "bg-success";
                        } else {
                            $status_ajuan = "bg-danger";
                        }
                    } else {
                        $status_ajuan = "bg-info";
                    } ?>
                    <a class="dashboard-stat <?= $status_ajuan ?>" href="<?php echo base_url('aksesasesi/apl02') ?>">
                        <span class="number counter">APL-02</span>
                        <span class="name"><strong>Asesmen Mandiri</strong></span>
                        <span class="bg-icon"><i class="fa fa-users"></i></span>
                    </a>
                </div>
                <!-- /.col-lg-3 col-md-3 col-sm-6 col-xs-12 -->

                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <?php
                    if ($dataak01) {
                        if ($dataak01['ttd_asesor'] != "") {
                            $status_ajuan = "bg-success";
                        } else if ($dataak01['ttd_asesi'] != "") {
                            $status_ajuan = "bg-warning";
                        } else {
                            $status_ajuan = "bg-danger";
                        }
                    } else {
                        $status_ajuan = "bg-info";
                    } ?>
                    <a class="dashboard-stat <?= $status_ajuan ?>" href="<?php echo base_url('aksesasesi/ak01') ?>">
                        <span class="number counter">AK-01</span>
                        <span class="name"><strong>Asesmen dan Kerahasiaan</strong></span>
                        <span class="bg-icon"><i class="fa fa-list"></i></span>
                    </a>
                    <!-- /.src-code -->
                </div>
                <!-- /.col-lg-3 col-md-3 col-sm-6 col-xs-12 -->
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <a class="dashboard-stat bg-info" href="<?php echo base_url('aksesasesi/ak04') ?>">
                        <span class="number counter">AK-04</span>
                        <span class="name"><strong>Banding Asesmen</strong></span>
                        <span class="bg-icon"><i class="fa fa-list"></i></span>
                    </a>
                    <!-- /.src-code -->
                </div>
                <!-- /.col-lg-3 col-md-3 col-sm-6 col-xs-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
</div>
<!-- /.main-page -->
<!-- /.right-sidebar -->

</div>
<!-- /.content-container -->
</div>