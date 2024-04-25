<div class="content-wrapper">
    <div class="content-container">
        <div class="main-page">
            <div class="container-fluid">
                <div class="row page-title-div">
                    <div class="col-md-6">
                        <h2 class="title">Konfirmasi Test</h2>
                    </div>
                </div>
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
                                        <h5>Konfirmasi Test</h5>
                                    </div>
                                </div>
                                <form action="<?= base_url('aksespeserta/soal_test/' . $data_test->idtest) ?>" method="POST">
                                    <div class="panel-body">
                                        <table>
                                            <tr>
                                                <td>Kode Soal</td>
                                                <td>:</td>
                                                <td><?= $data_test->kode_soal ?></td>
                                            </tr>
                                            <tr>
                                                <td>Mata Pelajaran</td>
                                                <td>:</td>
                                                <td><?= $data_test->mata_pelajaran ?></td>
                                            </tr>
                                            <tr>
                                                <td>Durasi</td>
                                                <td>:</td>
                                                <td><?= $data_test->durasi ?></td>
                                            </tr>
                                            <tr>
                                                <td>Nomor Peserta</td>
                                                <td>:</td>
                                                <td><?= $data_peserta->nama ?></td>
                                            </tr>
                                            <tr>
                                                <td>Nama Peserta</td>
                                                <td>:</td>
                                                <td><?= $data_peserta->no_peserta ?></td>
                                            </tr>
                                            <tr>
                                                <td>Token</td>
                                                <td>:</td>
                                                <td>
                                                    <input type="text" name="token" autofocus required size="8">
                                                    <input type="hidden" name="idtest" value="<?= $idtest ?>">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><input type="submit" class="btn btn-info" value="Mulai"></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </table>
                                    </div>
                                </form>
                                <!-- /.col-md-12 -->
                            </div>
                        </div>
                    </div>
                    <!-- /.col-md-12 -->
                </div>
                <!-- /.row -->
                <!-- /.content-internal -->
        </div>
        <!-- /.container-fluid -->
        </section>
        <!-- /.section -->



    </div>
    <!-- /.main-page -->

    <div class="right-sidebar bg-white fixed-sidebar">
        <div class="sidebar-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <h4>Useful Sidebar <i class="fa fa-times close-icon"></i></h4>
                        <p>Code for help is added within the main page. Check for code below the example.</p>
                        <p>You can use this sidebar to help your end-users. You can enter any HTML in this sidebar.</p>
                        <p>This sidebar can be a 'fixed to top' or you can unpin it to scroll with main page.</p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                    </div>
                    <!-- /.col-md-12 -->

                    <div class="text-center mt-20">
                        <button type="button" class="btn btn-success btn-labeled">Purchase Now<span class="btn-label btn-label-right"><i class="fa fa-check"></i></span></button>
                    </div>
                    <!-- /.text-center -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /.sidebar-content -->
    </div>