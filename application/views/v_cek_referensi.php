<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

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

// echo $type.' - '.$id_user; exit;

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
                        <div class="col-md-6">
                        </div>
                        <form action="" method="post" class="form-horizontal">
                            <div class="form-group">
                                <div class="col-md-4">
                                    <label for="nama" class="col-sm-3 control-label">NOP</label>
                                    <div class="col-sm-9">
                                        <input name="nop" id="nop" size="25" type="text" class="form-control" />
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
                    <table align="center" class="table table-bordered table-hover" cellspacing="2" width="100%">
                        <tr>
                            <td width="150" class="fields_label" align="left">NOP</td>
                            <td width="1" align="center">:</td>
                            <td class="linebottom">
                                <span class="text_header"><?= @$output['nop'] ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="fields_label" align="left">Harga Tanah</td>
                            <td align="center">:</td>
                            <td class="linebottom"><span class="text_header"><?= @$output['ref_tanah'] ?></span></td>
                        </tr>
                        <tr>
                            <td class="fields_label" align="left">Harga Bangunan</td>
                            <td align="center">:</td>
                            <td class="linebottom"><span class="text_header"><?= @$output['ref_bangunan'] ?></span></td>
                        </tr>
                        <tr>
                            <td class="fields_label" align="left" valign="top">Total</td>
                            <td align="center">:</td>
                            <td class="linebottom"><span class="text_header"><?= @$output['total'] ?></span></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    jQuery(function($) {
        $("#nop").mask("99.99.999.999.999.9999.9");
    });
</script>