<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<script type="text/javascript">
    function lookup_kecamatan(string) {
        if (string == '') {
            $('#kecamatan_id').html('');
        } else {
            $.post("<?php echo base_url(); ?>index.php/kecamatan/get_kecamatan_bydati2", {
                rx_kd_dati2: "" + string + ""
            }, function(data) {
                if (data.length > 0) {
                    $('#kecamatan_id').html(data);
                }
            });
        }
    }

    function lookup_kelurahan(string) {
        if (string == '') {
            $('#kelurahan_id').html('');
        } else {
            $.post("<?php echo base_url(); ?>index.php/kelurahan/get_kelurahan_bykecamatan", {
                rx_kd_kecamatan: "" + string + ""
            }, function(data) {
                if (data.length > 0) {
                    $('#kelurahan_id').html(data);
                }
            });
        }
    }
    <?php if ($submitvalue != 'Edit') : ?>
        jQuery(function($) {
            $("#nop_id").mask(<?php echo "'" . $this->config->item('input_nop_id') . "'"; ?>);
        });

        $(document).ready(function() {
            $('#nop_id').focusout(function() {
                var nilai_nop = $('#nop_id').val();
                var count_nop_length = nilai_nop.length;
                var count_nop_length2 = nilai_nop.replace('_', '');
                if (count_nop_length2.length < <?php echo $this->config->item('length_nop_id'); ?>) {
                    $('#nop_id').text(nilai_nop);
                    $('#nop_error').text('NOP harus <?php echo $this->config->item('length_nop_id'); ?> characters!!');
                    $('#nop_error').fadeIn(300).delay(1000).fadeOut('fast');
                    //alert('ID NOP harus <?php //echo $this->config->item('length_nop_id');
                                            ?> characters!!');
                }
            });
        });
    <?php endif; ?>
</script>
<h1><a href="<?php echo $c_loc; ?>">NOP</a> &raquo; <?php echo $submitvalue; ?></h1>
<div class="nav_box">
    [ <a href="<?php echo $c_loc; ?>">Kembali</a> ]
