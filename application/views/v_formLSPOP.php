<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php for ($n = 1; $n <= $jml_bangunan; $n++) : ?>
    <?php
    $bangunanKe = $n;
    $hide = ($n != 1) ? 'hide' : '';
    ?>
    <form class="bordered-form form-horizontal frm-bangunan<?= "$bangunanKe $hide" ?>">
        <div class="form-wrapper">
            <div class="form-title text-center"><b>BANGUNAN <?= $bangunanKe ?></b></div>
            <div class="form-body">
                <div class="section-form-devider">
                    <div class="form-group" style="display: flex;">
                        <label class="col-sm-3 control-label">NOP</label>
                        <div class="col-sm-9">
                            <label class="control-label"><?= $nop ?></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">JENIS TRANSAKSI</label>
                        <div class="col-sm-9 jenis_transaksi_wrapper pl-0"></div>
                    </div>
                </div>
                <div class="text-center section-title">A. RINCIAN DATA BANGUNAN</div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">JENIS PEMBANGUNAN BANGUNAN</label>
                    <div class="col-sm-9 jenis_pembangunan_bangunan_wrapper pl-0"></div>
                </div>
                <div class="section-seperator"></div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="txt_luas_bangunan">LUAS BANGUNAN (M<sup>2</sup>)</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control num-only" name="txt_luas_bangunan" id="txt_luas_bangunan" value="0">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="txt_jumlah_lantai">JUMLAH LANTAI</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control num-only" name="txt_jumlah_lantai" id="txt_jumlah_lantai" value="0">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="sel_tahun_dibangun">TAHUN DIBANGUN</label>
                    <div class="col-sm-9">
                        <select class="form-control select2" name="sel_tahun_dibangun" id="sel_tahun_dibangun" style="width: 100%;">
                            <?php for ($i = 1945; $i <= date("Y"); $i++) : ?>
                                <?php $selected = ($i == date("Y")) ? 'selected' : '' ?>
                                <option value="<?= $i; ?>" <?= $selected ?>><?= $i; ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="sel_tahun_direnovasi">TAHUN DIRENOVASI</label>
                    <div class="col-sm-9">
                        <select class="form-control select2" name="sel_tahun_direnovasi" id="sel_tahun_direnovasi" style="width: 100%;">
                            <?php for ($i = 1945; $i <= date("Y"); $i++) : ?>
                                <?php $selected = ($i == date("Y")) ? 'selected' : '' ?>
                                <option value="<?= $i; ?>" <?= $selected ?>><?= $i; ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="txt_daya_listrik">DAYA LISTRIK (WATT)</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control num-only" name="txt_daya_listrik" id="txt_daya_listrik" value="0">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">KONDISI PADA UMUMNYA</label>
                    <div class="col-sm-9 kondisi_pada_umumnya_wrapper pl-0"></div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">KONSTRUKSI</label>
                    <div class="col-sm-9 konstruksi_wrapper pl-0"></div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">ATAP</label>
                    <div class="col-sm-9 atap_wrapper pl-0"></div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">DINDING</label>
                    <div class="col-sm-9 dinding_wrapper pl-0"></div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">LANTAI</label>
                    <div class="col-sm-9 lantai_wrapper pl-0"></div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">LANGIT-LANGIT</label>
                    <div class="col-sm-9 langit_langit_wrapper pl-0"></div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </form>
