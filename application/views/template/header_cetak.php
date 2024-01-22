<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Options Admin - Responsive Web Application Kit</title>

    <!-- ========== COMMON STYLES ========== -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/Theme/css/bootstrap.min.css" media="screen">
    <link rel="stylesheet" href="<?= base_url() ?>assets/Theme/css/font-awesome.min.css" media="screen">
    <link rel="stylesheet" href="<?= base_url() ?>assets/Theme/css/animate-css/animate.min.css" media="screen">
    <link rel="stylesheet" href="<?= base_url() ?>assets/Theme/css/lobipanel/lobipanel.min.css" media="screen">

    <!-- ========== PAGE STYLES ========== -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/Theme/css/prism/prism.css" media="screen"> <!-- USED FOR DEMO HELP - YOU CAN REMOVE IT -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/Theme/css/icheck/skins/line/blue.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/Theme/css/icheck/skins/line/red.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/Theme/css/icheck/skins/line/green.css">

    <!-- ========== THEME CSS ========== -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/Theme/css/main.css" media="screen">

    <!-- ========== MODERNIZR ========== -->
    <script src="js/modernizr/modernizr.min.js"></script>
</head>

<body onload="window.print();">
    <div class="main-wrapper"><!-- Content Header (Page header) -->
        <div class="container">
            <section class="content">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <?php
                                $datakop = $this->M_Setting->getkop();
                                ?>
                                <table width="100%">
                                    <tr>
                                        <td align="left" width="30%" style="border-bottom:double">
                                            <h3 class="card-title"><img src="<?= base_url() ?>assets/img/kop/<?= $datakop->logo_kiri ?>" width="130"></h3>
                                        </td>
                                        <td align="center" width="50%" style="border-bottom:double">
                                            <?= $datakop->isi ?>
                                        </td>
                                        <td align="right" width="20%" style="border-bottom:double"><img src="<?= base_url() ?>assets/img/kop/<?= $datakop->logo_kanan ?>" width="100"></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="card-body">