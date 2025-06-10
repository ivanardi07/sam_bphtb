<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<h1>Jenis Setoran</h1>
<div class="nav_box">
    [ <a href="<?php echo $c_loc; ?>/add">Tambah</a> ] |
    [ <a href="<?php echo $c_loc; ?>">Refresh Data</a> ]
</div>
<?php if (!empty($info)) {
    echo $info;
} ?>
<?php if (!$jns_setorans) : echo 'Data Jenis Setoran kosong.';
else : ?>
    <div class="listform">
        <form name="frm_jns_setoran" method="post" action="">
            <table>
                <tr class="tblhead">
                    <td colspan="2">No</td>
                    <td style="width: 150px;">Kode Setoran</td>
                    <td>Nama</td>
                    <td style="width: 45px;">Action</td>
                </tr>
                <?php
                $i = 1;
                $l = 0;
                foreach ($jns_setorans as $jns_setoran) :
                ?>
                    <tr class="tblhov" bgcolor="<?php if ($i % 2) : echo "#E5E5E5";
                                                else : echo "#F5F5F5";
                                                endif; ?>">
                        <td><?php echo $start + $i; ?></td>
                        <td style="width: 13px;"> <input type="checkbox" name="check[]" id="id<?php echo $l; ?>" value="<?php echo $jns_setoran->kd_setoran; ?>" /> </td>
                        <td><?php echo $jns_setoran->kd_setoran; ?></td>
                        <td><?php echo $jns_setoran->nama; ?></td>
                        <td>
                            <a href="<?php echo base_url(); ?>index.php/jns_setoran/edit/<?php echo $jns_setoran->kd_setoran; ?>"><img src="<?php echo base_url_img(); ?>edit.gif" title="Edit" alt="Edit" /></a>
                            <a href="<?php echo base_url(); ?>index.php/jns_setoran/delete/<?php echo $jns_setoran->kd_setoran; ?>" onclick="return confirm('Are you sure to delete &quot;<?php echo addslashes($jns_setoran->nama); ?>&quot;?')">
                                <img src="<?php echo base_url_img(); ?>trash.gif" title="Delete" alt="Delete" />
                            </a>
                        </td>
                    </tr>
                <?php $i++;
                    $l++;
                endforeach; ?>
            </table>
            <div style="margin: 5px 0 0 13px;">
                <img src="<?php echo base_url_img(); ?>leftup.gif" alt="" />
                <a href="#" onclick="for (k = 0; k < <?php echo $l; ?>; k++) document.getElementById('id'+k).checked = true;">Check All</a> -
                <a href="#" onclick="for (k = 0; k < <?php echo $l; ?>; k++) document.getElementById('id'+k).checked = false;">Uncheck All</a>
                - with selected :
                <button class="multi_submit" type="submit" name="submit_multi" value="delete" title="Delete" onclick="return confirm('Are you sure to delete these records status?')">
                    <img src="<?php echo base_url_img(); ?>trash.gif" title="Delete" alt="Delete" />
                </button>
            </div>
        </form>
    </div>
    <div class="paging"><?php echo $page_link; ?></div>
<?php endif; ?>