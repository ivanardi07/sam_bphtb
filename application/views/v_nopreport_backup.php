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
<h1>Laporan Perubahan NOP</h1>
<form name="frm_s_nop" method="post" action="<?= $c_loc ?>/go_report">
    <div class="nav_box">
        <div align="center">
            <div style="margin-bottom: 10px;">
                Tanggal: <input id="datepicker" type="text" name="txt_c_tgl_awal" style="width: 70px;" value="<?php if ($this->uri->segment(3) != '') {
                                                                                                                    echo $this->uri->segment(3);
                                                                                                                } ?>" class="tb" /> -
                <input id="datepicker2" type="text" name="txt_c_tgl_akhir" style="width: 70px;" value="<?php if ($this->uri->segment(4) != '') {
                                                                                                            echo $this->uri->segment(4);
                                                                                                        } ?>" class="tb" />
            </div>
            <div style="margin-bottom: 10px;">
                NOP Lama: <input type="text" name="txt_c_nop_lama" style="width: 200px" class="tb" value="<?php if ($this->uri->segment(5) == '-' or $this->uri->segment(5) != '') {
                                                                                                                echo $this->antclass->add_nop_separator($this->uri->segment(5));
                                                                                                            } ?>" />
                &nbsp;
                NOP Baru: <input type="text" name="txt_c_nop_baru" style="width: 200px" class="tb" value="<?php if ($this->uri->segment(6) == '-' or $this->uri->segment(6) != '') {
                                                                                                                echo $this->antclass->add_nop_separator($this->uri->segment(6));
                                                                                                            } ?>" />
            </div>
            <div align="center" style="margin-top: 2px;">
                <input type="submit" name="search_submit" value="Cari" class="bt" />
                <input type="submit" name="submit_print_all" value="Print" class="bt" />
            </div>
        </div>
        <div><a href="<?php echo $c_loc; ?>/report">[ Kosongkan Filter ]</a></div>
    </div>
</form>
<?php if (!empty($info)) {
    echo $info;
} ?>
<?php if (!$nops) : echo 'Data perubahan NOP kosong.';
else : ?>
    <div class="listform">
        <form name="frm_nop" method="post" action="">
            <table>
                <tr class="tblhead">
                    <td>No</td>
                    <td style="width: 140px;">Tanggal</td>
                    <td>NOP Lama</td>
                    <td>NOP Baru</td>
                </tr>
                <?php
                $i = 1;
                $l = 0;
                $sub_total = 0;
                foreach ($nops as $nop) :
                ?>
                    <tr class="tblhov" bgcolor="<?php if ($i % 2) : echo "#E5E5E5";
                                                else : echo "#F5F5F5";
                                                endif; ?>">
                        <td><?php echo $start + $i; ?></td>
                        <td align="center"><?php echo $this->antclass->fix_datetime($nop->tanggal); ?></td>
                        <td><a href="<?php echo base_url(); ?>index.php/nop/edit/<?php echo $nop->nop_lama; ?>"><?php echo $this->antclass->add_nop_separator($nop->nop_lama); ?></a></td>
                        <td><a href="<?php echo base_url(); ?>index.php/nop/edit/<?php echo $nop->nop_baru; ?>"><?php echo $this->antclass->add_nop_separator($nop->nop_baru); ?></a></td>
                    </tr>
                <?php $i++;
                    $l++;
                endforeach; ?>
            </table>
        </form>
    </div>
    <div class="paging"><?php echo $page_link; ?></div>
<?php endif; ?>