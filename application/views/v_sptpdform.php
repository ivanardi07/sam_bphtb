<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/template/css/bootstrap/datepicker.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/template/css/bootstrap/datepicker3.css">

<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="panel-title"><a href="<?php echo $c_loc; ?>">SSPD - BPHTB</a> : <?php echo $submitvalue; ?></h3>
                        </div>
                        <div class="col-md-6"></div>
                    </div>
                </div>

                <div class="panel-body">
                    <a class="btn btn-default" href="<?php echo base_url() . 'index.php/sptpd'; ?>"><i class="fa fa-mail-reply"></i> Kembali</a>
                    <!-- <a class="btn btn-info" href="javascript:void()'" onclick="$('.inputform').printElement({overrideElementCSS:['<?= base_url_css() ?>bphtb_stylo_print.css']});"><i class="fa fa-print"></i> Print</a> -->

                    <?php if (!empty($info)) {
                        echo $info;
                    } ?>
                    <span id="ppat_data_id"></span>
                    <span id="nik_data_id"></span>
                    <span id="nop_data_id"></span>
                    <div class="inputform">
                        <form enctype="multipart/form-data" name="frm_sptpd" method="post" action="" onsubmit="return check_add_sptpd();" id="frm_sptpd">
                            <div style="margin: 10px 0; border-bottom: 3px solid #CCC;"></div>
                            <table class="table table-hover">
                                <tr>
                                    <td width="200"> No. KTP </td>
                                    <td width="25">: </td>
                                    <td>
                                        <input class="form-control pull-left" type="text" name="txt_id_nik_sptpd" id="id_nik_id" onchange="lookup_nik($(this).val());" style="width: 220px;" maxlength="30" value="<?php echo $this->antclass->back_value(@$sptpd->nik, 'txt_id_nik_sptpd'); ?>" <?php if ($submitvalue == 'Edit') {
                                                                                                                                                                                                                                                                                                        echo 'disabled="disabled"';
                                                                                                                                                                                                                                                                                                    } ?> />
                                        <?php if ($submitvalue != 'Edit') { ?>
                                            <!-- <a style="float: left; margin-left: 10px;" id="btnNIKdetail" class="btn btn-default" style="cursor:pointer">Detailnya</a> -->
                                            <a style="float: left; margin-left: 10px;" onchange="lookup_nik($(this).val());" class="btn btn-default" style="cursor:pointer">Detailnya</a>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td> Nama Wajib Pajak </td>
                                    <td>: </td>
                                    <td>
                                        <input type="text" class="form-control" id="nama_nik_id_text" name="nama_nik_name" style="width: 220px;" value="<?php echo set_value('nama_nik_name') ?>">
                                        <span id="nama_nik_id"><?php echo @$nik->nama . ' ' . @$sptpd->wajibpajak; ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td> Alamat Wajib Pajak </td>
                                    <td>: </td>
                                    <td><input type="text" class="form-control" id="alamat_nik_id_text" name="alamat_nik_name" style="width: 220px;" value="<?php echo $this->session->userdata('s_alamat_nik'); ?>"><span id="alamat_nik_id"><?php echo @$nik->alamat; ?></span> </td>
                                </tr>


                                <tr>
                                    <td> Propinsi </td>
                                    <td>: </td>
                                    <td>
                                        <select id="propinsi_nik_id_text" name="propinsi_nik_name" class="form-control select2-c" onchange="lookup_kabupaten_text();" style="width: 220px;">
                                            <option value=""></option>
                                            <?php foreach ($propinsis as $propinsi) : ?>
                                                <option value="<?php echo $propinsi->kd_propinsi; ?>" <?php echo set_select('propinsi_nik_name', $propinsi->kd_propinsi) ?>><?php echo $propinsi->kd_propinsi . ' - ' . $propinsi->nama; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <span id="propinsi_nik_id"><?php echo @$nik->nm_propinsi; ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td> Kabupaten / Kota </td>
                                    <td>: </td>
                                    <td>
                                        <select id="kotakab_nik_id_text" name="kotakab_nik_name" class="form-control select2-c" onchange="lookup_kecamatan_text();" style="width: 220px;">
                                        </select>
                                        <span id="kotakab_nik_id"><?php echo @$nik->nm_dati2; ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td> Kecamatan </td>
                                    <td>:</td>
                                    <td>
                                        <select id="kecamatan_nik_id_text" name="kecamatan_nik_name" class="form-control select2-c" onchange="lookup_kelurahan_text();" style="width: 220px;">
                                        </select>
                                        <span id="kecamatan_nik_id"><?php echo @$nik->nm_kecamatan; ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td> Kelurahan / Desa </td>
                                    <td>:</td>
                                    <td>
                                        <select id="kelurahan_nik_id_text" name="kelurahan_nik_name" class="form-control select2-c" style="width: 220px;">
                                        </select>
                                        <span id="kelurahan_nik_id"><?php echo @$nik->nm_kelurahan; ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td> RT / RW </td>
                                    <td>: </td>
                                    <td> <input type="text" class="form-control" id="rtrw_nik_id_text" name="rtrw_nik_name" style="width: 220px;" value="<?php echo @$this->session->userdata('s_rtrw_nik'); ?>"><span id="rtrw_nik_id"><?php echo @$nik->rtrw; ?></span> </td>
                                </tr>
                                <tr>
                                    <td> Kode Pos </td>
                                    <td>: </td>
                                    <td> <input type="text" class="form-control" id="kodepos_nik_id_text" name="kodepos_nik_name" style="width: 220px;" value="<?php echo @$this->session->userdata('s_kodepos_nik'); ?>"><span id="kodepos_nik_id"><?php echo @$nik->kodepos; ?></span> </td>
                                </tr>
                                <input type="hidden" name="ident" id="ident">
                            </table>
                            <div style="margin: 10px 0; border-bottom: 3px solid #CCC;"></div>
                            <table class="table table-hover">
                                <tr>
                                    <td width="200"> Nomor Objek Pajak ( NOP ) PBB </td>
                                    <td width="25">: </td>
                                    <td>
                                        <input class="form-control pull-left" type="text" name="txt_id_nop_sptpd" onchange="lookup_nop($(this).val(), $('#id_nik_id').val());" id="nop_id" style="width: 220px;" value="<?php echo $this->config->item('conf_kd_propinsi') . '' . $this->config->item('conf_kd_kabupaten') . '.'; ?>" <?php if ($submitvalue == 'Edit') {
                                                                                                                                                                                                                                                                                                                                            echo 'disabled="disabled"';
                                                                                                                                                                                                                                                                                                                                        } ?> class="tb" />
                                        <?php if ($submitvalue != 'Edit') { ?><a style="float: left; margin-left: 10px;" class="btn btn-default" href="javascript:;" onclick="lookup_nop($(this).val(), $('#id_nik_id').val());" style="cursor:pointer">Detail</a> <b id="nop_error" style="background-color:#800;color:#fff;margin-left:20px;padding:0 10px;display:none"></b><?php } ?>
                                    </td>
                                </tr>
                                <!-- <tr>
                    <td> Letak Tanah dan ata u Bangunan </td>
                    <td>: </td>
                    <td> <span id="lokasi_nop_id"><?php echo @$nop->lokasi_op; ?></span> </td>
                </tr> -->
                                <tr>
                                    <td> Alamat Lengkap </td>
                                    <td>: </td>
                                    <td>
                                        <!-- <span id="alamat_nop_id"></span> -->
                                        <textarea style="resize: vertical; width: 400px;" rows="5" class="form-control" id="alamat_nop_id" name="alamat_nop_id"></textarea>
                                    </td>
                                </tr>
                                <!-- <tr>
                    <td> Kabupaten / Kota  </td>
                    <td>: </td>
                    <td> <span id="kotakab_nop_id"><?php echo @$nop->nm_dati2; ?></span> </td>
                </tr>
                <tr>
                    <td> Kecamatan  </td>
                    <td>: </td>
                    <td> <span id="kecamatan_nop_id"><?php echo @$nop->nm_kecamatan; ?></span> </td>
                </tr>
                <tr>
                    <td> Kelurahan  </td>
                    <td>: </td>
                    <td> <span id="kelurahan_nop_id"><?php echo @$nop->nm_kelurahan; ?></span> </td>
                </tr>
                <tr>
                    <td> RT / RW  </td>
                    <td>: </td>
                    <td> <span id="rtrw_nop_id"><?php echo @$nop->rtrw_op; ?></span> </td>
                </tr> -->
                            </table>
                            <div class="listform" style="margin: 10px 0;">
                                History Pembayaran :

                                <div id="list_history_pembayaran"></div>
                            </div>
                            <div id="belum_lunas"></div>
                            <div class="listform" style="margin: 10px 0;">
                                Perhitungan NJOP PBB :
                                <br />
                                <table class="table table-hover">
                                    <thead>
                                        <tr class="tblhead">
                                            <th class="text-center" width="80"> Uraian </th>
                                            <th class="text-center" width="180"> Luas <br />(Diisi luas tanah dan atau bangunan yang haknya diperoleh) m<sup>2</sup> </th>
                                            <th class="text-center" width="180"> NJOP PBB/m2 <br />(Diisi berdasarkan SPPT PBB tahun terjadinya perolehan hak/tahun)</th>
                                            <th class="text-center" width="150"> Luas x NJOP PBB/m2 </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr align="right">
                                            <td align="left"> Tanah ( Bumi ) </td>
                                            <td>
                                                <div class="npop_aphb">
                                                    <div class="row">
                                                        <div class="col-md-3"><input type="text" name="tanah_inp_aphb1" value="1" id="tanah_inp_aphb1" onkeyup="count_tanah_add_sptpd_2();" class="form-control input-aphb" onkeypress="return isNumberKey(event)">
                                                        </div>
                                                        <div class="col-md-1 input-aphb"> / </div>
                                                        <div class="col-md-3"><input type="text" name="tanah_inp_aphb2" value="1" id="tanah_inp_aphb2" onkeyup="count_tanah_add_sptpd_2();" class="form-control input-aphb" onkeypress="return isNumberKey(event)">
                                                        </div>
                                                        <div class="col-md-1 input-aphb"> x </div>
                                                        <div class="col-md-3"><span style="display:none" id="luas_tanah_nop_id"><?php echo number_format(@$nop->luas_tanah_op, 2, ',', ' '); ?></span>
                                                            <input class="form-control pull-right" onkeypress="return isNumberKey(event)" type="text" name="txt_luas_tanah_sptpd" id="luas_tanah_id" onkeyup="count_tanah_add_sptpd_2();" value="<?php echo @$nop->luas_tanah_op; ?>" class="tb" style="width: 55px;" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <input type="text" readonly="" name="tanah_inp_aphb3" id="tanah_inp_aphb3" class="form-control input-aphb pull-left" style="width: 55px;">
                                                <div class="col-md-1 input-aphb"> x </div>
                                                <span style="display:none" id="njop_tanah_nop_id"><?php echo number_format(@$nop->njop_tanah_op, 0, ',', '.'); ?></span>
                                                <input class="form-control pull-right" readonly style="width: 150px;" type="text" name="txt_njop_tanah_sptpd" id="njop_tanah_id" value="<?php echo @$nop->njop_tanah_op; ?>" onkeypress="return isNumberKey(event)" onkeyup="count_tanah_add_sptpd_2();" />
                                                <p class="pull_right">Rp.&nbsp;&nbsp;</p>
                                            </td>
                                            <td align="right">
                                                Rp. <span id="l_njop_tanah_nop_id"><?php $ltnt = @$nop->luas_tanah_op * @$nop->njop_tanah_op;
                                                                                    echo number_format(@$ltnt, 0, ',', '.'); ?></span>
                                                <input type="hidden" name="txt_njop_tanah_nop_h_sptpd" id="l_njop_tanah_nop_h_id" value="<?php echo @$nop->luas_tanah_op * @$nop->njop_tanah_op; ?>" />
                                            </td>
                                        </tr>
                                        <tr align="right">
                                            <td align="left"> Bangunan </td>
                                            <td>
                                                <div class="npop_aphb">
                                                    <div class="row">
                                                        <div class="col-md-3"><input type="text" name="bangunan_inp_aphb1" value="1" id="bangunan_inp_aphb1" onkeyup="count_bangunan_add_sptpd_2();" class="form-control input-aphb" onkeypress="return isNumberKey(event)">
                                                        </div>
                                                        <div class="col-md-1 input-aphb"> / </div>
                                                        <div class="col-md-3"><input type="text" name="bangunan_inp_aphb2" value="1" id="bangunan_inp_aphb2" onkeyup="count_bangunan_add_sptpd_2();" class="form-control input-aphb" onkeypress="return isNumberKey(event)">
                                                        </div>
                                                        <div class="col-md-1 input-aphb"> x </div>
                                                        <div class="col-md-3"><span style="display:none" id="luas_bangunan_nop_id"><?php echo @$nop->luas_bangunan_op; ?></span>
                                                            <input class="form-control pull-right" onkeypress="return isNumberKey(event)" style="width: 55px;" type="text" name="txt_luas_bangunan_sptpd" id="luas_bangunan_id" onkeypress="return isNumberKey(event)" onkeyup="count_bangunan_add_sptpd_2();" value="<?php echo @$nop->luas_bangunan_op; ?>" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <input type="text" readonly="" name="bangunan_inp_aphb3" id="bangunan_inp_aphb3" class="form-control input-aphb pull-left" style="width: 55px;">
                                                <div class="col-md-1 input-aphb"> x </div>
                                                <span style="display:none" id="njop_bangunan_nop_id"><?php echo number_format(@$nop->njop_bangunan_op, 0, ',', '.'); ?></span>
                                                <input class="form-control pull-right" style="width: 150px;" type="text" name="txt_njop_bangunan_sptpd" id="njop_bangunan_id" value="<?php echo @$nop->njop_bangunan_op; ?>" class="tb" onkeyup="count_bangunan_add_sptpd_2();" />
                                                <p class="pull_right">Rp.&nbsp;&nbsp;</p>
                                            </td>
                                            <td align="right">
                                                Rp. <span id="l_njop_bangunan_nop_id"><?php $lbnb = @$nop->luas_bangunan_op * @$nop->njop_bangunan_op;
                                                                                        echo number_format(@$lbnb, 0, ',', '.'); ?></span>
                                                <input type="hidden" name="txt_njop_bangunan_nop_h_sptpd" id="l_njop_bangunan_nop_h_id" value="<?php echo @$nop->luas_bangunan_op * @$nop->njop_bangunan_op; ?>" />
                                            </td>
                                        </tr>
                                        <tr align="right">
                                            <td align="left"> Tanah Bersama </td>
                                            <td>
                                                <div class="npop_aphb">
                                                    <div class="row">
                                                        <div class="col-md-3"><input type="text" name="tanah_b_inp_aphb1" value="1" id="tanah_b_inp_aphb1" onkeyup="count_tanah_b_add_sptpd_2();" class="form-control input-aphb" onkeypress="return isNumberKey(event)">
                                                        </div>
                                                        <div class="col-md-1 input-aphb"> / </div>
                                                        <div class="col-md-3"><input type="text" name="tanah_b_inp_aphb2" value="1" id="tanah_b_inp_aphb2" onkeyup="count_tanah_b_add_sptpd_2();" class="form-control input-aphb" onkeypress="return isNumberKey(event)">
                                                        </div>
                                                        <div class="col-md-1 input-aphb"> x </div>
                                                        <div class="col-md-3"><span style="display:none;" id="luas_tanah_b_nop_id"><?php echo @$nop->luas_tanah_b_op; ?></span>
                                                            <input class="form-control pull-right" onkeypress="return isNumberKey(event)" style="width: 55px;" type="text" name="txt_luas_tanah_b_sptpd" id="luas_tanah_b_id" onkeypress="return isNumberKey(event)" onkeyup="count_tanah_b_add_sptpd_2();" value="<?php echo @$nop->luas_tanah_b_op; ?>" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <input type="text" readonly="" name="tanah_b_inp_aphb3" id="tanah_b_inp_aphb3" class="form-control input-aphb pull-left" style="width: 55px;">
                                                <div class="col-md-1 input-aphb"> x </div>
                                                <span style="display:none;" id="njop_tanah_b_nop_id"><?php echo number_format(@$nop->njop_tanah_b_op, 0, ',', '.'); ?></span>
                                                <input class="form-control pull-right" style="width: 150px;" type="text" name="txt_njop_tanah_b_sptpd" id="njop_tanah_b_id" value="<?php echo @$nop->njop_tanah_b_op; ?>" class="tb" onkeyup="count_tanah_b_add_sptpd_2();" />
                                                <p class="pull_right">Rp.&nbsp;&nbsp;</p>
                                            </td>
                                            <td align="right">
                                                Rp. <span id="l_njop_tanah_b_nop_id"><?php $lbnb = @$nop->luas_tanah_b_op * @$nop->njop_tanah_b_op;
                                                                                        echo number_format(@$lbnb, 0, ',', '.'); ?></span>
                                                <input type="hidden" name="txt_njop_tanah_b_nop_h_sptpd" id="l_njop_tanah_b_nop_h_id" value="<?php echo @$nop->luas_tanah_b_op * @$nop->njop_tanah_b_op; ?>" />
                                            </td>
                                        </tr>
                                        <tr align="right">
                                            <td align="left"> Bangunan Bersama </td>
                                            <td>
                                                <div class="npop_aphb">
                                                    <div class="row">
                                                        <div class="col-md-3"><input type="text" name="bangunan_b_inp_aphb1" value="1" id="bangunan_b_inp_aphb1" onkeyup="count_bangunan_b_add_sptpd_2();" class="form-control input-aphb" onkeypress="return isNumberKey(event)">
                                                        </div>
                                                        <div class="col-md-1 input-aphb"> / </div>
                                                        <div class="col-md-3"><input type="text" name="bangunan_b_inp_aphb2" value="1" id="bangunan_b_inp_aphb2" onkeyup="count_bangunan_b_add_sptpd_2();" class="form-control input-aphb" onkeypress="return isNumberKey(event)">
                                                        </div>
                                                        <div class="col-md-1 input-aphb"> x </div>
                                                        <div class="col-md-3"><span style="display:none;" id="luas_bangunan_b_nop_id"><?php echo @$nop->luas_bangunan_b_op; ?></span>
                                                            <input class="form-control pull-right" onkeypress="return isNumberKey(event)" style="width: 55px;" type="text" name="txt_luas_bangunan_b_sptpd" id="luas_bangunan_b_id" onkeypress="return isNumberKey(event)" onkeyup="count_bangunan_b_add_sptpd_2();" value="<?php echo @$nop->luas_bangunan_b_op; ?>" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <input type="text" readonly="" name="bangunan_b_inp_aphb3" id="bangunan_b_inp_aphb3" class="form-control input-aphb pull-left" style="width: 55px;">
                                                <div class="col-md-1 input-aphb"> x </div>
                                                <span style="display:none;" id="njop_bangunan_b_nop_id"><?php echo number_format(@$nop->njop_bangunan_b_op, 0, ',', '.'); ?></span>
                                                <input class="form-control pull-right" style="width: 150px;" type="text" name="txt_njop_bangunan_b_sptpd" id="njop_bangunan_b_id" value="<?php echo @$nop->njop_bangunan_b_op; ?>" class="tb" onkeyup="count_bangunan_b_add_sptpd_2();" />
                                                <p class="pull_right">Rp.&nbsp;&nbsp;</p>
                                            </td>
                                            <td align="right">
                                                Rp. <span id="l_njop_bangunan_b_nop_id"><?php $lbnb = @$nop->luas_bangunan_b_op * @$nop->njop_bangunan_b_op;
                                                                                        echo number_format(@$lbnb, 0, ',', '.'); ?></span>
                                                <input type="hidden" name="txt_njop_bangunan_b_nop_h_sptpd" id="l_njop_bangunan_b_nop_h_id" value="<?php echo @$nop->luas_bangunan_b_op * @$nop->njop_bangunan_b_op; ?>" />
                                            </td>
                                        </tr>
                                        <tr align="center">
                                            <td colspan="3"></td>
                                            <td align="right">
                                                Rp. <span id="njop_pbb_nop_id"><?php echo number_format(@$nop->njop_pbb_op, 0, ',', '.'); ?></span>
                                                <input type="hidden" name="txt_njop_pbb_h_sptpd" id="njop_pbb_nop_h_id" value="<?php echo @$nop->njop_pbb_op; ?>" />
                                            </td>
                                        </tr>
                                        <!--                     <tr>
                        <td colspan = '4'>
                            <div class="listform" style="margin: 10px 0;">
                                <thead>
                                    <tr>
                                        <th colspan = "4"><center>REFERENSI HARGA PASAR :<center></th>
                                    </tr>
                                </thead>
                                <table class="table table-hover">
                                    <tbody>
                                        <tr>
                                            <td align="left">Tanah (4 x NJOP Tanah)</td>
                                            <td>:</td>
                                            <td align="left" ><b><span id = "referensi_tanah">Rp. 0</span></b></td>
                                            <td width = "500px;"></td>
                                            <input type = "hidden" id = "ref_tanah" name = "ref_tanah">
                                        </tr>
                                        <tr>
                                            <td align="left">Bangunan (4 x NJOP Bangunan)</td>
                                            <td>:</td>
                                            <td align="left" ><b><span id = "referensi_bangunan">Rp. 0</span></b></td>
                                            <td width = "500px;"></td>
                                            <input type = "hidden" id = "ref_bangunan" name = "ref_bangunan">
                                        </tr>
                                        <tr>
                                            <td align="left">Total</td>
                                            <td>:</td>
                                            <td align="left" ><b><span id = "total_referensi">Rp. 0</span></b></td>
                                            <td width = "500px;"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr> -->
                                    </tbody>
                                </table>
                            </div>
                            <table class="table table-hover">
                                <tr>
                                    <td> Jenis Perolehan Hak atas Tanah dan atau Bangunan </td>
                                    <td>: </td>
                                    <td colspan="2">
                                        <div class="pull-left">
                                            <select id="jns_perolehan_op_id" name="txt_jns_perolehan_sptpd" class="tb select2" onchange="jenisAction ($(this).val());">
                                                <option value=""></option>
                                                <?php foreach ($jenis_perolehan as $jns_perolehan) : ?>
                                                    <option class="form-control" <?php if ($jns_perolehan->kd_perolehan == @$sptpd->jenis_perolehan) {
                                                                                        echo 'selected="selected"';
                                                                                    } ?> value="<?php echo $jns_perolehan->kd_perolehan; ?>"><?php echo $jns_perolehan->kd_perolehan . ' - ' . $jns_perolehan->nama; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <p>&nbsp;&nbsp;*</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="315"> Harga Transaksi / Nilai Pasar </td>
                                    <td width="25">: </td>
                                    <td>
                                        <p class="pull-left">Rp.&nbsp;&nbsp;</p> <input class="form-control pull-left" type="text" name="txt_nilai_pasar_sptpd" id="nilai_pasar_id" style="width: 150px; text-align: right;" maxlength="50" onkeyup="harga_transaksi_change();" value="<?php echo $this->antclass->back_value(@$sptpd->nilai_pasar, 'txt_nilai_pasar_sptpd'); ?>" class="tb" />
                                        <p class="pull-left">&nbsp;&nbsp;*</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td> Nomor Sertipikat </td>
                                    <td>: </td>
                                    <td> <input type="text" style="width: 300px;" name="txt_no_sertifikat_op" class="form-control pull-left">
                                        <p class="pull-left">&nbsp;&nbsp;*</p>
                                    </td>
                                </tr>
                            </table>
                            <div class="listform" style="margin: 10px 0;">
                                <table class="table table-hover">
                                    <thead>
                                        <tr class="tblhead">
                                            <th colspan="2" class="text-center"> PENGHITUNGAN BPHTBP (Hanya diisi berdasarkan penghitungan Wajib)</th>
                                            <th colspan="2" class="text-center"> Dalam Rupiah </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td id="lbl_npop"> Nilai Perolehan Objek Pajak (NPOP) </td>
                                            <td style="width:350px;">
                                            </td>
                                            <td align="right">
                                                <p class="pull-right">&nbsp;&nbsp;*</p><input class="form-control pull-right" type="text" name="txt_npop_sptpd" id="npop_id" style="width: 150px; text-align: right;" value="<?php echo $this->antclass->back_value(@$sptpd->npop, 'txt_npop_sptpd'); ?>" class="tb" readonly />
                                                <p class="pull-right">Rp.&nbsp;&nbsp;</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"> Nilai Perolehan Objek Pajak Tidak Kena Pajak (NPOPTKP) </td>
                                            <td align="right" colspan="2">
                                                <?php if ($cek_transaksi_prev) : ?>
                                                    <input class="form-control pull-right" type="text" name="txt_npoptkp_sptpd" id="npoptkp_id" style="width: 150px; text-align:right;" value="<?php echo number_format($this->config->item('conf_npoptkp_60'), 0, ',', '.') ?>" onkeyup="count_npoptkp($(this).val());">
                                                    <p class="pull-right">Rp.&nbsp;&nbsp;</p>
                                                    <!--                             Rp. <span id="npoptkp_lbl_id"><?php echo number_format($this->config->item('conf_npoptkp_60'), 0, ',', '.'); ?></span>
                            <input type="hidden" name="txt_npoptkp_sptpd" id="npoptkp_id" value="<?php echo $this->config->item('conf_npoptkp_60'); ?>" /> -->
                                                <?php else : ?>
                                                    <input class="form-control pull-right" type="text" name="txt_npoptkp_sptpd" id="npoptkp_id" style="width: 150px; text-align:right;" value="0" onkeyup="count_npoptkp($(this).val());" readonly>
                                                    <p class="pull-right">Rp.&nbsp;&nbsp;</p>
                                                    <!--                             Rp. <span id="npoptkp_lbl_id">0</span>
                            <input type="hidden" name="txt_npoptkp_sptpd" id="npoptkp_id" value="0" /> -->
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 360px;"> Nilai Perolehan Objek Pajak Kena Pajak (NPOPKP) </td>
                                            <td style="width: 100px; font-size: 10px;"> NPOP - NPOPTKP </td>
                                            <td align="right" colspan="2">
                                                Rp. <span id="npopkp_id">
                                                    <?php
                                                    $npopkp = @$sptpd->npop - @$sptpd->npoptkp;
                                                    if ($npopkp <= 0) {
                                                        $npopkp = 0;
                                                    }
                                                    echo number_format(@$npopkp, 0, ',', '.');
                                                    ?>
                                                </span> *

                                                <input type="hidden" name="txt_npopkp_sptpd" id="txt_npopkp_sptpd" value="0" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td> Bea Perolehan Hak Atas Tanah dan Bangunan Yang Terutang </td>
                                            <td style="font-size: 10px;"> 5% x NPOPKP </td>
                                            <td align="right" colspan="2">
                                                Rp. <span id="bea_perolehan_id">
                                                    <?php
                                                    $npopkp5 = 0.05 * @$npopkp;
                                                    echo number_format(@$npopkp5, 0, ',', '.');
                                                    ?>
                                                </span> *
                                                <input type="hidden" name="txt_bea_perolehan_sptpd" id="bea_perolehan_h_id" value="<?php echo @$npopkp5; ?>" />
                                            </td>
                                        </tr>
                                        <tr style="display:none">
                                            <td> Pengenaan 50% karena waris / Hibah wasiat / pemberian hak pengelolaan *) </td>
                                            <td style="font-size: 10px;"> 50% x dari Bea Perolehan </td>
                                            <td align="right" colspan="2">
                                                Rp. <span id="pengenaan50_id">
                                                    <?php $pengenaan50 = 0.5 * @$npopkp5;
                                                    if ($pengenaan50 <= 0) {
                                                        $pengenaan50 = 0;
                                                    }
                                                    echo number_format(@$pengenaan50, 0, ',', '.'); ?>
                                                </span> *
                                                <input type="hidden" name="txt_pengenaan50_sptpd" id="pengenaan50_h_id" value="<?php echo @$npopkp5; ?>" />
                                            </td>
                                        </tr>
                                        <tr style="display: none">
                                            <td colspan="2"> Bea Perolehan Hak atas Tanah dan Bangunan yang dibayar </td>
                                            <td align="right" colspan="2">
                                                Rp. <span id="bea_bayar_id">
                                                    <?php $bea_bayar = 0;
                                                    if ($pengenaan50 <= 0) {
                                                        $bea_bayar = $npopkp5;
                                                    } else {
                                                        $bea_bayar = $pengenaan50;
                                                    }
                                                    echo number_format(@$bea_bayar, 0, ',', '.'); ?>
                                                </span> *
                                                <input type="hidden" name="txt_bea_bayar_sptpd" id="bea_bayar_h_id" value="<?php echo @$bea_bayar; ?>" />
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div style="margin: 10px 0; border-bottom: 3px solid #CCC;"></div>

                            <div style="margin: 10px 0;">
                                Jumlah Setoran Berdasarkan :
                                <table class="table table-hover">
                                    <tr>
                                        <td style="width: 270px;">
                                            <label for="pwp_id"><input type="radio" name="txt_dasar_jml_setoran_sptpd" id="pwp_id" value="PWP" <?php if (@$sptpd->jns_setoran == 'PWP') {
                                                                                                                                                    echo 'checked="checked"';
                                                                                                                                                } ?> checked="checked" /> Penghitungan Wajib Pajak</label>
                                        </td>
                                        <td> </td>
                                    </tr>
                                    <tr>
                                        <td><label for="stb_id">
                                                <input type="radio" name="txt_dasar_jml_setoran_sptpd" id="stb_id" value="STB" <?php if (@$sptpd->jns_setoran == 'STB') {
                                                                                                                                    echo 'checked="checked"';
                                                                                                                                } ?> /> STPD
                                            </label>
                                        </td>
                                        <td style="">
                                            <p class="pull-left">Nomor :&nbsp;&nbsp;</p> <input class="form-control pull-left" type="text" name="txt_nomor_stb_sptpd" style="width: 220px;" value="<?php if (@$nomor_skb or $submitvalue == 'Edit') {
                                                                                                                                                                                                        echo @$nomor_skb;
                                                                                                                                                                                                    } else { /*echo $this->antclass->generate_token();*/
                                                                                                                                                                                                    } ?>" class="tb" /> &nbsp;&nbsp;&nbsp;
                                            <p class="pull-left">&nbsp;&nbsp;Tanggal :&nbsp;&nbsp;</p><input class="form-control pull-left" id="datepicker" type="text" name="txt_tanggal_stb_sptpd" style="width: 150px;" value="<?php if (@$tanggal_skb or $submitvalue == 'Edit') {
                                                                                                                                                                                                                                        echo @$tanggal_skb;
                                                                                                                                                                                                                                    } else {
                                                                                                                                                                                                                                        echo date('Y-m-d');
                                                                                                                                                                                                                                    }; ?>" class="tb" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label for="skbkb_id">
                                                <input type="radio" name="txt_dasar_jml_setoran_sptpd" id="skbkb_id" value="SKBKB" <?php if (@$sptpd->jns_setoran == 'SKBKB') {
                                                                                                                                        echo 'checked="checked"';
                                                                                                                                    } ?> /> SKPDKB
                                            </label>
                                        </td>
                                        <td style="">
                                            <p class="pull-left">Nomor :&nbsp;&nbsp;</p> <input class="form-control pull-left" type="text" name="txt_nomor_skbkb_sptpd" style="width: 220px;" value="<?php if (@$nomor_skb or $submitvalue == 'Edit') {
                                                                                                                                                                                                            echo @$nomor_skbkb;
                                                                                                                                                                                                        } else { /*echo $this->antclass->generate_token();*/
                                                                                                                                                                                                        } ?>" class="tb" /> &nbsp;&nbsp;&nbsp;
                                            <p class="pull-left">&nbsp;&nbsp;Tanggal :&nbsp;&nbsp;</p> <input class="form-control pull-left" id="datepicker2" type="text" name="txt_tanggal_skbkb_sptpd" style="width: 150px;" value="<?php if (@$tanggal_skbkb or $submitvalue == 'Edit') {
                                                                                                                                                                                                                                            echo @$tanggal_skbkb;
                                                                                                                                                                                                                                        } else {
                                                                                                                                                                                                                                            echo date('Y-m-d');
                                                                                                                                                                                                                                        } ?>" class="tb" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label for="skbkbt_id">
                                                <input type="radio" name="txt_dasar_jml_setoran_sptpd" id="skbkbt_id" value="SKBKBT" <?php if (@$sptpd->jns_setoran == 'SKBKBT') {
                                                                                                                                            echo 'checked="checked"';
                                                                                                                                        } ?> /> SKPDKBT
                                            </label>
                                        </td>
                                        <td style="">
                                            <p class="pull-left">Nomor :&nbsp;&nbsp;</p> <input class="form-control pull-left" type="text" name="txt_nomor_skbkbt_sptpd" style="width: 220px;" value="<?php if (@$nomor_skb or $submitvalue == 'Edit') {
                                                                                                                                                                                                            echo @$nomor_skbkbt;
                                                                                                                                                                                                        } else { /*echo $this->antclass->generate_token();*/
                                                                                                                                                                                                        } ?>" class="tb" /> &nbsp;&nbsp;&nbsp;
                                            <p class="pull-left">&nbsp;&nbsp;Tanggal :&nbsp;&nbsp;</p> <input class="form-control pull-left" id="datepicker3" type="text" name="txt_tanggal_skbkbt_sptpd" style="width: 150px;" value="<?php if (@$tanggal_skbkbt or $submitvalue == 'Edit') {
                                                                                                                                                                                                                                            echo @$tanggal_skbkbt;
                                                                                                                                                                                                                                        } else {
                                                                                                                                                                                                                                            echo date('Y-m-d');
                                                                                                                                                                                                                                        } ?>" class="tb" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label for="pds_id">
                                                <input type="radio" name="txt_dasar_jml_setoran_sptpd" id="pds_id" value="PDS" <?php if (@$sptpd->jns_setoran == 'PDS') {
                                                                                                                                    echo 'checked="checked"';
                                                                                                                                } ?> /> Pengurangan dihitung sendiri karena
                                        </td>
                                        <td> <input class="form-control" type="text" name="txt_hitung_sendiri_sptpd" id="hitung_sendiri_id" class="tb" style="width: 50px;" maxlength="2" value="<?php echo $this->antclass->back_value(@$sptpd->jns_setoran_hitung_sendiri, 'txt_hitung_sendiri_sptpd'); ?>" /> </td>
                                    </tr>
                                    <tr>
                                        <td><label for="pcustom_id">Keterangan Setoran</td>
                                        <td>
                                            <textarea class="form-control" name="txt_custom_setoran_sptpd" id="hitung_sendiri_id" class="tb" style="width: 400px; height: 50px;"><?php echo $this->antclass->back_value(@$sptpd->jns_setoran_custom, 'txt_custom_setoran_sptpd'); ?></textarea>
                                            <br /><i>(Isi jika diperlukan)</i>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div style="margin: 10px 0;">
                                <p class="pull-left">Jumlah Yang Disetor ( dengan angka ) :&nbsp;&nbsp;</p>
                                <p class="pull-left">Rp.&nbsp;&nbsp;</p>
                                <input class="form-control pull-left" type="text" name="txt_jml_setor_sptpd_text" id="txt_jml_setor_id" class="tb" style="width: 150px;text-align:right" maxlength="100" value="<?php echo $this->antclass->back_value(@$sptpd->jumlah_setor, 'txt_jml_setor_sptpd'); ?>" align="right" <?php if ($submitvalue == 'Edit') {
                                                                                                                                                                                                                                                                                                                            echo 'disabled="disabled"';
                                                                                                                                                                                                                                                                                                                        } ?> readonly />
                                <input class="form-control pull-left" type="hidden" name="txt_jml_setor_sptpd" id="jml_setor_id" class="tb" style="width: 150px;text-align:right" maxlength="100" value="<?php echo $this->antclass->back_value(@$sptpd->jumlah_setor, 'txt_jml_setor_sptpd'); ?>" align="right" <?php if ($submitvalue == 'Edit') {
                                                                                                                                                                                                                                                                                                                        echo 'disabled="disabled"';
                                                                                                                                                                                                                                                                                                                    } ?> readonly />
                                <div class="clearfix"></div>
                                <div id="div_terbilang" style="margin: 5px 0;">Dengan Huruf : <b id="terbilang"><?php echo @$terbilang_jml_setor; ?></b></div>
                                <script>
                                    $('#jml_setor_id').keyup(function() {
                                        var val = $('#jml_setor_id').val();
                                        var huruf = $('#terbilang');

                                        $.ajax({
                                            url: '<?php echo base_url() ?>index.php/sptpd/terbilang_val',
                                            data: {
                                                enValue: val,
                                                ajax: 1
                                            },
                                            type: 'POST',
                                            dataType: 'json',
                                            success: function(data) {
                                                huruf.text('');
                                                if (data['result'].length > 0) {
                                                    $('#terbilang').append(data['result'] + ' Rupiah');
                                                } else {
                                                    huruf.text('');
                                                }
                                            }
                                        });

                                    });
                                </script>
                            </div>
                            <div style="margin: 10px 0;">Untuk Disetorkan ke Rekening <?php echo @$rekening->nama; ?> : <?php echo @$rekening->nomor; ?></div>
                            <div style="margin: 10px 0;"><b>Upload Gambar Objek Pajak</b> : <input class="btn btn-primary lam" type="file" name="txt_picture_sptpd" /></div>
                            <?php if ($submitvalue == 'Edit' or $submitvalue == 'View') : ?>
                                <div style="margin: 10px 0;"><b>Gambar Objek Pajak</b> : <?php if (!empty($sptpd->gambar_op)) { ?><div class="gambar_op"><img src="<?php echo base_url_img() . 'op/' . $sptpd->gambar_op; ?>" /></div><?php } else {
                                                                                                                                                                                                                                        echo '-';
                                                                                                                                                                                                                                    } ?></div>
                            <?php endif; ?>


                            <div class="listform" style="margin: 10px 0;">
                                <table class="table table-hover">
                                    <?php if ($submitvalue != 'Edit') : ?>
                                        <tr hidden>
                                            <td width="150"> Prefix Nomor Dokumen</td>
                                            <td width="10"> : </td>
                                            <td>
                                                <select class="form-control select2" style="width: 100px" id="id_prefix_sptpd" name="txt_prefix_sptpd">
                                                    <?php foreach ($prefix as $prex) : ?>
                                                        <option value="<?php echo $prex->nama; ?>"><?php echo $prex->nama; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                    <?php if ($submitvalue == 'Edit') : ?>
                                        <tr>
                                            <td width="100"> Kode Validasi</td>
                                            <td width="10"> : </td>
                                            <td> <?php echo @$sptpd->kode_validasi; ?> </td>
                                        </tr>
                                    <?php endif; ?>
                                    <tr style="display: none;">
                                        <td width="100"> NOP PBB Baru </td>
                                        <td width="10"> : </td>
                                        <td>
                                            <input class="form-control" style="display: none;" type="text" id="txt_nop_pbb_baru_sptpd" name="txt_nop_pbb_baru_sptpd" value="<?php echo $this->antclass->back_value(@$sptpd->nop_pbb_baru, 'txt_nop_pbb_baru_sptpd'); ?>" class="tb" style="width:150px" /> <b id="nop_baru_error" style="background-color:#800;color:#fff;margin-left:20px;padding:0 10px;display:none" />
                                            </b>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div style="margin: 10px 0; border-bottom: 3px solid #CCC;"></div>

                            <center style="margin:40px 0px;">
                                <h3>Lampiran - Lampiran</h3>
                            </center>
                            <div style="margin: 10px 0;">
                                <table class="table">
                                    <tbody>
                                        <tr height="24" valign="top" style="display:none">
                                            <td> <label><input type="checkbox" value="1" id="" name="lampiran_sspd_1"> SSPD </label> </td>
                                            <td style="">
                                                <input type="file" name="txt_picture_lampiran_sspd_1_file" />
                                            </td>
                                        </tr>
                                        <tr height="24" valign="top">
                                            <td> <label><input type="checkbox" value="1" id="" name="lampiran_sspd_2" <?php echo $this->antclass->back_valuex(@$penelitian->lampiran_sspd_2, 'lampiran_sspd_2') == '1' ? 'checked' : ''; ?>> Scan SPPT dan STTS/Struk ATM bukti pembayaran PBB/Bukti Pembayaran PBB </label> </td>
                                            <td style="">
                                                <input type="file" name="txt_picture_lampiran_sspd_2_file" class="lam" />

                                            </td>
                                        </tr height="24">
                                        <tr height="24" valign="top">
                                            <td> <label><input type="checkbox" value="1" id="" name="lampiran_fotocopi_identitas" <?php echo $this->antclass->back_valuex(@$penelitian->lampiran_fotocopi_identitas, 'lampiran_fotocopi_identitas') == '1' ? 'checked' : ''; ?>> Scan Identitas Wajib Pajak </label> </td>
                                            <td style="">
                                                <input type="file" name="txt_picture_lampiran_fotocopi_identitas_file" class="lam" />
                                            </td>
                                        </tr>
                                        <tr height="24">
                                            <td> <label><input type="checkbox" value="1" id="" name="lampiran_surat_kuasa_wp" <?php echo $this->antclass->back_valuex(@$penelitian->lampiran_surat_kuasa_wp, 'lampiran_surat_kuasa_wp') == '1' ? 'checked' : ''; ?>> Surat Kuasa Dari Wajib Pajak </label> </td>
                                            <td style="">

                                            </td>
                                        </tr>
                                        <tr height="24">
                                            <td colspan=2 style="padding-left:20px"><strong>Nama Kuasa Wp</strong>
                                                <div style="width:250px;"><input type="text" class="form-control" id="nop_id" name="lampiran_nama_kuasa_wp" autocomplete="off" value="<?php echo $this->antclass->back_valuex(@$penelitian->lampiran_nama_kuasa_wp, 'lampiran_nama_kuasa_wp'); ?>"></div> <strong>Alamat Kuasa Wp</strong>
                                                <div style="width:250px;"><input type="text" class="form-control" id="nop_id" name="lampiran_alamat_kuasa_wp" value="<?php echo $this->antclass->back_valuex(@$penelitian->lampiran_alamat_kuasa_wp, 'lampiran_alamat_kuasa_wp'); ?>" autocomplete="off"></div>
                                            </td>
                                        </tr>
                                        <tr height="24">
                                            <td> <label><input type="checkbox" value="1" id="" name="lampiran_fotocopy_identitas_kwp" <?php echo $this->antclass->back_valuex(@$penelitian->lampiran_fotocopy_identitas_kwp, 'lampiran_fotocopy_identitas_kwp') == '1' ? 'checked' : ''; ?>> Scan Identitas Kuasa Wajib Pajak </label> </td>
                                            <td style="">
                                                <input type="file" name="txt_picture_lampiran_fotocopy_identitas_kwp_file" class="lam" />

                                            </td>
                                        </tr>
                                        <tr height="24">
                                            <td> <label><input type="checkbox" value="1" id="" name="lampiran_fotocopy_kartu_npwp" <?php echo $this->antclass->back_valuex(@$penelitian->lampiran_fotocopy_kartu_npwp, 'lampiran_fotocopy_kartu_npwp') == '1' ? 'checked' : ''; ?>> Scan kartu NPWP</label> </td>
                                            <td style="">
                                                <input type="file" name="txt_picture_lampiran_fotocopy_kartu_npwp_file" class="lam" />

                                            </td>
                                        </tr>
                                        <tr height="24">
                                            <td> <label><input type="checkbox" value="1" id="" name="lampiran_fotocopy_akta_jb" <?php echo $this->antclass->back_valuex(@$penelitian->lampiran_fotocopy_akta_jb, 'lampiran_fotocopy_akta_jb') == '1' ? 'checked' : ''; ?>> Scan Akta Jual Beli / Hibah / Surat Keterangan Waris / Hibah Wasiat</label> </td>
                                            <td style="">
                                                <input type="file" name="txt_picture_lampiran_fotocopy_akta_jb_file" class="lam" />

                                            </td>
                                        </tr>
                                        <tr height="24">
                                            <td> <label><input type="checkbox" value="1" id="" name="lampiran_sertifikat_kepemilikan_tanah" <?php echo $this->antclass->back_valuex(@$penelitian->lampiran_sertifikat_kepemilikan_tanah, 'lampiran_sertifikat_kepemilikan_tanah') == '1' ? 'checked' : ''; ?>> Scan Sertifikat / Keterangan Kepemilikan Tanah</label> </td>
                                            <td style="">
                                                <input type="file" name="txt_picture_lampiran_sertifikat_kepemilikan_tanah_file" class="lam">

                                            </td>
                                        </tr>
                                        <tr height="24">
                                            <td> <label><input type="checkbox" value="1" id="" name="lampiran_fotocopy_keterangan_waris" <?php echo $this->antclass->back_valuex(@$penelitian->lampiran_fotocopy_keterangan_waris, 'lampiran_fotocopy_keterangan_waris') == '1' ? 'checked' : ''; ?>> Scan Keterangan Waris</label> </td>
                                            <td style="">
                                                <input type="file" name="txt_picture_lampiran_fotocopy_keterangan_waris_file" class="lam" />

                                            </td>
                                        </tr>
                                        <tr height="24">
                                            <td> <label><input type="checkbox" value="1" id="" name="lampiran_fotocopy_surat_pernyataan" <?php echo $this->antclass->back_valuex(@$penelitian->lampiran_fotocopy_surat_pernyataan, 'lampiran_fotocopy_surat_pernyataan') == '1' ? 'checked' : ''; ?>> Scan Surat Pernyataan</label> </td>
                                            <td style="">
                                                <input type="file" name="txt_picture_lampiran_fotocopy_surat_pernyataan" class="lam" />

                                            </td>
                                        </tr>
                                        <tr height="24">
                                            <td> <label><input type="checkbox" value="1" id="" name="lampiran_spoplspop" <?php echo $this->antclass->back_valuex(@$penelitian->lampiran_spoplspop, 'lampiran_spoplspop') == '1' ? 'checked' : ''; ?>> Scan Formulir SPOP/LSPOP</label> </td>
                                            <td style="">
                                                <input type="file" name="txt_picture_lampiran_spoplspop" class="lam" />

                                            </td>
                                        </tr>
                                        <tr height="24">
                                            <td> <label><input type="checkbox" value="1" id="" name="lampiran_identitas_lainya" <?php echo $this->antclass->back_valuex(@$penelitian->lampiran_identitas_lainya, 'lampiran_identitas_lainya') == '1' ? 'checked' : ''; ?>> Identitas lainya</label> </td>
                                            <td style="">
                                                <input type="file" name="txt_picture_lampiran_identitas_lainya_file" class="lam" />
                                            </td>
                                        </tr>

                                        <!--
                        <tr height="24" valign=top>
                            <td> <label ><input type="checkbox" value="1" id="" name="lampiran_identitas_lainya" <?php echo $this->antclass->back_valuex(@$penelitian->lampiran_identitas_lainya, 'lampiran_identitas_lainya') == '1' ? 'checked' : ''; ?>> Identitas lainya</label> </td>
                            <td style="">
                                <textarea class="form-control" cols=50 rows=3 name="lampiran_identitas_lainya_val"><?php echo $this->antclass->back_valuex(@$penelitian->lampiran_identitas_lainya_val, 'lampiran_identitas_lainya_val'); ?></textarea>
                            </td>
                        </tr> -->
                                    </tbody>
                                </table>

                                <div style="margin: 10px 0; border-bottom: 3px solid #CCC;"></div>

                                <div align="center">
                                    <input class="btn btn-primary" type="submit" name="submit" value="<?php echo $submitvalue; ?>" class="bt" id="save_tmp" onClick="confim()" />
                                    <input class="btn btn-danger" type="reset" name="reset" value="Reset" class="bt" />
                                    <input type="hidden" name="h_rec_id" value="<?php echo $rec_id; ?>" />
                                    <input type="hidden" id="status_pencarian_nop" name="status_pencarian_nop" />

                                    <!-- form input nop -->
                                    <input type="hidden" name="nopsave_letak_tanah" id="idnopsave_letak_tanah">
                                    <input type="hidden" name="nopsave_propinsi" id="idnopsave_propinsi">
                                    <input type="hidden" name="nopsave_kabupaten" id="idnopsave_kabupaten">
                                    <input type="hidden" name="nopsave_kecamatan" id="idnopsave_kecamatan">
                                    <input type="hidden" name="nopsave_kelurahan" id="idnopsave_kelurahan">
                                    <input type="hidden" name="nopsave_rtrw" id="idnopsave_rtrw">

                                    <input type="hidden" name="nopsave_luas_tanah" id="idnopsave_luas_tanah">
                                    <input type="hidden" name="nopsave_luas_bangunan" id="idnopsave_luas_bangunan">
                                    <input type="hidden" name="nopsave_njop_tanah" id="idnopsave_njop_tanah">
                                    <input type="hidden" name="nopsave_njop_bangunan" id="idnopsave_njop_bangunan">
                                    <input type="hidden" name="nopsave_njop" id="idnopsave_njop">

                                    <input type="hidden" name="nopsave_no_serf" id="idnopsave_no_serf">
                                    <input type="hidden" name="nopsave_thnpjk" id="idnopsave_thnpjk">

                                    <!-- end form input nop -->

                                    <input type="hidden" name="text_no_sertifikat" id="no_sertipikat_nop_id_op">
                                    <input type="hidden" name="text_lokasi_op" id="lokasi_nop_id_op">
                                    <input type="hidden" name="text_thn_pajak_sppt" value="<?php echo date('Y') ?>">

                                    <input type="hidden" name="nama_penjual" id="nama_penjual">
                                    <input type="hidden" name="alamat_penjual" id="alamat_penjual">
                                </div>
                            </div>
                        </form>
                    </div>
                    <script type="text/javascript" src="<?= base_url() ?>assets/template/js/bootstrap-datepicker.js"></script>
                    <script type="text/javascript">
                        <?php if ($this->session->userdata('s_kd_dati2_nik') == '') { ?>
                            $(window).load(function() {
                                $('#nama_nik_id_text').hide();
                                $('#alamat_nik_id_text').hide();
                                $('#rtrw_nik_id_text').hide();
                                $('#kodepos_nik_id_text').hide();
                                $('#propinsi_nik_id_text').hide();
                                $('#kotakab_nik_id_text').hide();
                                $('#kecamatan_nik_id_text').hide();
                                $('#kelurahan_nik_id_text').hide();
                            });
                        <?php } else { ?>

                            $(window).load(function() {
                                $('#nama_nik_id_text').show();
                                $('#alamat_nik_id_text').show();
                                $('#rtrw_nik_id_text').show();
                                $('#kodepos_nik_id_text').show();
                                $('#propinsi_nik_id_text').show();
                                $('#kotakab_nik_id_text').show();
                                $('#kecamatan_nik_id_text').show();
                                $('#kelurahan_nik_id_text').show();
                            });

                        <?php }
                        ?>


                        $("#nama_nik_id_text").keyup(function() {
                            var ident = $("#nama_nik_id_text").val();
                            $("#ident").val(ident);
                        });

                        function harga_transaksi_change() {

                            var nilai_pasar_id = $('#nilai_pasar_id').val();
                            var nilai_pasar_arr = nilai_pasar_id.split('.');
                            var nilai_pasar = nilai_pasar_arr.join('');

                            var njop_pbb_nop_h_id = parseInt($('#njop_pbb_nop_h_id').val());
                            var jns_perolehan_op_id = $('#jns_perolehan_op_id').val();

                            var nilai_yang_dipilih = 1;
                            // if (jns_perolehan_op_id == '07') {
                            //     $('#inp_aphb3').val(nilai_pasar_id);
                            //     nilai_yang_dipilih = nilai_pasar_id;
                            //     hitung_aphb ();
                            // } else{
                            if (jns_perolehan_op_id == '08') {
                                $('#npop_id').val(number_format(nilai_pasar));
                                count_all(jns_perolehan_op_id);
                            } else {
                                if (parseInt(nilai_pasar) > parseInt(njop_pbb_nop_h_id)) {
                                    nilai_yang_dipilih = nilai_pasar;
                                    $('#npop_id').val(number_format(nilai_pasar));
                                    count_all(jns_perolehan_op_id);
                                } else {
                                    nilai_yang_dipilih = njop_pbb_nop_h_id;
                                    $('#npop_id').val(number_format(njop_pbb_nop_h_id));
                                    count_all(jns_perolehan_op_id);
                                }

                            }

                            $('#inp_aphb3').val(nilai_yang_dipilih);

                        }

                        function jenisAction(id_jenis) {

                            var njop_pbb_nop_h_id = $('#njop_pbb_nop_h_id').val();

                            var nilai_pasar_id = $('#nilai_pasar_id').val();

                            var nilai_yang_dipilih = 1;

                            if (nilai_pasar_id != '') {
                                var nilai_pasar_arr = nilai_pasar_id.split('.');
                                var nilai_pasar = nilai_pasar_arr.join('');

                                if (id_jenis == '08') {
                                    $('#npop_id').val(number_format(nilai_pasar));
                                } else {
                                    if (parseInt(nilai_pasar) > parseInt(njop_pbb_nop_h_id)) {
                                        $('#npop_id').val(number_format(nilai_pasar));
                                    } else {
                                        $('#npop_id').val(number_format(njop_pbb_nop_h_id));
                                    }
                                }
                            } else {
                                $('#npop_id').val(number_format(njop_pbb_nop_h_id));
                            }

                            if (id_jenis == '05') {
                                $('#npoptkp_id').removeAttr('readonly');
                            } else {
                                $('#npoptkp_id').attr('readonly', true);
                            }

                            $.ajax({
                                type: "POST",
                                url: "<?= site_url('sptpd/cek_progressif') ?>",
                                data: {
                                    nik: $('#id_nik_id').val(),
                                    jenis: $('#jns_perolehan_op_id').val()
                                }
                            }).done(function(cek) {

                                if (cek > 0) {
                                    $('#npoptkp_id').val(0);
                                    $('#npoptkp_lbl_id').html(0);
                                } else {
                                    if (id_jenis == '04' || id_jenis == '05') {
                                        $('#npoptkp_id').val(number_format('<?php echo $this->config->item('conf_npoptkp_300'); ?>'));
                                        $('#npoptkp_lbl_id').html(number_format('<?php echo number_format($this->config->item('conf_npoptkp_300'), 0, ',', '.'); ?>'));

                                        count_all(id_jenis);

                                    } else if (id_jenis == '14') {
                                        $('#npoptkp_id').val(number_format('<?php echo $this->config->item('conf_npoptkp_49'); ?>'));
                                        $('#npoptkp_lbl_id').html(number_format('<?php echo number_format($this->config->item('conf_npoptkp_49'), 0, ',', '.'); ?>'));


                                        count_all(id_jenis);

                                    } else if (id_jenis == '15') {
                                        $('#npoptkp_id').val(number_format('<?php echo $this->config->item('conf_npoptkp_10'); ?>'));
                                        $('#npoptkp_lbl_id').html(number_format('<?php echo number_format($this->config->item('conf_npoptkp_10'), 0, ',', '.'); ?>'));


                                        count_all(id_jenis);

                                    } else if (id_jenis == '07') {
                                        $('#npoptkp_id').val(number_format('<?php echo $this->config->item('conf_npoptkp_60'); ?>'));
                                        $('#npoptkp_lbl_id').html(number_format('<?php echo number_format($this->config->item('conf_npoptkp_60'), 0, ',', '.'); ?>'));
                                    } else {
                                        $('#npoptkp_id').val(number_format('<?php echo $this->config->item('conf_npoptkp_60'); ?>'));
                                        $('#npoptkp_lbl_id').html(number_format('<?php echo number_format($this->config->item('conf_npoptkp_60'), 0, ',', '.'); ?>'));

                                        count_all(id_jenis);

                                    }
                                }
                            })

                            count_all(id_jenis);

                            $('#inp_aphb3').val(nilai_yang_dipilih);
                        }

                        function hitung_aphb() {
                            var jns_perolehan = $('#jns_perolehan_op_id').val();
                            var inp_aphb1 = parseInt($('#inp_aphb1').val());
                            var inp_aphb2 = parseInt($('#inp_aphb2').val());

                            var s_inp_aphb3 = $('#inp_aphb3').val();

                            if (s_inp_aphb3 == '') {
                                var inp_aphb3 = 0;
                            } else {
                                var inp_aphb3_arr = s_inp_aphb3.split('.');
                                var inp_aphb3 = parseInt(inp_aphb3_arr.join(''));
                            }

                            var total = (inp_aphb1 / inp_aphb2) * inp_aphb3;

                            // $('#npop_id').val(Math.round(parseInt(total)));
                            $('#npop_id').val(number_format(total));

                            count_all(jns_perolehan);
                        }

                        function count_all(jenis) {
                            var nilai_npop_id = $('#npop_id').val()
                            var nilai_npop_arr = nilai_npop_id.split('.');
                            var npop = nilai_npop_arr.join('');

                            $.ajax({
                                type: "POST",
                                url: "<?= site_url('sptpd/cek_progressif') ?>",
                                data: {
                                    nik: $('#id_nik_id').val(),
                                    jenis: $('#jns_perolehan_op_id').val()
                                }
                            }).done(function(cek) {

                                if (cek > 0) {
                                    $('#npoptkp_id').val(0);
                                    $('#npoptkp_lbl_id').html(0);

                                    var npoptkp = 0;
                                } else if (jenis == '05') {
                                    var nilai_npoptkp_id = $('#npoptkp_id').val()
                                    var nilai_npoptkp_arr = nilai_npoptkp_id.split('.');
                                    var nilai_npoptkp = nilai_npoptkp_arr.join('');
                                    var npoptkp = nilai_npoptkp;
                                } else {
                                    if (jenis == '04' || jenis == '05') {
                                        var npoptkp = '<?php echo $this->config->item('conf_npoptkp_300'); ?>';
                                    } else if (jenis == '05') {
                                        var npoptkp = $('#npoptkp_id').val();
                                    } else if (jenis == '14') {
                                        var npoptkp = '<?php echo $this->config->item('conf_npoptkp_49'); ?>';
                                    } else if (jenis == '15') {
                                        var npoptkp = '<?php echo $this->config->item('conf_npoptkp_10'); ?>';
                                    } else {
                                        var npoptkp = '<?php echo $this->config->item('conf_npoptkp_60'); ?>';
                                    }

                                    $('#npoptkp_id').val(number_format(npoptkp));
                                    $('#npoptkp_lbl_id').html(number_format(npoptkp));
                                }


                                var npopkp = npop - npoptkp;
                                var bea_perolehan = 0.05 * npopkp;

                                // if(jenis == '04' || jenis == '05'){
                                //       var pengenaan50 = 0.5 * bea_perolehan;

                                //       var bea_bayar = pengenaan50;
                                // }else{
                                var pengenaan50 = 0;

                                var bea_bayar = bea_perolehan;
                                // }

                                $('#npopkp_id').html(number_format(npopkp, 0, ',', '.'));
                                $('#txt_npopkp_sptpd').val(npopkp);

                                $('#bea_perolehan_id').html(number_format(bea_perolehan, 0, ',', '.'));
                                $('#bea_perolehan_h_id').val(bea_perolehan);

                                $('#pengenaan50_id').html(number_format(pengenaan50, 0, ',', '.'));
                                $('#pengenaan50_h_id').val(pengenaan50);

                                $('#bea_bayar_id').html(number_format(bea_bayar, 0, ',', '.'));
                                $('#bea_bayar_h_id').val(bea_bayar);

                                if (bea_bayar <= 0) {
                                    $('#jml_setor_id').val(0);
                                    $('#txt_jml_setor_id').val(0);
                                } else {
                                    $('#jml_setor_id').val(bea_bayar);
                                    $('#txt_jml_setor_id').val(number_format(bea_bayar, 0, ',', '.'));
                                };

                                terbilang();
                            });
                        }

                        function terbilang() {
                            var val = $('#jml_setor_id').val();
                            var huruf = $('#terbilang');

                            $.ajax({
                                url: '<?php echo base_url() ?>index.php/sptpd/terbilang_val',
                                data: {
                                    enValue: val,
                                    ajax: 1
                                },
                                type: 'POST',
                                dataType: 'json',
                                success: function(data) {
                                    huruf.text('');
                                    if (data['result'].length > 0) {
                                        $('#terbilang').append(data['result'] + ' Rupiah');
                                    } else {
                                        huruf.text('');
                                    }
                                }
                            });
                        }

                        // Memilih KABUPATEN

                        function lookup_kabupaten_text() {
                            var string = $('#propinsi_nik_id_text').val();
                            if (string == '') {
                                $('#kotakab_nik_id_text').html('');
                            } else {
                                $.ajax({
                                    url: "<?php echo base_url(); ?>index.php/sptpd/get_kabupaten_bypropinsi",
                                    type: "POST",
                                    data: "propinsi_id=" + string,
                                    cache: false,
                                    success: function(data) {
                                        $('#kotakab_nik_id_text').html(data);
                                    }
                                });
                            }
                        }

                        // Jika session kabupaten ada

                        <?php if ($this->session->userdata('s_kd_dati2_nik') != '') { ?>
                            lookup_kabupaten_text();
                        <?php }
                        ?>



                        // Memilih Kecamatan

                        function lookup_kecamatan_text() {
                            var kd_propinsi = $('#propinsi_nik_id_text').val();
                            var string = $('#kotakab_nik_id_text').val();
                            console.log(string);
                            if (string == '') {
                                $('#kecamatan_nik_id_text').html('');
                            } else {
                                $.ajax({
                                    url: "<?php echo base_url(); ?>index.php/sptpd/get_kecamatan_bydati2",
                                    type: "POST",
                                    data: {
                                        dati2_id: string,
                                        kd_propinsi: kd_propinsi
                                    },
                                    cache: false,
                                    success: function(data) {
                                        $('#kecamatan_nik_id_text').html(data);
                                    }
                                });
                            }
                        }

                        // Jika Session Kecamatan ada

                        <?php if ($this->session->userdata('s_kd_kecamatan_nik') != '') { ?>

                            var id_kabupaten = "<?php echo $this->session->userdata('s_kd_dati2_nik'); ?>";
                            var id_kecamatan = "<?php echo $this->session->userdata('s_kd_kecamatan_nik'); ?>";
                            // alert(id_kabupaten);
                            $.ajax({
                                url: "<?php echo base_url(); ?>index.php/sptpd/get_kecamatan_bydati2_session?dati2_id=" + id_kabupaten + "&kd_kecamatan=" + id_kecamatan,
                                success: function(data) {
                                    $('#kecamatan_nik_id_text').html(data);
                                }
                            });
                        <?php }
                        ?>



                        /* Memilih kelurahan */

                        function lookup_kelurahan_text() {
                            var kd_propinsi = $('#propinsi_nik_id_text').val();
                            var kd_kabupaten = $('#kotakab_nik_id_text').val();
                            var string = $('#kecamatan_nik_id_text').val();
                            if (string == '') {
                                $('#kelurahan_nik_id_text').html('');
                            } else {
                                $.ajax({
                                    url: "<?php echo base_url(); ?>index.php/sptpd/get_kelurahan_bykecamatan",
                                    type: "POST",
                                    data: {
                                        kd_propinsi: kd_propinsi,
                                        kd_kabupaten: kd_kabupaten,
                                        kecamatan_id: string,
                                    },
                                    cache: false,
                                    success: function(data) {
                                        $('#kelurahan_nik_id_text').html(data);
                                    }
                                });
                            }
                        }

                        // JIka Session KELURAHAN ADA maka
                        <?php if ($this->session->userdata('s_kd_kelurahan_nik') != '') { ?>


                            var id_kecamatan = "<?php echo $this->session->userdata('s_kd_kecamatan_nik'); ?>";
                            var id_kelurahan = "<?php echo $this->session->userdata('s_kd_kelurahan_nik'); ?>";
                            // alert(id_kabupaten);
                            $.ajax({
                                url: "<?php echo base_url(); ?>index.php/sptpd/get_kelurahan_bykecamatan_session?kd_kecamatan=" + id_kecamatan + "&kd_kelurahan=" + id_kelurahan,
                                success: function(data) {
                                    $('#kelurahan_nik_id_text').html(data);
                                }
                            });
                        <?php }
                        ?>


                        function lookup_ppat(string) {
                            if (string == '') {
                                $('#nama_ppat_id').html('');
                            } else {
                                $.post("<?php echo base_url(); ?>index.php/ppat/get_ppat", {
                                    rx_id_ppat: "" + string + ""
                                }, function(data) {
                                    if (data.length > 0) {
                                        $('#ppat_data_id').html(data);
                                    }
                                });
                            }
                        }

                        function lookup_nik(string) {
                            if (string == '') {
                                $('#nama_nik_id').html('');
                            } else {
                                load_masking();
                                $.post("<?php echo base_url(); ?>index.php/sptpd/get_nik", {
                                    txt_id_nik_sptpd: "" + string + ""
                                }, function(data) {
                                    close_masking();
                                    if (data != "kosong") {
                                        var $select = $('.select2-c').select2();
                                        $select.each(function(i, item) {
                                            ($(item)).hasClass('select2-hidden-accessible') ?
                                                $(item).select2("destroy") :
                                                '';
                                        });

                                        $('#nik_data_id').html(data);

                                        $('#nama_nik_id_text').hide();
                                        $('#alamat_nik_id_text').hide();
                                        $('#rtrw_nik_id_text').hide();
                                        $('#kodepos_nik_id_text').hide();
                                        $('#propinsi_nik_id_text').hide();
                                        $('#kotakab_nik_id_text').hide();
                                        $('#kecamatan_nik_id_text').hide();
                                        $('#kelurahan_nik_id_text').hide();

                                    } else {
                                        alert('ID NIK ' + $('#nama_nik_id').val() + ' Tidak Ditemukan');
                                        $('.select2-c').select2();

                                        $('#nama_nik_id_text').show();
                                        $('#alamat_nik_id_text').show();
                                        $('#rtrw_nik_id_text').show();
                                        $('#kodepos_nik_id_text').show();
                                        $('#propinsi_nik_id_text').show();
                                        $('#kotakab_nik_id_text').show();
                                        $('#kecamatan_nik_id_text').show();
                                        $('#kelurahan_nik_id_text').show();

                                        $("#nama_nik_id").html("");
                                        $("#alamat_nik_id").html("");
                                        $("#kelurahan_nik_id").html("");
                                        $("#propinsi_nik_id").html("");
                                        $("#kecamatan_nik_id").html("");
                                        $("#kotakab_nik_id").html("");
                                        $("#rtrw_nik_id").html("");
                                        $("#kodepos_nik_id").html("");
                                    }
                                });
                            }
                        }

                        function get_list_history_pembayaran(nop) {
                            $.ajax({
                                // url: "<?php echo site_url('sptpd/get_history_pembayaran') ?>?nop="+nop
                                url: "<?php echo $this->config->item('url_service_history_pembayaran'); ?>" + nop,
                            }).done(function(hasil) {
                                if (hasil == '0') {
                                    $.ajax({
                                        url: "<?php echo $this->config->item('url_service_history_pembayaran_2'); ?>" + nop,
                                    }).done(function(hasil) {
                                        $('#list_history_pembayaran').html(hasil);
                                    });
                                    $('#belum_lunas').hide();
                                } else {
                                    $('#list_history_pembayaran').html(hasil);
                                    $('#belum_lunas').show();
                                }
                            });
                        }

                        function lookup_nop(string, nik) {

                            if (nik == '') {
                                alert('Nomor NIK atau NOP tidak boleh kosong.');
                            } else {
                                if (string == '') {
                                    $('#nama_nop_id').html('');
                                } else {
                                    load_masking();

                                    $.getJSON("<?php echo $this->config->item('url_service_nop'); ?>web_service/getnopbphtb?nop=" + string,
                                        function(response) {
                                            close_masking();
                                            // alert('iki')
                                            console.log(response);
                                            if (response.msg == 'Ada Data') {
                                                var $rt = response.RT_WP_SPPT ? '- RT/RW : ' + response.RT_WP_SPPT : '',
                                                    $rw = response.RW_WP_SPPT ? '/' + response.RW_WP_SPPT : '',
                                                    rt_rw = $rt + $rw;
                                                console.log(response);
                                                $('#status_pencarian_nop').val('dari sismiop');

                                                $('#lokasi_nop_id').html(response.NM_PROPINSI);
                                                $('#alamat_nop_id').html(response.JALAN_OP + ' ' + rt_rw + ' - ' + response.NM_KELURAHAN + ' - ' + response.NM_KECAMATAN);
                                                $('#lokasi_nop_id_op').val(response.NM_PROPINSI);
                                                // $('#kotakab_nop_id').html(response.NM_DATI2);
                                                // $('#kecamatan_nop_id').html(response.NM_KECAMATAN);
                                                // $('#kelurahan_nop_id').html(response.NM_KELURAHAN);
                                                // $('#rtrw_nop_id').html(rt_rw);

                                                $('#luas_tanah_id').val(response.LUAS_BUMI_SPPT);
                                                $('#njop_tanah_id').val(number_format(response.NILAI_PER_M2_BUMI));

                                                $('#luas_bangunan_id').val(response.LUAS_BNG_SPPT);
                                                $('#njop_bangunan_id').val(number_format(response.NILAI_PER_M2_BNG));

                                                $('#bangunan_inp_aphb3').val(response.LUAS_BNG_SPPT);
                                                $('#tanah_inp_aphb3').val(response.LUAS_BUMI_SPPT);

                                                // menghitung referensi bangunan dan tanah
                                                var ref_tanah = (response.NILAI_PER_M2_BUMI * 4) * response.LUAS_BUMI_SPPT;
                                                var ref_bangunan = (response.NILAI_PER_M2_BNG * 4) * response.LUAS_BNG_SPPT;

                                                $('#ref_tanah').val(ref_tanah);
                                                $('#ref_bangunan').val(ref_bangunan);
                                                $('#referensi_tanah').html('Rp. ' + number_format(ref_tanah));
                                                $('#referensi_bangunan').html('Rp. ' + number_format(ref_bangunan));
                                                $('#total_referensi').html('Rp. ' + number_format(ref_tanah + ref_bangunan));

                                                // menghitung total tanah dan bangunan

                                                var totalTanah = parseInt(response.LUAS_BUMI_SPPT) * parseInt(response.NILAI_PER_M2_BUMI);
                                                var totalBangunan = parseInt(response.LUAS_BNG_SPPT) * parseInt(response.NILAI_PER_M2_BNG);

                                                var totalSeluruh = totalTanah + totalBangunan;
                                                $('#l_njop_tanah_nop_id').html(number_format(totalTanah));
                                                $('#l_njop_tanah_nop_h_id').val(totalTanah);


                                                $('#l_njop_bangunan_nop_id').html(number_format(totalBangunan));
                                                $('#l_njop_bangunan_nop_h_id').val(totalBangunan);

                                                $('#njop_pbb_nop_id').html(number_format(totalSeluruh));
                                                $('#njop_pbb_nop_h_id').val(totalSeluruh);

                                                $('#npop_id').val(number_format(response.NJOP_SPPT));

                                                //untuk melakukan save data ke NOP
                                                $('#idnopsave_letak_tanah').val(response.NM_PROPINSI);
                                                $('#idnopsave_propinsi').val(response.NM_PROPINSI);
                                                $('#idnopsave_kabupaten').val(response.NM_DATI2);
                                                $('#idnopsave_kecamatan').val(response.NM_KECAMATAN);
                                                $('#idnopsave_kelurahan').val(response.NM_KELURAHAN);
                                                $('#idnopsave_rtrw').val(rt_rw);

                                                $('#idnopsave_luas_tanah').val(response.LUAS_BUMI_SPPT);
                                                $('#idnopsave_luas_bangunan').val(response.LUAS_BNG_SPPT);
                                                $('#idnopsave_njop_tanah').val(response.NILAI_PER_M2_BUMI);
                                                $('#idnopsave_njop_bangunan').val(response.NILAI_PER_M2_BNG);
                                                $('#idnopsave_njop').val(totalSeluruh);
                                                $('#idnopsave_thnpjk').val(response.THN_PAJAK_SPPT);

                                                $('#nama_penjual').val(response.NM_WP_SPPT);
                                                $('#alamat_penjual').val(response.JLN_WP_SPPT);

                                                //  UNTUK MELAKUKAN PENGECEKAN SPTPD

                                                /*$.ajax({
                                                    url:"<?php echo site_url('sptpd/cek_transaksi_previous') ?>?nik="+nik+"&npop_sel="+response.NJOP_SPPT,
                                                    success:function(CekData){
                                                        $('#nop_data_id').html(CekData);
                                                    }
                                                });*/

                                                get_list_history_pembayaran(string);

                                            } else {
                                                alert('NOP tidak ditemukan');

                                                $("#lokasi_nop_id").html("");
                                                // $("#kelurahan_nop_id").html("");
                                                // $("#kecamatan_nop_id").html("");
                                                // $("#kotakab_nop_id").html("");
                                                // $("#rtrw_nop_id").html("");
                                                $("#luas_tanah_nop_id").html("");
                                                $("#njop_tanah_nop_id").html("");
                                                $("#luas_bangunan_nop_id").html("");
                                                $("#njop_bangunan_nop_id").html("");
                                                $("#l_njop_tanah_nop_id").html("");
                                                $("#l_njop_bangunan_nop_id").html("");
                                                $("#njop_pbb_nop_id").html("");
                                                $("#nilai_nop_id").html("");
                                                $("#jns_perolehan_nop_id").html("");
                                                $("#no_sertipikat_nop_id").html("");

                                                $("#no_sertipikat_nop_id_op").html("");
                                                $("#lokasi_nop_id_op").html("");

                                                $('#alamat_nop_id').html('');
                                                $('#list_history_pembayaran').html('');
                                            }
                                        }
                                    );

                                }
                            }
                        }



                        function lookup_check_nik_prev(nik) {
                            if (nik == '') {
                                alert('Nomor NIK tidak boleh kosong.');
                            } else {
                                $.post("<?php echo base_url(); ?>index.php/sptpd/get_prev_bynik", {
                                    rx_id_nik: "" + nik + ""
                                }, function(data) {
                                    return data;
                                });
                            }
                        }

                        $('#nilai_pasar_id').on('keyup', function(event) {
                            $(this).mask("#.##0", {
                                reverse: true,
                                maxlength: false
                            });
                        });
                        $('#njop_tanah_id').on('keyup', function(event) {
                            $(this).mask("#.##0", {
                                reverse: true,
                                maxlength: false
                            });
                        });
                        $('#njop_bangunan_id').on('keyup', function(event) {
                            $(this).mask("#.##0", {
                                reverse: true,
                                maxlength: false
                            });
                        });
                        $('#njop_tanah_b_id, #njop_bangunan_b_id').on('keyup', function(event) {
                            $(this).mask("#.##0", {
                                reverse: true,
                                maxlength: false
                            });
                        });

                        <?php if ($this->session->userdata('s_txt_id_nop_sptpd') != '') { ?>
                            lookup_nop($('#nop_id').val(), $('#id_nik_id').val());
                        <?php }
                        ?>

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

                        function number_format(number, decimals, dec_point, thousands_sep) {
                            number = (number + '').replace(/[^0-9+\-Ee.]/g, '');

                            var n = !isFinite(+number) ? 0 : +number,

                                prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),

                                sep = (typeof thousands_sep === 'undefined') ? '.' : thousands_sep,

                                dec = (typeof dec_point === 'undefined') ? ',' : dec_point,

                                s = '',

                                toFixedFix = function(n, prec) {
                                    var k = Math.pow(10, prec);
                                    return '' + (Math.round(n * k) / k).toFixed(prec);
                                };

                            // Fix for IE parseFloat(0.55).toFixed(0) = 0;

                            s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
                            if (s[0].length > 3) {
                                s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
                            }
                            if ((s[1] || '').length < prec) {
                                s[1] = s[1] || '';
                                s[1] += new Array(prec - s[1].length + 1).join('0');
                            }

                            return s.join(dec);

                        }

                        <?php if ($submitvalue != 'Edit') : ?>
                            jQuery(function($) {
                                $("#id_ppat_id").mask(<?php echo "'" . $this->config->item('input_ppat_id') . "'"; ?>);
                                $("#nop_id").mask(<?php echo "'" . $this->config->item('input_nop_id') . "'"; ?>);
                                $("#txt_no_dokumen_sptpd").mask(<?php echo "'" . $this->config->item('input_document_sptpd') . "'"; ?>);
                                $("#txt_nop_pbb_baru_sptpd").mask(<?php echo "'" . $this->config->item('input_nop_pbb_baru') . "'"; ?>);
                            });

                            $(document).ready(function() {
                                // $('.select2').select2();
                                $('input').on('keydown', function(event) {
                                    var x = event.which;
                                    if (x === 13) {
                                        event.preventDefault();
                                    }
                                });

                                $('.lam').change(function() {
                                    var file = this.files[0];
                                    name = file.name;
                                    size = file.size;
                                    type = file.type;
                                    if (size > 2200000) {
                                        alert('File maksimal 2Mb');
                                        this.value = '';
                                    }
                                });

                                $('#id_ppat_id').focusout(function() {
                                    var nilai_ppat = $('#id_ppat_id').val();
                                    var count_ppat_length = nilai_ppat.length;
                                    var count_ppat_length2 = nilai_ppat.replace('_', '');
                                    if (count_ppat_length2.length < <?php echo $this->config->item('length_ppat_id'); ?>) {
                                        $('#id_ppat_id').text(nilai_ppat);
                                        // $('#ppat_error').before('<br/>');
                                        $('#ppat_error').css('margin-left', 0);
                                        $('#ppat_error').text('No ID PPAT ' + nilai_ppat + ' Tidak Ditemukan');
                                        $('#ppat_error').fadeIn(300).delay(1000).fadeOut('fast');
                                        //alert('ID PPAT harus <?php //echo $this->config->item('length_ppat_id');
                                                                ?> characters!!');
                                    }
                                });

                                $('#nop_id').focusout(function() {
                                    var nilai_nop = $('#nop_id').val();
                                    var count_nop_length = nilai_nop.length;
                                    var count_nop_length2 = nilai_nop.replace('_', '');
                                    if (count_nop_length2.length < <?php echo $this->config->item('length_nop_id'); ?>) {
                                        $('#nop_id').val(nilai_nop);
                                        // $('#nop_error').before('<br/>');
                                        $('#nop_error').css('margin-left', 0);
                                        $('#nop_error').text('NOP ' + nilai_nop + ' Tidak Ditemukan');
                                        $('#nop_error').fadeIn(300).delay(1000).fadeOut('fast');
                                        //alert('ID NOP harus <?php //echo $this->config->item('length_nop_id');
                                                                ?> characters!!');
                                    }
                                });

                                $('#txt_no_dokumen_sptpd').focusout(function() {
                                    var nilai_doc = $('#txt_no_dokumen_sptpd').val();
                                    var count_doc_length = nilai_doc.length;
                                    var count_doc_length2 = nilai_doc.replace('_', '');
                                    if (count_doc_length2.length < <?php echo $this->config->item('length_document_sptpd'); ?>) {
                                        $('#txt_no_dokumen_sptpd').val(nilai_doc);
                                        // $('#doc_error').before('<br/>');
                                        $('#doc_error').css('margin-left', 0);
                                        $('#doc_error').text('Nomor Dokumen harus <?php echo $this->config->item('length_document_sptpd'); ?> characters!!');
                                        $('#doc_error').fadeIn(300).delay(1000).fadeOut('fast');
                                        //alert('Nomor Dokumen harus <?php //echo $this->config->item('length_document_sptpd');
                                                                        ?> characters!!');
                                    }
                                });

                                $('#txt_nop_pbb_baru_sptpd').focusout(function() {
                                    var nilai_nop_baru = $('#txt_nop_pbb_baru_sptpd').val();
                                    var count_nop_baru_length = nilai_nop_baru.length;
                                    var count_nop_baru_length2 = nilai_nop_baru.replace('_', '');
                                    if (count_nop_baru_length2.length < <?php echo $this->config->item('length_nop_pbb_baru'); ?>) {
                                        $('#txt_nop_pbb_baru_sptpd').val(nilai_nop_baru);
                                        // $('#nop_baru_error').before('<br/>');
                                        $('#nop_baru_error').css('margin-left', 0);
                                        $('#nop_baru_error').text('NOP PBB Baru harus <?php echo $this->config->item('length_nop_pbb_baru'); ?> characters!!');
                                        $('#nop_baru_error').fadeIn(300).delay(1000).fadeOut('fast');
                                        //alert('NOP PBB Baru harus <?php //echo $this->config->item('length_nop_pbb_baru');
                                                                    ?> characters!!');
                                    }
                                });


                                // Untuk menyimpan semua data ke dalam sesion


                            });
                        <?php endif; ?>

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

                            $("#datepicker3").datepicker({
                                format: 'yyyy-mm-dd',
                                changeMonth: true,
                                changeYear: true,
                                showOn: 'button',
                                buttonImage: '<?= base_url_img() ?>calendar.gif',
                                buttonImageOnly: true
                            });
                        });

                        function count_npoptkp(npoptkp) {
                            var nilai_npop_id = $('#npop_id').val()
                            var nilai_npop_arr = nilai_npop_id.split('.');
                            var npop = nilai_npop_arr.join('');

                            var nilai_npoptkp_id = $('#npoptkp_id').val()
                            var nilai_npoptkp_arr = nilai_npoptkp_id.split('.');
                            var nilai_npoptkp = nilai_npoptkp_arr.join('');
                            var npoptkp = nilai_npoptkp;

                            $('#npoptkp_id').val(number_format(npoptkp));
                            $('#npoptkp_lbl_id').val(number_format(npoptkp));

                            var npopkp = npop - npoptkp;
                            var bea_perolehan = 0.05 * npopkp;

                            var pengenaan50 = 0;

                            var bea_bayar = bea_perolehan;

                            $('#npopkp_id').html(number_format(npopkp, 0, ',', '.'));
                            $('#txt_npopkp_sptpd').val(npopkp);

                            $('#bea_perolehan_id').html(number_format(bea_perolehan, 0, ',', '.'));
                            $('#bea_perolehan_h_id').val(bea_perolehan);

                            $('#pengenaan50_id').html(number_format(pengenaan50, 0, ',', '.'));
                            $('#pengenaan50_h_id').val(pengenaan50);

                            $('#bea_bayar_id').html(number_format(bea_bayar, 0, ',', '.'));
                            $('#bea_bayar_h_id').val(bea_bayar);

                            if (bea_bayar < 0) {
                                $('#jml_setor_id').val(0);
                                $('#txt_jml_setor_id').val(0);
                            } else {
                                $('#jml_setor_id').val(bea_bayar);
                                $('#txt_jml_setor_id').val(number_format(bea_bayar, 0, ',', '.'));
                            };

                            terbilang();
                        }



                        // save all data to sessio
                    </script>

                    <style>
                        #npop_aphb {
                            margin-top: 0px !important;
                        }
                    </style>