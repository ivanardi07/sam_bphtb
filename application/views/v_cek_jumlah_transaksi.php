<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<link rel="stylesheet" href="<?= base_url() ?>assets/autocomplete/jquery-ui.css">
<script src="<?= base_url() ?>assets/autocomplete/jquery-1.10.2.js"></script>
<script src="<?= base_url() ?>assets/autocomplete/jquery-ui.js"></script>
<script>
    var $j = jQuery.noConflict();
    $j(function() {
        var availableTags = <?= $data_nik ?>;
        $j("#nik").autocomplete({
            source: availableTags
        });
    });
</script>
<?php
$this->load->helper('form');
$type_user = $this->session->userdata('s_username_bphtb');

$type = $this->session->userdata('s_tipe_bphtb');

if ($type == 'PT') {
    $id_user = $this->session->userdata('s_id_ppat');
} elseif ($type == 'D') {
    $id_user = $this->session->userdata('s_id_dispenda');
} elseif ($type == 'PP') {
    $id_user = $this->session->userdata('s_id_paymentpoint');
}

?>

<!-- PAGE TITLE -->
<div class="page-title">
    <h2><span class="fa fa-arrow-circle-o-left"></span> <?= $title ?></h2>
    <?php echo $this->session->flashdata('flash_msg'); ?>
</div>

<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">

                    <div class="row">
                        <div class="col-md-4">
                        </div>
                        <form action="" method="post" class="form-horizontal">
                            <div class="form-group">
                                <div class="col-md-6">
                                    <label for="nama" class="col-sm-3 control-label">NIK / No. KTP</label>
                                    <div class="col-sm-9">
                                        <input name="nik" id="nik" size="25" type="text" class="form-control" />
                                    </div>
                                </div>
                                <div class="col-md-1 text-center">
                                    <input name="txt_submit" type="submit" value="Search" class="btn btn-info">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="panel-body">
                    <table align="center" class="table table-bordered table-hover">
                        <tr>
                            <td width="150" class="fields_label" align="left">NIK</td>
                            <td width="1" align="center">:</td>
                            <td class="linebottom">
                                <span class="text_header"><?= @$nik->nik ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="fields_label" align="left">Nama WP</td>
                            <td align="center">:</td>
                            <td class="linebottom"><span class="text_header"><?= @$nik->nama ?></span></td>
                        </tr>
                    </table>

                    <table align="center" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <td align="center"><b>Tahun</b></td>
                                <td align="center"><b>Jumlah Transaksi</b></td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (@$dataJumlah) : ?>
                                <?php foreach ($dataJumlah as $key => $value) : ?>
                                    <tr>
                                        <td align="center"><?= $value->tahun ?></td>
                                        <td align="center"><?= $value->jumlah ?></td>
                                    </tr>
                                <?php endforeach ?>
                            <?php else : ?>
                                <tr>
                                    <td align="center" colspan="2">Data tidak ada</td>
                                </tr>
                            <?php endif ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>