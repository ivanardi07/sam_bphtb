<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/template/css/bootstrap/datepicker.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/template/css/bootstrap/datepicker3.css">
<script type="text/javascript">
    $(function() {
        $("#datepicker").datepicker({
            format: 'yyyy-mm-dd',
            changeMonth: true,
            changeYear: true,
            showOn: 'button',
            buttonImage: '<?= base_url_img() ?>calendar.gif',
            buttonImageOnly: true
        });

        $("#datepicker2").datepicker({
            format: 'yyyy-mm-dd',
            changeMonth: true,
            changeYear: true,
            showOn: 'button',
            buttonImage: '<?= base_url_img() ?>calendar.gif',
            buttonImageOnly: true
        });
    });
</script>
<!-- PAGE TITLE -->
<div class="page-title">
    <h2><span class="fa fa-arrow-circle-o-left"></span> Laporan SSPD - BPHTB</h2>
</div>
<!-- END PAGE TITLE -->
<div class="page-content-wrap">
    <div class="col-md-12" style="margin-bottom: 10px;">
        <form name="frm_s_nop" method="post" action="<?= $c_loc ?>/go_report">
            <table>
                <tr>
                    <td style="padding-left: 60px">
                        <center>
                            <h5>Tanggal Awal</h5>
                        </center><br>
                    </td>
                    <td style="padding-left: 60px;padding-bottom: 20px">
                        <div class="input-group">
                            <input id="datepicker" type="text" name="txt_c_tgl_awal" value="<?php if ($this->uri->segment(3) != '') {
                                                                                                echo $this->uri->segment(3);
                                                                                            } ?>" class="form-control" />
                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                    </td>
                    <td style="padding-left: 10px;padding-bottom: 20px">
                        <center>
                            <h5>s/d</h5>
                        </center>
                    </td>
                    <td style="padding-left: 10px;padding-bottom: 20px">
                        <div class="input-group">
                            <input id="datepicker2" type="text" name="txt_c_tgl_akhir" value="<?php if ($this->uri->segment(4) != '') {
                                                                                                    echo $this->uri->segment(4);
                                                                                                } ?>" class="form-control" />
                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                    </td>
                </tr>
            </table>
            <div class="row">
                <div class="col-md-6">
                    <div class="col-md-5">
                        <center>
                            <h5>Payment Point</h5>
                        </center><br>
                        <center>
                            <h5>PPAT</h5>
                        </center><br>
                        <center>
                            <h5>Dasar Setoran</h5>
                        </center><br>
                        <center>
                            <h5>Status</h5>
                        </center>
                        <center style="margin-top:35px;">
                            <h5>No SSPD</h5>
                        </center>
                    </div>
                    <div class="col-md-7">
                        <div>
                            <select name="txt_c_pp" class="form-control select2">
                                <option value="">Semua</option>
                                <?php foreach ($paymentpoint as $pp) : ?>
                                    <option value="<?php echo $pp->id_pp; ?>" <?php if ($this->uri->segment(5) == $pp->id_pp) {
                                                                                    echo 'selected="selected"';
                                                                                } ?>><?php echo $pp->nama; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <br>
                        <div>
                            <select name="txt_c_ppat" class="form-control select2">
                                <option value="">Semua</option>
                                <?php foreach ($ppats as $ppat) : ?>
                                    <option value="<?php echo $ppat->id_ppat; ?>" <?php if ($this->uri->segment(6) == $ppat->id_ppat) {
                                                                                        echo 'selected="selected"';
                                                                                    } ?>><?php echo $ppat->nama; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div style="margin-top:20px;">
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
                        <div>
                            <select name="txt_c_status" class="form-control select2">
                                <option value="" <?php echo ($this->uri->segment(13) == '') ? 'selected' : ''; ?>>Semua</option>
                                <option value="lunas" <?php echo ($this->uri->segment(13) == 'lunas') ? 'selected' : ''; ?>>Lunas</option>
                                <option value="belum" <?php echo ($this->uri->segment(13) == 'belum') ? 'selected' : ''; ?>>Belum Lunas</option>
                                <option value="tidak_kena_pajak" <?php echo ($this->uri->segment(13) == 'tidak_kena_pajak') ? 'selected' : ''; ?>>Tidak Kena Pajak</option>
                            </select>
                        </div>
                        <div style="margin-top:20px;">
                            <input type="text" class="form-control" name="txt_c_nodok" value="<?= $this->uri->segment(12) ?>">
                        </div>
                    </div>
                </div>
                <div class="col-md-6"></div>
            </div>
            <div style="margin-left:241px; margin-top:20px; margin-bottom:20px;">
                <input type="submit" name="search_submit" value="Cari" class="btn btn-default" />
                <input type="submit" name="submit_print_all" value="Print" class="btn btn-default" />
            </div>
            <a style="margin-left:10px;" class="btn btn-default" href="<?php echo $c_loc; ?>/report"><span class="fa fa-refresh"></span>Kosongkan Filter</a>
            <?php if (!empty($info)) {
                echo $info;
            }
            ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">

                            <div class="row">
                                <div class="col-md-6">
                                </div>
                                <div class="col-md-6"></div>

                            </div>

                        </div>
        </form>

        <form name="frm_sptpd" method="post" action="">
            <div class="panel-body">
                <?php if (!$sptpds) : echo 'Data SPTPD kosong.';
                else : ?>
                    <table class="table table-bordered table-hover">
                        <tr class="tblhead">
                            <td width="1">No</td>
                            <td style="width: 140px;">Tanggal</td>
                            <td style="width: 150px;">NOP</td>
                            <td style="width: 150px;">NO. SSPD</td>
                            <td>NAMA WP</td>
                            <td>Payment Point</td>
                            <td>Jumlah Setor</td>
                            <td style="width: 45px;">Action</td>
                        </tr>
                        <?php
                        $i         = 1;
                        $l         = 0;
                        $sub_total = 0;
                        foreach ($sptpds as $sptpd) :
                        ?>
                            <tr class="tblhov" bgcolor="<?php if ($i % 2) : echo "#E5E5E5";
                                                        else : echo "#F5F5F5";
                                                        endif; ?>">
                                <td><?php echo $start + $i; ?></td>
                                <td><?php echo $this->antclass->fix_date($sptpd->tanggal); ?></td>
                                <td><?= $sptpd->kd_propinsi; ?>.<?= $sptpd->kd_kabupaten; ?>.<?= $sptpd->kd_kecamatan; ?>.<?= $sptpd->kd_kelurahan; ?>.<?= $sptpd->kd_blok; ?>.<?= $sptpd->no_urut; ?>.<?= $sptpd->kd_jns_op; ?></td>
                                <td><?php echo $sptpd->no_dokumen; ?></td>
                                <td>
                                    <?php
                                    $nik = $this->mod_nik->get_nik($sptpd->nik);
                                    echo @$nik->nama;
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if ($sptpd->is_lunas == '1') {
                                        echo 'Lunas';
                                    } else {
                                        if ($sptpd->jumlah_setor == '0') {
                                            echo 'Tidak Kena Pajak';
                                        } else {
                                            echo 'Belum Lunas';
                                        }
                                    }
                                    // if (empty($sptpd->id_bank)) {echo 'Belum Lunas';} else {
                                    // echo getNamaBank($sptpd->id_bank, 'nama');
                                    // }
                                    ?>
                                </td>
                                <td>
                                    <div style="float: left;">Rp. </div>
                                    <div style="float: right;"><?php echo number_format($sptpd->jumlah_setor, 0, ',', '.'); ?></div>
                                    <div style="clear: both;"></div>
                                </td>
                                <td align="center">
                                    <a class="btn btn-xs btn-success" target="_blank" href="<?php echo base_url(); ?>index.php/sptpd/printform/<?php echo $sptpd->id_sptpd; ?>"><span class="fa fa-print"></span></a>
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
                            <td colspan="6" align="right"> Sub Total: </td>
                            <td>
                                <div style="float: left;">Rp. </div>
                                <div style="float: right;"><?php echo number_format($sub_total, 0, ',', '.'); ?></div>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="6" align="right"> Jumlah Keseluruhan: </td>
                            <td>
                                <div style="float: left;">Rp. </div>
                                <div style="float: right;"><?php echo number_format($sum_jumlah_setor->grand_total, 0, ',', '.'); ?></div>
                            </td>
                            <td></td>
                        </tr>
                    </table>
            </div>

            <div class="panel-footer">
                <div class="row">
                    <div class="col-md-offset-2 col-md-4">
                        <!-- PAGINATION BELUM -->
                        <div class="dataTables_paginate paging_bootstrap pagination"><?php echo $page_link; ?></div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

</div>
</div>

</div>
<?php endif; ?>

<script type="text/javascript">
    $('#datepick input').datepicker({});
</script>

<script type="text/javascript" src="<?= base_url() ?>assets/template/js/bootstrap-datepicker.js"></script>