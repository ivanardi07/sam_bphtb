<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<!-- PAGE TITLE -->
<div class="page-title">
    <h2><span class="fa fa-arrow-circle-o-left"></span> Pencetakan Surat Keputusan</h2>
</div>
<!-- END PAGE TITLE -->
<div class="page-content-wrap">
    <div class="col-md-3 pull-right" style="margin-bottom: 10px;">
    </div>
    <?php if (!empty($info)) {
        echo $info;
    } ?>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">

                </div>
                <form name="frm_tagih_bea" method="post" action="<?= $c_loc ?>">
                    <div class="panel-body">
                        <table class="table">
                            <tr>
                                <td style="width: 80px;"><strong>Jenis SK</strong></td>
                                <td style="width: 10px;">:</td>
                                <td>
                                    <div style="width:250px;">
                                        <select name="txt_jns_sk" class="form-control select2" width="250px">
                                            <option value="STB">STB</option>
                                            <option value="SKBKB">SKBKB</option>
                                            <option value="SKPENGURANGAN" selected="selected">SK PENGURANGAN</option>
                                        </select>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Nomor</strong></td>
                                <td>:</td>
                                <td><input type="text" name="txt_nomor" style="width: 250px;" value="" class="form-control" /></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td><input type="submit" name="search_submit" value="Cari" class="btn btn-default" /></td>
                            </tr>
                        </table>
                    </div>

                    <div class="panel-footer">

                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

</div>
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