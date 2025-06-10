<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<h1>Prefix</h1>
<div class="nav_box">
    <?php if ($this->session->userdata('s_tipe_bphtb') == 'D') : ?>[ <a href="<?php echo $c_loc; ?>/add">Tambah</a> ] |<?php endif; ?>
    [ <a href="<?php echo $c_loc; ?>">Refresh Data</a> ]
</div>
<?php if (!empty($info)) {
    echo $info;
} ?>
<?php if (!$prefixs) : echo 'Data prefix kosong.';
else : ?>
    <div class="listform">
        <form name="frm_prefix" method="post" action="">
            <table>
                <tr class="tblhead">
                    <td colspan="<?php echo ($this->session->userdata('s_tipe_bphtb') == 'D') ? 2 : 1; ?>">No</td>
                    <td style="width: 150px;">Nama Bank</td>
                    <td>keterangan prefix</td>
                    <?php if ($this->session->userdata('s_tipe_bphtb') == 'D') : ?> <td style="width: 45px;">Action</td><?php endif; ?>
                </tr>
                <?php
                $i = 1;
                $l = 0;
                foreach ($prefixs as $prefix) :
                ?>
                    <tr class="tblhov" bgcolor="<?php if ($i % 2) : echo "#E5E5E5";
                                                else : echo "#F5F5F5";
                                                endif; ?>">
                        <td><?php echo $start + $i; ?></td>
                        <?php if ($this->session->userdata('s_tipe_bphtb') == 'D') : ?><td style="width: 13px;"> <input type="checkbox" name="check[]" id="id<?php echo $l; ?>" value="<?php echo $prefix->id; ?>" /> </td><?php endif; ?>
                        <td><?php echo $prefix->nama; ?></td>
                        <td><?php echo $prefix->keterangan; ?></td>
                        <?php if ($this->session->userdata('s_tipe_bphtb') == 'D') : ?>
                            <td>
                                <a href="<?php echo base_url(); ?>index.php/prefix/edit/<?php echo $prefix->id; ?>"><img src="<?php echo base_url_img(); ?>edit.gif" title="Edit" alt="Edit" /></a>
                                <a href="<?php echo base_url(); ?>index.php/prefix/delete/<?php echo $prefix->id; ?>" onclick="return confirm('Are you sure to delete &quot;<?php echo addslashes($prefix->nama); ?>&quot;?')">
                                    <img src="<?php echo base_url_img(); ?>trash.gif" title="Delete" alt="Delete" />
                                </a>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php $i++;
                    $l++;
                endforeach; ?>
            </table>
            <?php if ($this->session->userdata('s_tipe_bphtb') == 'D') : ?>
                <div style="margin: 5px 0 0 13px;">
                    <img src="<?php echo base_url_img(); ?>leftup.gif" alt="" />
                    <a href="#" onclick="for (k = 0; k < <?php echo $l; ?>; k++) document.getElementById('id'+k).checked = true;">Check All</a> -
                    <a href="#" onclick="for (k = 0; k < <?php echo $l; ?>; k++) document.getElementById('id'+k).checked = false;">Uncheck All</a>
                    - with selected :
                    <button class="multi_submit" type="submit" name="submit_multi" value="delete" title="Delete" onclick="return confirm('Are you sure to delete these records status?')">
                        <img src="<?php echo base_url_img(); ?>trash.gif" title="Delete" alt="Delete" />
                    </button>
                </div>
            <?php endif; ?>
        </form>
    </div>
    <div class="paging"><?php echo $page_link; ?></div>
<?php endif; ?>