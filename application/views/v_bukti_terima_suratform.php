<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<h1><a href="<?php echo $c_loc; ?>">Bukti Penerimaan Surat</a> &raquo; <?php echo $submitvalue; ?></h1>
<div class="nav_box">
    [ <a href="<?php echo $c_loc; ?>">Kembali</a> ]
</div>
<?php if (!empty($info)) {
    echo $info;
} ?>
<div class="inputform">
    <form name="frm_jns_perolehan" method="post" action="">
        <table>
            <tr>
                <td width="120"> NOP &raquo; </td>
                <td> <input autocomplete="off" type="text" name="txt_nop" id="id_nop" style="width: 150px;" value="<?php echo $this->antclass->back_value(@$bts->nop, 'txt_nop'); ?>" <?php if ($submitvalue == 'Edit') {
                                                                                                                                                                                            echo 'disabled="disabled"';
                                                                                                                                                                                        } ?> class="tb" /> </td>
            </tr>
            <tr>
                <td> Tanggal Masuk &raquo; </td>
                <td> <input type="text" id="datepicker" name="txt_tgl_masuk" style="width: 80px;" maxlength="10" value="<?php if ($submitvalue == 'Simpan') {
                                                                                                                            echo date('Y-m-d');
                                                                                                                        } else {
                                                                                                                            echo $this->antclass->back_value(@$bts->tgl_masuk, 'txt_tgl_masuk');
                                                                                                                        } ?>" class="tb" /> </td>
            </tr>
            <tr>
                <td> Tanggal Keluar &raquo; </td>
                <td> <input type="text" id="datepicker2" name="txt_tgl_keluar" style="width: 80px;" maxlength="10" value="<?php if ($submitvalue == 'Simpan') {
                                                                                                                                echo date('Y-m-d');
                                                                                                                            } else {
                                                                                                                                echo $this->antclass->back_value(@$bts->tgl_keluar, 'txt_tgl_keluar');
                                                                                                                            } ?>" class="tb" /> </td>
            </tr>
            <tr>
                <td> Masa Pajak &raquo; </td>
                <td> <input type="text" name="txt_masa_pajak" style="width: 50px;" maxlength="4" value="<?php echo $this->antclass->back_value(@$bts->masa_pajak, 'txt_masa_pajak'); ?>" class="tb" /> </td>
            </tr>
            <tr>
                <td> Pemeriksaan &raquo; </td>
                <td> <textarea name="txt_pemeriksaan" cols="50" rows="5"><?php echo $this->antclass->back_value(@$bts->pemeriksaan, 'txt_pemeriksaan'); ?></textarea> </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input type="submit" name="submit" value="<?php echo $submitvalue; ?>" class="bt" />
                    <input type="reset" name="reset" value="Reset" class="bt" />
                    <input type="hidden" name="h_rec_id" value="<?php echo $rec_id; ?>" />
                </td>
            </tr>
        </table>
    </form>
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

        $("#datepicker2").datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            showOn: 'button',
            buttonImage: '<?= base_url_img() ?>calendar.gif',
            buttonImageOnly: true
        });

        $("#id_nop").mask(<?php echo "'" . $this->config->item('input_nop_id') . "'"; ?>);
    });
</script>