</div>
<?php if (!empty($info)) {
    echo $info;
} ?>
<div class="inputform">
    <form name="frm_nop" method="post" action="">
        <table>
            <tr>
                <td width="200"> NOP &raquo; </td>
                <td> <input autocomplete="off" type="text" name="txt_id_nop" id="nop_id" style="width: 150px;" value="<?php echo $this->antclass->back_value($this->antclass->add_nop_separator(@$nop->nop), 'txt_id_nop'); ?>" <?php if ($submitvalue == 'Edit') {
                                                                                                                                                                                                                                    echo 'disabled="disabled"';
                                                                                                                                                                                                                                } ?> class="tb" /> <b id="nop_error" style="background-color:#800;color:#fff;margin-left:20px;padding:0 10px;display:none"></b></td>
            </tr>
            <tr>
                <td> Letak Tanah dan atau Bangunan &raquo; </td>
                <td> <input type="text" name="txt_lokasi_nop" id="lokasi_id" style="width: 250px;" maxlength="100" value="<?php echo $this->antclass->back_value(@$nop->lokasi_op, 'txt_lokasi_nop'); ?>" class="tb" /> </td>
            </tr>
            <tr>
                <td> Kabupaten / Kota &raquo; </td>
                <td>
                    <select id="dati2_id" name="txt_kd_dati2_nop" class="tb" onchange="lookup_kecamatan($(this).val());">
                        <option></option>
                        <?php foreach ($dati2s as $dati2) : ?>
                            <option <?php if ($dati2->kd_dati2 == $kd_dati2) {
                                        echo 'selected="selected"';
                                    } ?> value="<?php echo $dati2->kd_dati2; ?>"><?php echo $dati2->kd_dati2 . ' - ' . $dati2->nama; ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td> Distrik &raquo; </td>
                <td>
                    <select id="kecamatan_id" name="txt_kd_kecamatan_nop" class="tb" <?php if ($submitvalue != 'Edit') { ?> onclick="lookup_kelurahan($(this).val());" <?php } ?> onchange="lookup_kelurahan($(this).val());">
                        <?php if ($kd_kecamatan == '') : ?>
                            <option></option>
                        <?php else : ?>
                            <?php foreach ($kecamatans as $kecamatan) : ?>
                                <option <?php if ($kecamatan->kd_kecamatan == $kd_kecamatan) {
                                            echo 'selected="selected"';
                                        } ?> value="<?php echo $kecamatan->kd_kecamatan; ?>"><?php echo $kecamatan->kd_kecamatan . ' - ' . $kecamatan->nama; ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td> Kelurahan &raquo; </td>
                <td>
                    <select id="kelurahan_id" name="txt_kd_kelurahan_nop" class="tb">
                        <?php if ($kd_kelurahan == '') : ?>
                            <option></option>
                        <?php else : ?>
                            <?php foreach ($kelurahans as $kelurahan) : ?>
                                <option <?php if ($kelurahan->kd_kelurahan == $kd_kelurahan) {
                                            echo 'selected="selected"';
                                        } ?> value="<?php echo $kelurahan->kd_kelurahan; ?>"><?php echo $kelurahan->kd_kelurahan . ' - ' . $kelurahan->nama; ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td> RT / RW &raquo; </td>
                <td> <input type="text" name="txt_rtrw_nop" id="rtrw_id" style="width: 100px;" maxlength="10" value="<?php echo $this->antclass->back_value(@$nop->rtrw_op, 'txt_rtrw_nop'); ?>" class="tb" /> </td>
            </tr>
        </table>
        <div class="listform" style="margin: 10px 0;">
            Perhitungan NJOP PBB &raquo;
            <table>
                <tr class="tblhead">
                    <td align="center" width="80"> Uraian </td>
                    <td align="center" width="180"> Luas <br />(Diisi luas tanah dan atau bangunan yang haknya diperoleh)</td>
                    <td align="center" width="180"> NJOP PBB/m2 <br />(Diisi berdasarkan SPPT PBB tahun terjadinya perolehan hak/tahun)</td>
                    <td align="center" width="150"> Luas x NJOP PBB/m2 </td>
                </tr>
                <tr align="center">
                    <td> Tanah (bumi) </td>
                    <td> <input autocomplete="off" onchange="count_calc($('#luas_tanah_id').val(), $('#njop_tanah_id').val(), '*', 'l_njop_tanah')" type="text" name="txt_luas_tanah_nop" id="luas_tanah_id" style="width: 120px; text-align: right;" maxlength="10" value="<?php echo $this->antclass->back_value(@$nop->luas_tanah_op, 'txt_luas_tanah_nop'); ?>" class="tb" /> m2 </td>
                    <td> Rp. <input autocomplete="off" onchange="count_calc($('#luas_tanah_id').val(), $('#njop_tanah_id').val(), '*', 'l_njop_tanah')" type="text" name="txt_njop_tanah_nop" id="njop_tanah_id" style="width: 120px; text-align: right;" maxlength="20" value="<?php echo $this->antclass->back_value(@$nop->njop_tanah_op, 'txt_njop_tanah_nop'); ?>" class="tb" /> * </td>
                    <td align="right">
                        Rp. <span onchange="count_njop_pbb($('#h_l_njop_tanah').val(), $('#h_l_njop_bangunan').val(), '+', 'njop_pbb_id')" id="l_njop_tanah">
                            <?php echo number_format(@$nop->luas_tanah_op * @$nop->njop_tanah_op, 0, ',', '.'); ?>
                        </span>
                        <input type="hidden" name="txt_h_njop_tanah_nop" id="h_l_njop_tanah" value="<?php echo @$nop->luas_tanah_op * @$nop->njop_tanah_op; ?>" />
                    </td>
                </tr>
                <tr align="center">
                    <td> Bangunan </td>
                    <td> <input autocomplete="off" onchange="count_calc($('#luas_bangunan_id').val(), $('#njop_bangunan_id').val(), '*', 'l_njop_bangunan')" type="text" name="txt_luas_bangunan_nop" id="luas_bangunan_id" style="width: 120px; text-align: right;" maxlength="10" value="<?php echo $this->antclass->back_value(@$nop->luas_bangunan_op, 'txt_luas_bangunan_nop'); ?>" class="tb" /> m2 </td>
                    <td> Rp. <input autocomplete="off" onchange="count_calc($('#luas_bangunan_id').val(), $('#njop_bangunan_id').val(), '*', 'l_njop_bangunan')" type="text" name="txt_njop_bangunan_nop" id="njop_bangunan_id" style="width: 120px; text-align: right;" maxlength="20" value="<?php echo $this->antclass->back_value(@$nop->njop_bangunan_op, 'txt_njop_bangunan_nop'); ?>" class="tb" /> * </td>
                    <td align="right">
                        Rp. <span onchange="count_njop_pbb($('#h_l_njop_bangunan').val(), $('#h_l_njop_tanah').val(), '+', 'njop_pbb_id')" id="l_njop_bangunan">
                            <?php echo number_format(@$nop->luas_bangunan_op * @$nop->njop_bangunan_op, 0, ',', '.'); ?>
                        </span>
                        <input type="hidden" name="txt_h_njop_bangunan_nop" id="h_l_njop_bangunan" value="<?php echo @$nop->luas_bangunan_op * @$nop->njop_bangunan_op; ?>" />
                    </td>
                </tr>
                <tr align="center">
                    <td colspan="3" align="right"></td>
                    <td align="right">
                        Rp. <span id="njop_pbb_lbl_id"><?php echo number_format(@$nop->njop_pbb_op, 0, ',', '.'); ?></span>
                        <input type="hidden" readonly="readonly" type="text" name="txt_njop_pbb_nop" id="njop_pbb_id" style="width: 120px; text-align: right;" maxlength="20" value="<?php echo $this->antclass->back_value(@$nop->njop_pbb_op, 'txt_njop_pbb_nop'); ?>" class="tb" />
                    </td>
                </tr>
            </table>
        </div>
        <table>
            <tr style="display: none;">
                <td width="315"> Harga Transaksi / Nilai Pasar &raquo; </td>
                <td> Rp. <input autocomplete="off" type="text" name="txt_nilai_nop" id="nilai_id" style="width: 100px;" maxlength="20" value="<?php echo $this->antclass->back_value(@$nop->nilai_op, 'txt_nilai_nop'); ?>" class="tb" /> * </td>
            </tr>
            <tr>
                <td> Nomor Sertipikat &raquo; </td>
                <td> <input autocomplete="off" type="text" name="txt_no_sertipikat_nop" id="no_sertipikat_id" style="width: 150px;" maxlength="20" value="<?php echo $this->antclass->back_value(@$nop->no_sertipikat_op, 'txt_no_sertipikat_nop'); ?>" class="tb" /> </td>
            </tr>
            <tr>
                <td></td>
                <td>

                    <?php if ($this->session->userdata('s_tipe_bphtb') == 'D') : ?><input type="submit" name="submit" value="<?php echo $submitvalue; ?>" class="bt" /><?php endif; ?>
                    <input type="hidden" name="h_rec_id" value="<?php echo $rec_id; ?>" />
                </td>
            </tr>
        </table>
    </form>
</div>