<?php endfor; ?>
<script>
    jml_bangunan = <?= $jml_bangunan ?>;
    currentActiveFormBangunan = 1;
    lspopData = <?= json_encode($lspopData) ?>;
    buttonFormBangunanManager();

    //MEMBUAT SEBUAH AKSI KETIKA BUTTON BACK DIKLIK
    $("#modalFormLSPOP .btn-back").click(function(e) {
        if (currentActiveFormBangunan > 1) {
            currentActiveFormBangunan -= 1;
        }
        buttonFormBangunanManager();
        activeFormManager();
    });

    //MEMBUAT SEBUAH AKSI KETIKA BUTTON NEXT DIKLIK
    $("#modalFormLSPOP .btn-next").click(function(e) {
        if (currentActiveFormBangunan < jml_bangunan) {
            currentActiveFormBangunan += 1;
        }
        buttonFormBangunanManager();
        activeFormManager();

        $('#modalFormLSPOP .modal-body').animate({
            scrollTop: 0
        }, 300);
    });

    //MEMBUAT INPUTAN AGAR BERNILAI ANGKA SAJA
    $(".num-only").keyup(function(e) {
        $(this).val(numOnly($(this).val()));
    });

    $(".num-only").change(function(e) {
        $(this).val(numOnly($(this).val()));
    });

    //MENYIMPAN SEMUA DATA KE DALAM VARIABEL lspopData
    $(".btn-simpan").click(function(e) {
        if (confirm("Apakah Semua Data Bangunan Sudah Benar?")) {
            simpanSemuaDataBangunan();
            $('#modalFormLSPOP').modal('hide');
        }
    });

    //MENGHILANGKAN SEMUA EVENT LISTENER
    $('#modalFormLSPOP').on('hidden.bs.modal', function() {
        jml_bangunan = 1;
        currentActiveFormBangunan = 1;
        $('#modalFormLSPOP .btn-next, #modalFormLSPOP .btn-back').unbind('click');
        $('#modalFormLSPOP .btn-next, #modalFormLSPOP .btn-next').unbind('click');
        $('.num-only').unbind('keyup');
        $('.num-only').unbind('change');
        $('.btn-simpan').unbind('click');
    });

    //UNTUK MENGATUR TAMPILAN ELEMENT SELECT OPTION MENGGUNAKAN PLUGIN SELECT2
    for (var i = 1; i <= <?= $jml_bangunan ?>; i++) {
        $(".frm-bangunan" + i + " .select2").select2();
    }

    function simpanSemuaDataBangunan() {
        for (var n = 0; n < <?= $jml_bangunan ?>; n++) {
            lspopData[n].jenis_transaksi = parseInt($("#modalFormLSPOP .frm-bangunan" + (n + 1) + " input[name=rd_jenis_transaksi]:checked").val());
            lspopData[n].bangunan_ke = n + 1;
            lspopData[n].jenis_bangunan = parseInt($("#modalFormLSPOP .frm-bangunan" + (n + 1) + " input[name=rd_jenis_pembangunan_bangunan]:checked").val());
            lspopData[n].luas_bangunan = parseInt($("#modalFormLSPOP .frm-bangunan" + (n + 1) + " input[name=txt_luas_bangunan]").val());
            lspopData[n].jumlah_lantai = parseInt($("#modalFormLSPOP .frm-bangunan" + (n + 1) + " input[name=txt_jumlah_lantai]").val());
            lspopData[n].tahun_dibangun = parseInt($("#modalFormLSPOP .frm-bangunan" + (n + 1) + " select[name=sel_tahun_dibangun]").val());
            lspopData[n].tahun_direnovasi = parseInt($("#modalFormLSPOP .frm-bangunan" + (n + 1) + " select[name=sel_tahun_direnovasi]").val());
            lspopData[n].daya_listrik = parseInt($("#modalFormLSPOP .frm-bangunan" + (n + 1) + " input[name=txt_daya_listrik]").val());
            lspopData[n].kondisi = parseInt($("#modalFormLSPOP .frm-bangunan" + (n + 1) + " input[name=rd_kondisi_pada_umumnya]:checked").val());
            lspopData[n].konstruksi = parseInt($("#modalFormLSPOP .frm-bangunan" + (n + 1) + " input[name=rd_konstruksi]:checked").val());
            lspopData[n].atap = parseInt($("#modalFormLSPOP .frm-bangunan" + (n + 1) + " input[name=rd_atap]:checked").val());
            lspopData[n].dinding = parseInt($("#modalFormLSPOP .frm-bangunan" + (n + 1) + " input[name=rd_dinding]:checked").val());
            lspopData[n].lantai = parseInt($("#modalFormLSPOP .frm-bangunan" + (n + 1) + " input[name=rd_lantai]:checked").val());
            lspopData[n].langit_langit = parseInt($("#modalFormLSPOP .frm-bangunan" + (n + 1) + " input[name=rd_langit_langit]:checked").val());
        }
        $("input[name=lspopdata]").val(JSON.stringify(lspopData));
    }

    //METHOD UNTUK MENGATUR MENAMPILKAN BUTTON NEXT DAN SIMPAN
    function buttonFormBangunanManager() {
        if (currentActiveFormBangunan == jml_bangunan) { //JIKA FORM YANG AKTIF FORM TERAKHIR
            if (jml_bangunan == 1) {
                $("#modalFormLSPOP .btn-back").addClass('disabled');
            } else {
                $("#modalFormLSPOP .btn-back").removeClass('disabled');
            }
            $("#modalFormLSPOP .btn-next").addClass('disabled');
            $("#modalFormLSPOP .btn-simpan").removeClass('disabled');
        } else if (currentActiveFormBangunan == 1) { //JIKA FORM YANG AKTIF FORM AWAL
            $("#modalFormLSPOP .btn-back").addClass('disabled');
            $("#modalFormLSPOP .btn-next").removeClass('disabled');
            $("#modalFormLSPOP .btn-simpan").addClass('disabled');
        } else if (currentActiveFormBangunan != jml_bangunan) { //JIKA FORM YANG AKTIF FORM TENGAH TENGAH
            $("#modalFormLSPOP .btn-back").removeClass('disabled');
            $("#modalFormLSPOP .btn-next").removeClass('disabled');
            $("#modalFormLSPOP .btn-simpan").addClass('disabled');
        }
    }

    function activeFormManager() {
        $("#modalFormLSPOP form[class*=frm-bangunan]").addClass('hide');
        $("#modalFormLSPOP .frm-bangunan" + currentActiveFormBangunan).removeClass('hide');
    }

    function numOnly(str) {
        var res = str.replace(/\D/g, '');
        //res = (res == "") ? 0 : res;
        return res;
    }

    function loadLastInputtedValue() {
        for (var n = 0; n < <?= $jml_bangunan ?>; n++) {
            $("#modalFormLSPOP .frm-bangunan" + (n + 1) + " input[name=rd_jenis_transaksi][value=" + lspopData[n].jenis_transaksi + "]").prop("checked", true);
            $("#modalFormLSPOP .frm-bangunan" + (n + 1) + " input[name=rd_jenis_pembangunan_bangunan][value=" + lspopData[n].jenis_bangunan + "]").prop("checked", true);
            $("#modalFormLSPOP .frm-bangunan" + (n + 1) + " input[name=rd_kondisi_pada_umumnya][value=" + lspopData[n].kondisi + "]").prop("checked", true);
            $("#modalFormLSPOP .frm-bangunan" + (n + 1) + " input[name=rd_konstruksi][value=" + lspopData[n].konstruksi + "]").prop("checked", true);
            $("#modalFormLSPOP .frm-bangunan" + (n + 1) + " input[name=rd_atap][value=" + lspopData[n].atap + "]").prop("checked", true);
            $("#modalFormLSPOP .frm-bangunan" + (n + 1) + " input[name=rd_dinding][value=" + lspopData[n].dinding + "]").prop("checked", true);
            $("#modalFormLSPOP .frm-bangunan" + (n + 1) + " input[name=rd_lantai][value=" + lspopData[n].lantai + "]").prop("checked", true);
            $("#modalFormLSPOP .frm-bangunan" + (n + 1) + " input[name=rd_langit_langit][value=" + lspopData[n].langit_langit + "]").prop("checked", true);

            $("#modalFormLSPOP .frm-bangunan" + (n + 1) + " input[name=txt_luas_bangunan]").val(lspopData[n].luas_bangunan);
            $("#modalFormLSPOP .frm-bangunan" + (n + 1) + " input[name=txt_jumlah_lantai]").val(lspopData[n].jumlah_lantai);
            $("#modalFormLSPOP .frm-bangunan" + (n + 1) + " input[name=txt_daya_listrik]").val(lspopData[n].daya_listrik);

            //$("#modalFormLSPOP .frm-bangunan" + (n + 1) + " select[name=sel_tahun_dibangun]").val(lspopData[n].tahun_dibangun);
            //$("#modalFormLSPOP .frm-bangunan" + (n + 1) + " select[name=sel_tahun_direnovasi]").val(lspopData[n].tahun_direnovasi);
            $("#modalFormLSPOP .frm-bangunan" + (n + 1) + " select[name=sel_tahun_dibangun]").select2().select2('val', lspopData[n].tahun_dibangun);
            $("#modalFormLSPOP .frm-bangunan" + (n + 1) + " select[name=sel_tahun_direnovasi]").select2().select2('val', lspopData[n].tahun_direnovasi);

            //$('select').select2().select2('val', '3')
        }
    }

    function LSPOPvalidation() {

    }
</script>