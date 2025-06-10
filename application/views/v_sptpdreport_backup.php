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
<h1>Laporan SSPD - BPHTB</h1>
<form name="frm_s_sptpd" method="post" action="<?= $c_loc ?>/go_report">
    <div class="nav_box">
        <div style="margin-bottom: 10px; text-align: center;">
            Tanggal: <input id="datepicker" type="text" name="txt_c_tgl_awal" style="width: 70px;" value="<?php if ($this->uri->segment(3) != '') {
                                                                                                                echo $this->uri->segment(3);
                                                                                                            } ?>" class="tb" /> -
            <input id="datepicker2" type="text" name="txt_c_tgl_akhir" style="width: 70px;" value="<?php if ($this->uri->segment(4) != '') {
                                                                                                        echo $this->uri->segment(4);
                                                                                                    } ?>" class="tb" />
        </div>
        <div style="margin-bottom: 10px; text-align: center;">
            Payment Point:
            <select name="txt_c_pp">
                <option value="">Semua</option>
                <option value="DISPENDA">DISPENDA</option>
                <?php foreach ($paymentpoint as $pp) : ?>
                    <option value="<?php echo $pp->id_pp; ?>" <?php if ($this->uri->segment(5) == $pp->id_pp) {
                                                                    echo 'selected="selected"';
                                                                } ?>><?php echo $pp->nama; ?></option>
                <?php endforeach; ?>
            </select>
            &nbsp;&nbsp;
            PPAT:
            <select name="txt_c_ppat">
                <option value="">Semua</option>
                <?php foreach ($ppats as $ppat) : ?>
                    <option value="<?php echo $ppat->id_ppat; ?>" <?php if ($this->uri->segment(6) == $ppat->id_ppat) {
                                                                        echo 'selected="selected"';
                                                                    } ?>><?php echo $ppat->nama . ' (' . $this->antclass->add_ppat_separator($ppat->id_ppat) . ')'; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div style="margin-bottom: 10px; text-align: center;">
            Dasar Setoran:
            <label for="c_pwp_id"><input id="c_pwp_id" type="checkbox" name="txt_c_setoran_pwp" value="PWP" <?php if ($this->uri->segment(7) == 'PWP') {
                                                                                                                echo 'checked="checked"';
                                                                                                            } ?> /> Perhitungan Wajib Pajak</label>
            &nbsp;&nbsp;
            <label for="c_stb_id"><input id="c_stb_id" type="checkbox" name="txt_c_setoran_stb" value="SKB" <?php if ($this->uri->segment(8) == 'SKB') {
                                                                                                                echo 'checked="checked"';
                                                                                                            } ?> /> STB</label>
            &nbsp;&nbsp;
            <label for="c_skbkb_id"><input id="c_skbkb_id" type="checkbox" name="txt_c_setoran_skbkb" value="SKBKB" <?php if ($this->uri->segment(9) == 'SKBKB') {
                                                                                                                        echo 'checked="checked"';
                                                                                                                    } ?> /> SKBKB</label>
            &nbsp;&nbsp;
            <label for="c_skbkbt_id"><input id="c_skbkbt_id" type="checkbox" name="txt_c_setoran_skbkbt" value="SKBKBT" <?php if ($this->uri->segment(10) == 'SKBKBT') {
                                                                                                                            echo 'checked="checked"';
                                                                                                                        } ?> /> SKBKBT</label>
        </div>
        <div style="margin-bottom: 10px; text-align: center;">
            User:
            <select name="txt_c_user">
                <option value="">Semua</option>
                <?php foreach ($users as $u) : ?>
                    <option value="<?php echo $u->username; ?>" <?php if ($this->uri->segment(11) == $u->username) {
                                                                    echo 'selected="selected"';
                                                                } ?>><?php echo $u->username; ?></option>
                <?php endforeach; ?>
            </select>
            &nbsp;&nbsp;
            Nomor Dokumen:
            <input type="text" name="txt_c_nodok" value="<?php if ($this->uri->segment(12) != '') {
                                                                echo $this->uri->segment(12);
                                                            } ?>" class="tb" />
        </div>
        <div align="center" style="margin-top: 2px;">
            <input type="submit" name="search_submit" value="Cari" class="bt" />
            <input type="submit" name="submit_print_all" value="Print" class="bt" />
        </div>
        <div><a href="<?php echo $c_loc; ?>/report">[ Kosongkan Filter ]</a></div>
    </div>
</form>
<?php if (!empty($info)) {
    echo $info;
} ?>
<?php if (!$sptpds) : echo 'Data SPTPD kosong.';
else : ?>
    <div class="listform">
        <form name="frm_sptpd" method="post" action="">
            <table>
                <tr class="tblhead">
                    <td>No</td>
                    <td style="width: 70px;">Tanggal</td>
                    <td style="width: 150px;">NOP</td>
                    <td style="width: 170px;">Payment Point</td>
                    <td>Jumlah Setor</td>
                    <td style="width: 45px;">Action</td>
                </tr>
                <?php
                $i = 1;
                $l = 0;
                $sub_total = 0;
                foreach ($sptpds as $sptpd) :
                ?>
                    <tr class="tblhov" bgcolor="<?php if ($i % 2) : echo "#E5E5E5";
                                                else : echo "#F5F5F5";
                                                endif; ?>">
                        <td><?php echo $start + $i; ?></td>
                        <td><?php echo $this->antclass->fix_date($sptpd->tanggal); ?></td>
                        <td><?php echo $this->antclass->add_nop_separator($sptpd->nop); ?></td>
                        <td>
                            <?php
                            if (empty($sptpd->id_pp)) {
                                echo 'DISPENDA';
                            } else {
                                $pp_det = $this->mod_paymentpoint->get_paymentpoint($sptpd->id_pp);
                                echo '<a href="javascript:void()" onclick="$(\'#alamat_pp_' . $i . '\').toggle();">' . $pp_det->nama . '</a>';
                                echo '<div id="alamat_pp_' . $i . '" style="display: none;">Alamat: ' . $pp_det->alamat . '</div>';
                            }
                            ?>
                        </td>
                        <td>
                            <div style="float: left;">Rp. </div>
                            <div style="float: right;"><?php echo number_format($sptpd->jumlah_setor, 0, ',', '.'); ?></div>
                            <div style="clear: both;"></div>
                        </td>
                        <td align="center">
                            <a href="<?php echo base_url(); ?>index.php/sptpd/printform/<?php echo $sptpd->id_sptpd; ?>"><img src="<?php echo base_url_img(); ?>print.gif" title="Print" alt="Print" /></a>
                            <?php if ($this->session->userdata('s_tipe_bphtb') == 'B') : if ($sptpd->is_lunas == '0') : ?>
                                    <a href="<?php echo base_url(); ?>index.php/sptpd/setlunas/<?php echo $sptpd->id_sptpd . '/' . $sptpd->no_dokumen; ?>"><img src="<?php echo base_url_img(); ?>lunas.png" title="Set Lunas" alt="Set Lunas" /></a>
                            <?php endif;
                            endif; ?>
                        </td>
                    </tr>
                <?php $i++;
                    $l++;
                    $sub_total += $sptpd->jumlah_setor;
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
                        <div style="float: right;"><?php echo number_format($sum_jumlah_setor->grand_total, 0, ',', '.'); ?></div>
                    </td>
                    <td></td>
                </tr>
            </table>


        </form>
    </div>
    <div class="paging"><?php echo $page_link; ?></div>
<?php endif; ?>