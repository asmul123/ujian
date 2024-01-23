<div class="main-page">
    <div class="container-fluid">
        <div class="row page-title-div">
            <div class="col-sm-6">
                <h2 class="title">Pengguna</h2>
                <p class="sub-title">UJIAN - SMKS YPPT GARUT</p>
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
                    <li class="active">Pengguna</li>
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
                                <h5>Data Pengguna</h5>
                            </div>
                        </div>
                        <div class="panel-body p-20">
                            <?php if ($akses['add'] == 1) { ?>
                                <?php if ($akses['add'] == 1) { ?>
                                    <a href="<?= base_url('pengguna/tambah')  ?>" class="btn btn-primary mb-20">
                                        <i class="fa fa-plus text-white"></i>
                                        Tambah Data Pengguna
                                    </a>
                                    <div class="btn-group pull-right">
                                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Filter Pengguna <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-right mt-5" style="box-shadow: 0 0 5px 0px #000;">
                                            <?php $levelpengguna = $this->Mpengguna->getlevelpengguna();
                                            foreach ($levelpengguna as $lv) :
                                            ?>
                                                <li><a href="<?= base_url('pengguna/index/' . $lv->id)  ?>"><?= $lv->userlevel ?></a></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                <?php  } ?>
                            <?php  } ?>
                            <table id="dataSiswaIndex" class="display table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Nama Lengkap</th>
                                        <th class="text-center">Username</th>
                                        <th class="text-center">Level Pengguna</th>
                                        <th class="text-center">Kata Sandi</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1;
                                    foreach ($datapengguna as $data) : ?>
                                        <tr>
                                            <td class="text-center"><?= $no++; ?></td>
                                            <td><?= $data->nama; ?></td>
                                            <td><?= $data->username; ?></td>
                                            <td><?= $data->userlevel; ?></td>
                                            <td>
                                                <?php
                                                if (md5($data->username) == $data->password) {
                                                ?>
                                                    <button class="btn btn-warning">Default</a>
                                                    <?php
                                                } else {
                                                    ?>
                                                        <button class="btn btn-success">Custom</button>
                                                    <?php } ?>
                                            </td>
                                            <td style="min-width: 175px;">
                                                <center>
                                                    <div class="btn-group">
                                                        <?php if ($akses['view'] == 1) { ?>
                                                            <a href="<?= base_url('pengguna/reset/') . $data->iduser;  ?>" class="btn btn-success" onclick="return confirm('Yakin untuk mereset password pengguna?')"><i class="fa fa-refresh"></i></a>
                                                        <?php  } ?>
                                                        <?php if ($akses['edit'] == 1) { ?>
                                                            <a href="<?= base_url('pengguna/ubah/') . $data->iduser;  ?>" class="btn btn-warning"><i class="fa fa-pencil"></i></a>
                                                        <?php  } ?>
                                                        <?php if ($akses['delete'] == 1) { ?>
                                                            <a href="<?= base_url('pengguna/hapus/') . $data->iduser ?>" class="btn btn-danger" onclick="return confirm('Yakin untuk menghapus?')"><i class="fa fa-trash"></i></a>
                                                        <?php  } ?>
                                                    </div>
                                                </center>
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