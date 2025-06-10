<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php
$this->load->helper('form');
$type_user = $this->session->userdata('s_username_bphtb');

$type = $this->session->userdata('s_tipe_bphtb');
$jabatan = $this->session->userdata('jabatan');

if ($type == 'PT') {
    $id_user = $this->session->userdata('s_id_ppat');
} elseif ($type == 'D') {
    $id_user = $this->session->userdata('s_id_dispenda');
} elseif ($type == 'PP') {
    $id_user = $this->session->userdata('s_id_paymentpoint');
} elseif ($type == 'KPP') {
    $id_user = $this->session->userdata('s_id_kpp');
}

// echo $type.' - '.$id_user;
// exit;

?>

<!-- PAGE TITLE -->
<div class="page-title">
    <h2><span class="fa fa-arrow-circle-o-left"></span> <?= (isset($report['title'])) ? $report['title'] : ''; ?></h2>
</div>

<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">

                    <div class="row">
                        <div class="col-md-6">
                        </div>
                        <?php echo form_open('cek_nop', array('name' => 'form1', 'onSubmit' => 'return ChekForm();', 'class' => 'form-horizontal')); ?>
                        <div class="form-group">
                            <div class="col-md-4">
                                <label for="nama" class="col-sm-3 control-label">NO SSPD</label>
                                <div class="col-sm-9">
                                    <!-- <input name="NOP" size="25" id="nop" type="text"  autocomplete='off'  class="form-control" value="<?php echo @$form['NOP']; ?>"/> -->
                                    <input name="no_sspd" id="no_sspd" size="25" type="text" class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-1 text-center">
                                <input name="txt_submit" type="submit" value="Search" class="btn btn-info">
                            </div>
                        </div>
                        <?php echo form_close(); ?>

                    </div>

                </div>

                <?php if (isset($report['valid']) && ($report['valid'] == true)) : ?>

                    <form name="frm_cek_dinas" method="post" action="<?php echo site_url('cek_nop/proses_validasi/' . $type) ?>">
                        <div class="panel-body">

                            <?php if ($row['validasi_bank'] && $type == 'PP') : ?>
                                <a class="btn btn-info" href="javascript:void()" onclick="$('.tbl_print').printElement({overrideElementCSS:['<?= base_url_css() ?>bphtb_stylo_print.css']});">Cetak Bukti Pembayaran</a>

                                <a class="btn btn-danger" href="<?= site_url('cek_nop/batal_bayar/' . encode(@$row['no_dokumen'])) ?>" onclick="return confirm('Anda Yakin Akan Melakukan Pembatalan Pembayaran?')">Batalkan Pembayaran</a>
                                <br>
                                <br>
                            <?php endif ?>

                            <table align="center" class="table table-bordered table-hover" cellspacing="2" width="100%">


                                <tr>
                                    <td width="150" class="fields_label" align="left">Nomor Dokumen</td>
                                    <td width="1" align="center">:</td>
                                    <td class="linebottom">
                                        <span class="text_header"><?php echo @$row['no_dokumen']; ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="150" class="fields_label" align="left">NOP</td>
                                    <td width="1" align="center">:</td>
                                    <td class="linebottom">
                                        <span class="text_header"><?php echo $this->quotes->add_nop_separator($row['kd_propinsi'] . $row['kd_kabupaten'] . $row['kd_kecamatan'] . $row['kd_kelurahan'] . $row['kd_blok'] . $row['no_urut'] . $row['kd_jns_op']); ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fields_label" align="left">Tanggal Pembuatan</td>
                                    <td align="center">:</td>
                                    <td class="linebottom"><span class="text_header"><?php echo $this->tanggal->date_formatter($row['tanggal']); ?></span></td>
                                </tr>
                                <tr>
                                    <td class="fields_label" align="left">Jumlah Setor</td>
                                    <td align="center">:</td>
                                    <td class="linebottom"><span class="text_header">Rp. <?php echo number_format($row['jumlah_setor'], 0, ',', '.'); ?></span></td>
                                </tr>
                                <tr>
                                    <td class="fields_label" align="left" valign="top">Terbilang</td>
                                    <td align="center">:</td>
                                    <td class="linebottom"><span class="text_header"><?php echo ucwords($this->terbilang->toTerbilang($row['jumlah_setor'])) . ' Rupiah'; ?></span></td>
                                </tr>
                                <?php if (($type == 'PT' || $type == 'PP') && $row['tgl_validasi_dispenda'] == '') : ?>

                                <?php else : ?>
                                    <tr>
                                        <td class="fields_label" align="left" valign="top">Tanggal Verifikasi Bapenda</td>
                                        <td align="center">:</td>
                                        <td class="linebottom">
                                            <div class="col-md-4" style="margin-left:-13px;">
                                                <input type="text" class="form-control tanggal" name="tgl_validasi_dispenda" placeholder="Tanggal Verifikasi Bapenda" value="<?= ($row['tgl_validasi_dispenda'] == '') ? date('d-m-Y') : changeDateFormat('webview', $row['tgl_validasi_dispenda']) ?>" required <?= ($row['tgl_validasi_dispenda'] != '') ? 'readonly' : ''; ?>>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endif ?>
                                <tr>
                                    <td class="fields_label" align="left" valign="top">Verifikasi Bapenda</td>
                                    <td align="center">:</td>
                                    <td class="linebottom"><span class="text_header"><?php echo ($row['validasi_dispenda']) ? 'Sudah Diverifikasi' : 'Belum Diverifikasi'; ?></span></td>
                                </tr>
                                <?php if ($row['alasan_reject'] != '' && $type !== 'PP') : ?>
                                    <tr>
                                        <td class="fields_label" align="left" valign="top">Alasan Reject</td>
                                        <td align="center">:</td>
                                        <td class="linebottom"><span class="text_header"><b><?php echo $row['alasan_reject']; ?></b></span></td>
                                    </tr>
                                <?php endif ?>

                                <tr>
                                    <td class="fields_label" align="left" valign="top">Verifikasi Bank</td>
                                    <td align="center">:</td>
                                    <td class="linebottom"><span class="text_header"><?php echo ($row['validasi_bank']) ? 'Sudah Diverifikasi <br><br>  ' . getNamaBank($row['id_bank'], 'nama') . ' <br>  ' . getNamaBank($row['id_bank'], 'alamat') . ' ' : 'Belum Diverifikasi'; ?></span></td>
                                </tr>

                                <tr>
                                    <td class="fields_label" align="left" valign="top">Kode Verifikasi</td>
                                    <td align="center">:</td>
                                    <td class="linebottom">
                                        <?php if ($type != 'PT') : ?>
                                            <?php if (($row['validasi_dispenda'] == '' && $type == 'D') || ($row['validasi_bank'] == '' && $type == 'PP')) { ?>
                                                <input name="kode_approval" id="kode_approval" autocomplete='off' size="40" type="text" class="fields_input" value="<?php echo @$approval->value; ?>" />&nbsp; <span class="text_header" style="color:red"><?php echo @$approval->error; ?></span>
                                            <?php } else { ?>
                                                <?php echo @$row['validasi_dispenda']; ?>
                                            <?php } ?>

                                        <?php else : ?>
                                            <?php if ($row['validasi_dispenda'] == '' || $row['validasi_bank'] == '') { ?>

                                            <?php } else { ?>
                                                <?php echo @$row['kode_validasi']; ?>
                                            <?php }
                                            ?>
                                        <?php endif; ?>
                                    </td>
                                </tr>

                                <?php if (($row['validasi_dispenda'] == '' || $row['validasi_bank'] == '') && ($type == 'D' || $type == 'PP')) { ?>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <?php if ($type == 'D') { ?>
                                                <?php if ($row['validasi_dispenda'] == '') : ?>
                                                    <input type="submit" name="submit_approval" value="Setujui" class="btn btn-primary" />
                                                    <a class="btn btn-danger" data-toggle="modal" data-target="#myModal" /> Reject </a>
                                                    <input type="hidden" name="txt_id_sptpd" value="<?php echo $row['id_sptpd']; ?>" />
                                                    <input type="hidden" name="cek_kode_validasi_dispenda" value="<?php echo @$row['validasi_dispenda']; ?>" />
                                                    <input type="hidden" name="id_user" value="<?php echo $id_user; ?>" />
                                                    <input type="hidden" name="txt_id_nop" value="<?php echo $this->quotes->add_nop_separator($row['kd_propinsi'] . $row['kd_kabupaten'] . $row['kd_kecamatan'] . $row['kd_kelurahan'] . $row['kd_blok'] . $row['no_urut'] . $row['kd_jns_op']); ?>" />
                                                    <input name="NOP" type="hidden" value="<?php echo @$form['NOP']; ?>" />
                                                <?php else : ?>
                                                    <b>Status disetujui oleh Badan Pendapatan Daerah.</b>
                                                <?php endif ?>
                                            <?php } else if ($type == 'PP') { ?>
                                                <?php if ($row['validasi_bank'] == '') : ?>
                                                    <input type="submit" name="submit_approval" value="Setujui" class="btn btn-primary" />
                                                    <input type="hidden" name="txt_id_sptpd" value="<?php echo $row['id_sptpd']; ?>" />
                                                    <input type="hidden" name="cek_kode_validasi_dispenda" value="<?php echo @$row['validasi_dispenda']; ?>" />
                                                    <input type="hidden" name="id_user" value="<?php echo $id_user; ?>" />
                                                    <input type="hidden" name="txt_id_nop" value="<?php echo $this->quotes->add_nop_separator($row['kd_propinsi'] . $row['kd_kabupaten'] . $row['kd_kecamatan'] . $row['kd_kelurahan'] . $row['kd_blok'] . $row['no_urut'] . $row['kd_jns_op']); ?>" />
                                                    <input name="NOP" type="hidden" value="<?php echo @$form['NOP']; ?>" />
                                                <?php else : ?>
                                                    <b>Status disetujui oleh Badan Pendapatan Daerah dan Bank.</b>
                                                <?php endif ?>
                                            <?php } ?>

                                        </td>
                                    </tr>
                                <?php } elseif ($type == 'D' || $type == 'PP') { ?>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <?php if ($row['validasi_dispenda'] != '' && $row['validasi_bank'] != '') : ?>
                                                <b>Status disetujui oleh Badan Pendapatan Daerah dan Bank.</b>
                                            <?php else : ?>

                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </div>

                        <div class="panel-footer">
                            <div class="row">
                                <div class="col-md-6">
                                </div>
                                <div class="col-md-offset-2 col-md-4">
                                    <!-- PAGINATION BELUM -->


                                </div>
                            </div>
                        </div>
                    </form>
                <?php endif; ?>
                <?php echo $this->session->flashdata('flash_msg'); ?>
            </div </div>

        </div>
    </div>

</div>

<div hidden>
    <table align="center" class="table table-bordered table-hover tbl_print" cellspacing="2" width="100%">

        <tr>
            <td width="150" class="fields_label" align="left">Nomor Dokumen</td>
            <td width="1" align="center">:</td>
            <td class="linebottom">
                <span class="text_header"><?php echo @$row['no_dokumen']; ?></span>
            </td>
        </tr>
        <tr>
            <td width="150" class="fields_label" align="left">NOP</td>
            <td width="1" align="center">:</td>
            <td class="linebottom">
                <span class="text_header"><?php
                                            echo $this->quotes->add_nop_separator(
                                                $row['kd_propinsi'] .
                                                    $row['kd_kabupaten'] .
                                                    $row['kd_kecamatan'] .
                                                    $row['kd_kelurahan'] .
                                                    $row['kd_blok'] .
                                                    $row['no_urut'] .
                                                    $row['kd_jns_op']
                                            );
                                            ?>
                </span>
            </td>
        </tr>
        <tr>
            <td class="fields_label" align="left">Tanggal Pembuatan</td>
            <td align="center">:</td>
            <td class="linebottom"><span class="text_header"><?php echo $this->tanggal->date_formatter($row['tanggal']); ?></span></td>
        </tr>
        <tr>
            <td class="fields_label" align="left">Jumlah Setor</td>
            <td align="center">:</td>
            <td class="linebottom"><span class="text_header">Rp. <?php echo number_format($row['jumlah_setor'], 0, ',', '.'); ?></span></td>
        </tr>
        <tr>
            <td class="fields_label" align="left" valign="top">Terbilang</td>
            <td align="center">:</td>
            <td class="linebottom"><span class="text_header"><?php echo ucwords($this->terbilang->toTerbilang($row['jumlah_setor'])) . ' Rupiah'; ?></span></td>
        </tr>

        <tr>
            <td class="fields_label" align="left">Tanggal Verifikasi Bapenda</td>
            <td align="center">:</td>
            <td class="linebottom"><span class="text_header"><?php echo changeDateFormat('webview', $row['tgl_validasi_dispenda']); ?></span></td>
        </tr>
        <tr>
            <td class="fields_label" align="left" valign="top">Status Verifikasi Bapenda</td>
            <td align="center">:</td>
            <td class="linebottom"><span class="text_header"><?php echo ($row['validasi_dispenda']) ? 'Sudah Diverifikasi' : 'Belum Diverifikasi '; ?></span></td>
        </tr>
        <?php if ($row['alasan_reject'] != '' && $type !== 'PP') : ?>
            <tr>
                <td class="fields_label" align="left" valign="top">Alasan Reject</td>
                <td align="center">:</td>
                <td class="linebottom"><span class="text_header"><?php echo $row['alasan_reject']; ?></span></td>
            </tr>
        <?php endif ?>
        <tr>
            <td class="fields_label" align="left">Tanggal Verifikasi BANK</td>
            <td align="center">:</td>
            <td class="linebottom"><span class="text_header"><?php echo changeDateFormat('webview', $row['tgl_validasi_bank']); ?></span></td>
        </tr>
        <tr>
            <td class="fields_label" align="left" valign="top">Status Verifikasi Bank</td>
            <td align="center">:</td>
            <td class="linebottom"><span class="text_header"><?php echo ($row['validasi_bank']) ? 'Sudah Diverifikasi <br><br>  ' . getNamaBank($row['id_bank'], 'nama') . ' <br>  ' . getNamaBank($row['id_bank'], 'alamat') . ' ' : 'Belum Diverifikasi'; ?></span></td>
        </tr>

    </table>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Reject Validasi</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="form_reject">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Alasan</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" id="exampleInputName2" name="alasan_reject" id="alasan_reject"></textarea>
                            <input type="hidden" id="no_dokumen" name="no_dokumen" value="<?= @$row['no_dokumen'] ?>">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" onclick="saveReject();" class="btn btn-primary">Reject</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    jQuery(function($) {
        $("#no_sspd").mask("99.99.9999.9999.999");
        $("#kode_approval").mask("99.99.9999.9999.9999");
    });

    function saveReject() {
        $.ajax({
            type: 'POST',
            url: "<?= site_url('Cek_nop/rejectDokumen') ?>",
            data: $('#form_reject').serialize()
        }).done(function(hasil) {
            $('#myModal').modal('hide');
            alert(hasil);
            window.location = "<?= site_url('Cek_nop') ?>";
        });
    }
</script>