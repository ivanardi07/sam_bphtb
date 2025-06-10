<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<h1><a href="<?php echo $c_loc; ?>">Prefix</a> &raquo; <?php echo $submitvalue; ?></h1>
<div class="nav_box">
    [ <a href="<?php echo $c_loc; ?>">Kembali</a> ]
</div>
<?php if (!empty($info)) {
    echo $info;
} ?>
<div class="inputform">
    <form name="frm_prefix" method="post" action="">
        <table>
            <tr>
                <td width="120"> Nama Prefix &raquo; </td>
                <td> <input type="text" name="txt_nama_prefix" id="prefix_id" style="width: 50px;" maxlength="3" value="<?php echo $this->antclass->back_value(@$prefix->nama, 'txt_nama_prefix'); ?>" class="tb" /> </td>
            </tr>
            <tr>
                <td> Keterangan Prefix &raquo; </td>
                <td> <input type="text" name="txt_keterangan_prefix" style="width: 400px;" maxlength="200" value="<?php echo $this->antclass->back_value(@$prefix->keterangan, 'txt_keterangan_prefix'); ?>" class="tb" /> </td>
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