<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<h1><a href="<?php echo $c_loc; ?>">Jenis Setoran</a> &raquo; <?php echo $submitvalue; ?></h1>
<div class="nav_box">
    [ <a href="<?php echo $c_loc; ?>">Kembali</a> ]
</div>
<?php if (!empty($info)) {
    echo $info;
} ?>
<div class="inputform">
    <form name="frm_jns_setoran" method="post" action="">
        <table>
            <tr>
                <td width="150"> Kode Jenis Setoran &raquo; </td>
                <td> <input type="text" name="txt_kd_jns_setoran" id="jns_setoran_id" style="width: 50px;" maxlength="2" value="<?php echo $this->antclass->back_value(@$jns_setoran->kd_setoran, 'txt_kd_jns_setoran'); ?>" <?php if ($submitvalue == 'Edit') {
                                                                                                                                                                                                                                    echo 'disabled="disabled"';
                                                                                                                                                                                                                                } ?> /> </td>
            </tr>
            <tr>
                <td> Nama &raquo; </td>
                <td> <input type="text" name="txt_nama_jns_setoran" style="width: 300px;" maxlength="100" value="<?php echo $this->antclass->back_value(@$jns_setoran->nama, 'txt_nama_jns_setoran'); ?>" /> </td>
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