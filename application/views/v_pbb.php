<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

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
    });
</script>
<h1>Pembayaran PBB</h1>
<form name="frm_s_pbb" method="post" action="<?= $c_loc ?>/go_report">
    <div class="nav_box">
        <div style="margin-bottom: 10px;">
            NOP: <input type="text" name="txt_c_nop_pbb" style="width: 100px;" value="<?php if ($this->uri->segment(3) != '') {
                                                                                            echo $this->uri->segment(3);
                                                                                        } ?>" class="tb" />&nbsp;&nbsp;
            Tanggal: <input id="datepicker" type="text" name="txt_c_tgl_awal" style="width: 70px;" value="<?php if ($this->uri->segment(4) != '') {
                                                                                                                echo $this->uri->segment(3);
                                                                                                            } ?>" class="tb" /> -
            <input id="datepicker2" type="text" name="txt_c_tgl_akhir" style="width: 70px;" value="<?php if ($this->uri->segment(5) != '') {
                                                                                                        echo $this->uri->segment(4);
                                                                                                    } ?>" class="tb" />
        </div>
        <div align="center" style="margin-top: 2px;"><input type="submit" name="search_submit" value="Cari" class="bt" /></div>
        <div><a href="<?php echo $c_loc; ?>/report">[ Kosongkan Filter ]</a></div>
    </div>
</form>
<?php if (!empty($info)) {
    echo $info;
} ?>
<?php if (!$nop_pbbs) : echo 'Data PBB kosong.';
else : ?>
    <div class="listform">
        <form name="frm_nop_pbb" method="post" action="">
            <table>
                <tr class="tblhead">
                    <td colspan="2">No</td>
                    <td style="width: 80px;">Jatuh Tempo</td>
                    <td>NOP</td>
                    <td>Jumlah Bayar</td>
                    <td style="width: 45px;">Action</td>
                </tr>
                <?php
                $i = 1;
                $l = 0;
                $sub_total = 0;
                foreach ($nop_pbbs as $nop_pbb) :
                ?>
                    <tr class="tblhov" bgcolor="<?php if ($i % 2) : echo "#E5E5E5";
                                                else : echo "#F5F5F5";
                                                endif; ?>">
                        <td><?php echo $start + $i; ?></td>
                        <td style="width: 13px;"> <input type="checkbox" name="check[]" id="id<?php echo $l; ?>" value="<?php echo $nop_pbb->nop; ?>" /> </td>
                        <td><?php echo $this->antclass->fix_date($nop_pbb->tanggal_jatuh_tempo); ?></td>
                        <td><?php echo $this->antclass->add_nop_separator($nop_pbb->nop); ?></td>
                        <td>
                            <div style="float: left;">Rp. </div>
                            <div style="float: right;"><?php echo number_format($nop_pbb->pbb_bayar, 0, ',', '.'); ?></div>
                            <div style="clear: both;"></div>
                        </td>
                        <td align="center">
                            <a href="<?php echo base_url(); ?>index.php/pbb/printform/<?php echo $nop_pbb->nop; ?>"><img src="<?php echo base_url_img(); ?>print.gif" title="Print" alt="Print" /></a>
                        </td>
                    </tr>
                <?php $i++;
                    $l++;
                    $sub_total += $nop_pbb->pbb_bayar;
                endforeach; ?>
                <tr>
                    <td colspan="4" align="right"> Sub Total: </td>
                    <td>
                        <div style="float: left;">Rp. </div>
                        <div style="float: right;"><?php echo number_format($sub_total, 0, ',', '.'); ?></div>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="4" align="right"> Grand Total: </td>
                    <td>
                        <div style="float: left;">Rp. </div>
                        <div style="float: right;"><?php echo number_format($sum_pbb_bayar->grand_total, 0, ',', '.'); ?></div>
                    </td>
                    <td></td>
                </tr>
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