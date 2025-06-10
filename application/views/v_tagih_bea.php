<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="page-title">
    <h2><span class="fa fa-arrow-circle-o-left"></span> Pencetakan Surat Keputusan</h2>
</div>
<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <?php if (!empty($info)) {
                    echo $info;
                } ?>
                <div class="panel-body">
                    <form class="form-horizontal" name="frm_tagih_bea" method="post" action="<?= $c_loc ?>">
                        <div class="col-md-2"></div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <div class="col-md-6">
                                    <label for="txt_jns_sk" class="col-sm-4 control-label">Jenis SK :</label>
                                    <div class="col-sm-8">
                                        <select class="form-control select2" name="txt_jns_sk">
                                            <option value="STB" selected="selected">STB</option>
                                            <option value="SKBKB">SKBKB</option>
                                            <option value="SKPENGURANGAN">SK PENGURANGAN</option>
                                        </select>
                                        <span class="help-block">Pilih Jenis SK</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6">
                                    <label for="txt_nomor" class="col-sm-4 control-label">Nomor :</label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                            <input class="form-control" type="text" name="txt_nomor" style="width: 150px;" value="" class="tb" />
                                        </div>
                                        <span class="help-block">Masukan Nomor</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="panel-footer">
                    <input class="btn btn-primary" type="submit" name="search_submit" value="Cari" class="bt" />
                </div>
                </form>
                <script type="text/javascript">
                    $(function() {
                        $("#datepicker").datepicker({
                            dateFormat: 'yy-mm-dd',
                            changeMonth: true,
                            changeYear: true,
                            showOn: 'button',
                            buttonImage: '<?= base_url_img() ?>calendar.gif',
                            buttonImageOnly: true
                        });
                    });
                </script>