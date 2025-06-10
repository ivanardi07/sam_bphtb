<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="page-title">
    <h2><span class="fa fa-arrow-circle-o-left"></span>
        Detail SSPD
    </h2>
</div>

<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
            <a href="<?= $this->c_loc ?>" class="btn btn-sm btn-info">Kembali</a>
            <br>
            <br>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">

                    <h3>Wajib Pajak</h3>
                    <table align="center" class="table table-bordered table-hover" cellspacing="2" width="100%">
                        <tr>
                            <td width="300" class="fields_label" align="left">Nomor Pelayanan</td>
                            <td width="1" align="center">:</td>
                            <td class="linebottom">
                                <span class="text_header"><?php echo @$sptpd->NoPel; ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="fields_label" align="left">Tanggal Verifikasi Lapangan</td>
                            <td align="center">:</td>
                            <td class="linebottom">
                                <span class="text_header"><?php echo tanggalIndo(@$sptpd->Tglverlap); ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="fields_label" align="left">Tanggal</td>
                            <td align="center">:</td>
                            <td class="linebottom">
                                <span class="text_header"><?php echo tanggalIndo(@$sptpd->Tgl); ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="fields_label" align="left">Nomor Surat</td>
                            <td align="center">:</td>
                            <td class="linebottom">
                                <span class="text_header"><?php echo @$sptpd->nosurat; ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="fields_label" align="left">Nomor Surat Keluar</td>
                            <td align="center">:</td>
                            <td class="linebottom">
                                <span class="text_header"><?php echo @$sptpd->NosuratKet; ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="fields_label" align="left">Nomor</td>
                            <td align="center">:</td>
                            <td class="linebottom">
                                <span class="text_header"><?php echo @$sptpd->nomor; ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="fields_label" align="left">Nama WP</td>
                            <td align="center">:</td>
                            <td class="linebottom">
                                <span class="text_header"><?php echo @$sptpd->namawp; ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="fields_label" align="left">NPWP</td>
                            <td align="center">:</td>
                            <td class="linebottom">
                                <span class="text_header"><?php echo @$sptpd->npwp; ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="fields_label" align="left">Alamat WP</td>
                            <td align="center">:</td>
                            <td class="linebottom">
                                <span class="text_header"><?php echo @$sptpd->alamatwp; ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="fields_label" align="left">RT / RW WP</td>
                            <td align="center">:</td>
                            <td class="linebottom">
                                <span class="text_header"><?php echo @$sptpd->rtwp; ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="fields_label" align="left">Kabupaten WP</td>
                            <td align="center">:</td>
                            <td class="linebottom">
                                <span class="text_header"><?php echo @$sptpd->kabupatenWP; ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="fields_label" align="left">Kecamatan WP</td>
                            <td align="center">:</td>
                            <td class="linebottom">
                                <span class="text_header"><?php echo @$sptpd->kecamatanwp; ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="fields_label" align="left">Kelurahan WP</td>
                            <td align="center">:</td>
                            <td class="linebottom">
                                <span class="text_header"><?php echo @$sptpd->kelurahanwp; ?></span>
                            </td>
                        </tr>
                    </table>

                    <h3>Objek Pajak</h3>
                    <table align="center" class="table table-bordered table-hover" cellspacing="2" width="100%">
                        <tr>
                            <td width="300" class="fields_label" align="left">NOP</td>
                            <td width="1" align="center">:</td>
                            <td class="linebottom">
                                <span class="text_header"><?php echo @$sptpd->NOP; ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="fields_label" align="left">Letak OP</td>
                            <td align="center">:</td>
                            <td class="linebottom">
                                <span class="text_header"><?php echo @$sptpd->LetakOP; ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="fields_label" align="left">RT / RW OP</td>
                            <td align="center">:</td>
                            <td class="linebottom">
                                <span class="text_header"><?php echo @$sptpd->RTop; ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="fields_label" align="left">Kabupaten OP</td>
                            <td align="center">:</td>
                            <td class="linebottom">
                                <span class="text_header"><?php echo @$sptpd->KabupatenOP; ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="fields_label" align="left">Kecamatan OP</td>
                            <td align="center">:</td>
                            <td class="linebottom">
                                <span class="text_header"><?php echo @$sptpd->KecamatanOP; ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="fields_label" align="left">Kelurahan OP</td>
                            <td align="center">:</td>
                            <td class="linebottom">
                                <span class="text_header"><?php echo @$sptpd->KelurahanOP; ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="fields_label" align="left">Luas Tanah</td>
                            <td align="center">:</td>
                            <td class="linebottom">
                                <span class="text_header"><?php echo rupiah(@$sptpd->LT); ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="fields_label" align="left">Luas Tanah NJOP</td>
                            <td align="center">:</td>
                            <td class="linebottom">
                                <span class="text_header"><?php echo rupiah(@$sptpd->LtNJOP); ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="fields_label" align="left">Luas Tanah Total</td>
                            <td align="center">:</td>
                            <td class="linebottom">
                                <span class="text_header"><?php echo rupiah(@$sptpd->LuasLT); ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="fields_label" align="left">Luas Bangunan</td>
                            <td align="center">:</td>
                            <td class="linebottom">
                                <span class="text_header"><?php echo rupiah(@$sptpd->LB); ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="fields_label" align="left">Luas Bangunan NJOP</td>
                            <td align="center">:</td>
                            <td class="linebottom">
                                <span class="text_header"><?php echo rupiah(@$sptpd->LbNJOP); ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="fields_label" align="left">Luas Bangunan Total</td>
                            <td align="center">:</td>
                            <td class="linebottom">
                                <span class="text_header"><?php echo rupiah(@$sptpd->LuasLB); ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="fields_label" align="left">NJOP PBB</td>
                            <td align="center">:</td>
                            <td class="linebottom">
                                <span class="text_header"><?php echo rupiah(@$sptpd->NJOPpbb); ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="fields_label" align="left">Jenis Perolehan</td>
                            <td align="center">:</td>
                            <td class="linebottom">
                                <span class="text_header"><?php echo @$sptpd->JenisPerolehan; ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="fields_label" align="left">Nilai Pasar</td>
                            <td align="center">:</td>
                            <td class="linebottom">
                                <span class="text_header"><?php echo rupiah(@$sptpd->NilaiPasar); ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="fields_label" align="left">Nomor Sertifikat</td>
                            <td align="center">:</td>
                            <td class="linebottom">
                                <span class="text_header"><?php echo @$sptpd->NoSertifikat; ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="fields_label" align="left">NPOP</td>
                            <td align="center">:</td>
                            <td class="linebottom">
                                <span class="text_header"><?php echo rupiah(@$sptpd->NPOP); ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="fields_label" align="left">NPOPTKP</td>
                            <td align="center">:</td>
                            <td class="linebottom">
                                <span class="text_header"><?php echo rupiah(@$sptpd->NPOPTKP); ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="fields_label" align="left">NPOPKP</td>
                            <td align="center">:</td>
                            <td class="linebottom">
                                <span class="text_header"><?php echo rupiah(@$sptpd->NPOPKP); ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="fields_label" align="left">Bea Perolehan</td>
                            <td align="center">:</td>
                            <td class="linebottom">
                                <span class="text_header"><?php echo rupiah(@$sptpd->BeaPerolehan); ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="fields_label" align="left">Kurang Bayar</td>
                            <td align="center">:</td>
                            <td class="linebottom">
                                <span class="text_header"><?php echo rupiah(@$sptpd->KurangBayar); ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="fields_label" align="left">Jumlah Setoran</td>
                            <td align="center">:</td>
                            <td class="linebottom">
                                <span class="text_header"><?php echo rupiah(@$sptpd->JumlahSetoran); ?></span>
                            </td>
                        </tr>
                    </table>

                    <table align="center" class="table table-bordered table-hover" cellspacing="2" width="100%">
                        <tr>
                            <td width="300" class="fields_label" align="left">Notaris</td>
                            <td width="1" align="center">:</td>
                            <td class="linebottom">
                                <span class="text_header"><?php echo @$sptpd->Notaris; ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td width="300" class="fields_label" align="left">Luas Tanah Bersama</td>
                            <td width="1" align="center">:</td>
                            <td class="linebottom">
                                <span class="text_header"><?php echo rupiah(@$sptpd->LTbersama); ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td width="300" class="fields_label" align="left">Luas Tanah NJOP Bersama</td>
                            <td width="1" align="center">:</td>
                            <td class="linebottom">
                                <span class="text_header"><?php echo rupiah(@$sptpd->LtNJOPbersama); ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td width="300" class="fields_label" align="left">Luas Tanah Total Bersama</td>
                            <td width="1" align="center">:</td>
                            <td class="linebottom">
                                <span class="text_header"><?php echo rupiah(@$sptpd->LuasLTbersama); ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td width="300" class="fields_label" align="left">Luas Bangunan Bersama</td>
                            <td width="1" align="center">:</td>
                            <td class="linebottom">
                                <span class="text_header"><?php echo rupiah(@$sptpd->LBbersama); ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td width="300" class="fields_label" align="left">Luas Bangunan NJOP Bersama</td>
                            <td width="1" align="center">:</td>
                            <td class="linebottom">
                                <span class="text_header"><?php echo rupiah(@$sptpd->LbNJOPbersama); ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td width="300" class="fields_label" align="left">Luas Bangunan Total Bersama</td>
                            <td width="1" align="center">:</td>
                            <td class="linebottom">
                                <span class="text_header"><?php echo rupiah(@$sptpd->LuasLBbersama); ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td width="300" class="fields_label" align="left">Waris</td>
                            <td width="1" align="center">:</td>
                            <td class="linebottom">
                                <span class="text_header"><?php echo @$sptpd->waris; ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td width="300" class="fields_label" align="left">Keterangan</td>
                            <td width="1" align="center">:</td>
                            <td class="linebottom">
                                <span class="text_header"><?php echo @$sptpd->Keterangan; ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td width="300" class="fields_label" align="left">User</td>
                            <td width="1" align="center">:</td>
                            <td class="linebottom">
                                <span class="text_header"><?php echo @$sptpd->User; ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td width="300" class="fields_label" align="left">Telepon</td>
                            <td width="1" align="center">:</td>
                            <td class="linebottom">
                                <span class="text_header"><?php echo @$sptpd->Telepon; ?></span>
                            </td>
                        </tr>
                    </table>
                </div>

            </div </div>

        </div>
    </div>

</div>