<div class="main-page">
    <div class="container-fluid">
        <div class="row page-title-div">
            <div class="col-sm-6">
                <h2 class="title">Tahun Akatif</h2>
                <p class="sub-title">UJIAN SMKS YPPT GARUT</p>
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
                    <li class="active">Pengaturan</li>
                    <li class="active">Tahun Aktif</li>
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
                    <?= $this->session->flashdata('message'); ?>
                </div>
            </div>
            <div class="row ">

                <div class="col-md-12">

                    <div class="panel">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h5>Data Tahun Aktif</h5>
                            </div>

                            <?php if ($akses['add'] == 1) { ?>
                                <a href="<?= base_url('tahunaktif/tambah') ?>" class="btn btn-primary ml-15"><i class="fa fa-plus"></i> Tambah Tahun Aktif</a>
                            <?php } ?>
                        </div>
                        <div class="panel-body p-20">
                            <table id="tb_tahunakademik" class="display table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tahun Aktif</th>
                                        <!-- <th>Tanggal Update</th> -->
                                        <th width="200px">
                                            <center>Aksi</center>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($tahunaktif as $data) : ?>

                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td>
                                                <?= $data['tahun_aktif']; ?>
                                            </td>
                                            <!-- <td><?= $data['tglupdate'] ?></td> -->
                                            <td style="min-width: 175px;">
                                                <center>
                                                    <div class="btn btn-group">
                                                        <?php if ($akses['edit'] == 1) { ?>
                                                            <a href="<?= base_url('tahunaktif/ubah/') . $data['id'] ?>" class="btn btn-warning"><i class="fa fa-pencil"></i></a>
                                                        <?php } ?>
                                                        <?php if ($akses['delete'] == 1) { ?>
                                                            <a href="<?= base_url('tahunaktif/hapus/') . $data['id'] ?> " class="btn btn-danger" onclick="return confirm('Yakin Mau Dihapus ?')"><i class="fa fa-trash"></i></a>
                                                        <?php } ?>
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
<!-- /.main-page -->
<!-- /.right-sidebar -->

</div>
<!-- /.content-container -->
</div>