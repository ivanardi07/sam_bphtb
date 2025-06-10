<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php $akses = $this->session->userdata('s_tipe_bphtb'); ?>
<!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/searchpanes/1.1.1/css/searchPanes.dataTables.min.css"> -->
<!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/select/1.3.1/css/select.dataTables.min.css"> -->

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/rowreorder/1.2.7/css/rowReorder.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.5/css/responsive.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
<style type="text/css">
    .panel .panel-body {
        padding-bottom: 0px;
    }

    #form-input input {
        width: 200px;
        padding: 0 10px;
        height: 40px;
    }

    #form-input {
        position: relative;
        max-width: 400px;
    }

    tfoot input {
        width: 100%;
        padding: 3px;
        box-sizing: border-box;
    }
</style>

<div class="page-title">
    <h2 style="display:block"><span class="fa fa-arrow-circle-o-left"></span> VALIDASI TTE - BPHTB</h2>
    <p class="text-danger" style="clear: both;"><small>*Kebenaran Berkas Yang Diajukan Merupakan Tanggung Jawab Dari Pemohon dan Bukan Tanggung Jawab Dari Bapenda Kota Malang</small></p>
</div>

<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="col-md-12">
                    <?php if (!empty($info)) {
                        echo $info;
                    } ?>
                </div>

                <!-- TAMBAH -->
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-6">
                            <a class="btn btn-success" href="<?php echo $c_loc . '/' . 'refresh'; ?>"><span class="fa fa-refresh"></span>Refresh Data</a>
                            <a class="btn btn-primary proses-validasi-massal" href="javascript:void(0)"><span class="fa fa-pencils"></span>Proses Validasi Massal</a>
                        </div>
                        <?php if ($akses == 'D') : ?>
                            <div class="col-md-6">
                                <button class="btn btn-warning pull-right" value="proses" id="proses"><span class="fa fa-file"></span><?php echo $count; ?> Berkas Harus Divalidasi</button>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="tabelsptpd" class="table table-striped table-bordered" style="width:100%;">
                        <thead>
                            <tr class="tblhead">
                                <th class="text-center" style="width: 10px; display: none">ID_SPTPD</th>
                                <th class="text-center" style="width: 10px;"><input type="checkbox" class="select-all"></th>
                                <th class="text-center" style="width: 5px;">No.</th>
                                <th class="text-center" style="width: 60px;">Tanggal Pengajuan</th>
                                <th class="text-center" style="width: 45px;">No. Pelayanan</th>
                                <th class="text-center" style="width: 65px;">Nama Wajib Pajak</th>
                                <th class="text-center" style="width: 150px;">Alamat OP</th>
                                <th class="text-center" style="width: 65px;">Jumlah Setor</th>
                                <th class="text-center" style="width: 65px;">Status</th>
                                <th class="text-center" style="width: 15px;">Action</th>
                                <th class="text-center" style="width: 150px; display: none">APROVE</th>
                                <th class="text-center" style="width: 150px; display: none">IS_LUNAS</th>
                                <th class="text-center" style="width: 150px; display: none">PROSES</th>
                                <th class="text-center" style="width: 65px; display: none">No. SSPD/Dokumen</th>
                                <th class="text-center" style="width: 65px;display: none">WAJIBPAJAK</th>
                            </tr>
                        </thead>

                        <tfoot>
                            <tr>
                                <th class="text-center" style="width: 10px; display: none">ID_SPTPD</th>
                                <th class="text-center" style="width: 10px;"><input type="checkbox" class="select-all"></th>
                                <th class="text-center" style="width: 5px;">No.</th>
                                <th class="text-center" style="width: 60px;">Tanggal Pengajuan</th>
                                <th class="text-center" style="width: 45px;">No. Pelayanan</th>
                                <th class="text-center" style="width: 65px;">Nama Wajib Pajak</th>
                                <th class="text-center" style="width: 150px;">Alamat OP</th>
                                <th class="text-center" style="width: 65px;">Jumlah Setor</th>
                                <th class="text-center" style="width: 65px;">Status</th>
                                <th class="text-center" style="width: 15px;">Action</th>
                                <th class="text-center" style="width: 150px; display: none">APROVE</th>
                                <th class="text-center" style="width: 150px; display: none">IS_LUNAS</th>
                                <th class="text-center" style="width: 150px; display: none">PROSES</th>
                                <th class="text-center" style="width: 65px; display: none">No. SSPD/Dokumen</th>
                                <th class="text-center" style="width: 65px;display: none">WAJIBPAJAK</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL DETAIL -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Detail</h4>
                </div>
                <div class="modal-body" id="detail_rejek"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div id="ini_di_print"></div>

    <?php if ($this->session->userdata('jabatan') == '2') : ?>
        <style>
            #myModalInputNIKdanPassphrase .modal-dialog {
                position: relative;
                top: 50%;
                transform: translateY(-75%) !important;
            }

            .progress-bar-text {
                margin-top: 20px;
            }

            .progress-bar {
                width: 80%;
                height: unset;
                background-color: #f3f3f3;
                border-radius: 5px;
                overflow: unset;
                display: block;
                margin: 5px auto;
                float: unset;
            }

            .progress {
                height: 15px;
                background-color: #4caf50;
                width: 0%;
                transition: width 0.4s;
            }
        </style>
        <!-- Modal Input NIK dan PASSPHRASE TTE -->
        <div class="modal fade" id="myModalInputNIKdanPassphrase" tabindex="-1" role="dialog" aria-labelledby="myModalInputNIKdanPassphraseLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalInputNIKdanPassphraseLabel">VALIDASI TTE</h4>
                    </div>
                    <form class="form-horizontal" id="form_validasi_akhir_tte">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="nik_tte" class="col-sm-2 control-label">NIK</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" id="nik_tte" name="nik_tte" value="<?= @$nik_tte_kabid ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="passphrase_tte" class="col-sm-2 control-label">Passphrase</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="password" id="passphrase_tte" name="passphrase_tte" value="">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary btn-proses-tte"><i class="fa fa-download"></i>PROSES TTE</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">BATAL</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endif ?>

    <script src="<?= base_url() . 'assets/scripts/jquery.print/jquery.print.js' ?>"></script>

    <!-- tambah script di assets/scripts/search_sptpd -->

    <!-- <script src="<?= base_url() . 'assets/scripts/search_sptpd/jquery-3.5.1.js' ?>"></script> -->
    <script src="<?= base_url('assets/plugin/sweetalert/sweetalert2.all.min.js') ?>"></script>
    <script src="<?= base_url() . 'assets/scripts/search_sptpd/jquery.dataTables.min.js' ?>"></script>
    <script src="<?= base_url() . 'assets/scripts/search_sptpd/dataTables.bootstrap4.min.js' ?>"></script>
    <script src="https://cdn.datatables.net/rowreorder/1.2.7/js/dataTables.rowReorder.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.5/js/dataTables.responsive.min.js"></script>

    <script type="text/javascript">
        var akses = "<?php print($akses); ?>";
        var jabatan = "<?php print($userdata['jabatan']); ?>";
        var table = null;
        var total_sptpd_terpilih = 0;
        var daftar_id_sptpd_mau_divalidasi = [];
        var jmlBerhasilTTE = 0;
        var jmlGagalTTE = 0;

        $(document).ready(function() {
            var columnCount = 0;
            var columnDisabledInput = [1, 2, 9];
            var format = {
                "3": {
                    "className": "filter-tanggal"
                }
            };

            var akses = <?php echo json_encode($this->session->userdata('s_tipe_bphtb'), JSON_HEX_TAG); ?>;
            var id_ppat = <?php echo json_encode($this->session->userdata('s_id_ppat'), JSON_HEX_TAG); ?>;
            var id_wp = <?php echo json_encode($this->session->userdata('s_id_wp'), JSON_HEX_TAG); ?>;
            var userdata = <?php echo json_encode($userdata['jabatan'], JSON_HEX_TAG); ?>;

            $('#tabelsptpd tfoot th').each(function() {
                var title = $(this).text();

                if (!columnDisabledInput.includes(columnCount)) {
                    var className = "";
                    var columnNum = columnCount;
                    if (format[columnCount])
                        className = format[columnCount].className;

                    if (columnCount == 8) {
                        daftar_status = [
                            'LUNAS',
                        ]
                        columnNum = 16;
                    }

                    if (columnCount == 8) {
                        var selectInput = '<div class="input-group">';
                        selectInput += '<select class="filter_status form-control"><option value="">Status</option>';
                        daftar_status.forEach(element => {
                            selectInput += '<option value="' + element + '">' + element + '</option>';
                        });
                        selectInput += '</select>';
                        selectInput += '<div class="input-group-btn"><button class="btn btn-primary" type"button" column="' + columnCount + '">cari</button></div></div>';
                        $(this).html(selectInput);
                    } else {
                        $(this).html('<div class="input-group"><input type="text" class="form-control ' + className + '" column="' + columnNum + '" placeholder="' + title + '" /><div class="input-group-btn"><button class="btn btn-primary" type"button" column="' + columnCount + '">cari</button></div></div>');
                    }

                    $(".filter-tanggal").datepicker({
                        format: 'dd-mm-yyyy',
                        todayHighlight: true,
                        autoclose: true,
                        container: '#sandbox',
                        setDate: new Date("<?php echo date("Y-m-d") ?>")
                    });
                }
                columnCount++;
            });

            table = $('#tabelsptpd').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "<?= base_url('index.php/serverside/lunas') ?>",
                    "data": function(outData, d) {
                        return outData;
                    },
                    dataFilter: function(inData, d) {
                        return inData;
                    },
                    error: function(err, status) {
                        console.log(err);
                        $("#tabelsptpd_processing").hide();
                        alert("Gagal mengambil data.. Coba Lagi.");
                    },
                    type: 'POST',
                    data: {
                        akses: akses,
                        id_ppat: id_ppat,
                        userdata: userdata,
                        id_wp: id_wp,
                        mode: "validasi_tte"
                    },
                    "dataSrc": "data"
                },
                order: [
                    [2, 'desc']
                ],
                columnDefs: [{
                        targets: 0,
                        visible: false,
                        searchable: false,
                    }, {
                        targets: 1,
                        "data": null,
                        "render": function(data, type, row) {
                            return '<input type="checkbox" class="row-select" value="' + row[0] + '">';
                        },
                        name: "checkbox",
                        searchable: false,
                        orderable: false,
                        className: "text-center"
                    }, {
                        targets: 2,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                        data: null,
                        name: "row_num"
                    }, {
                        targets: 3,
                        render: function(data, type, row, meta) {
                            return row[3];
                        },
                        data: null,
                        name: "row_tanggal"
                    }, {
                        targets: 4,
                        render: function(data, type, row, meta) {
                            return row[4];
                        },
                        data: null,
                        name: "row_nopel",
                        orderable: false
                    }, {
                        targets: 5,
                        render: function(data, type, row, meta) {
                            return row[5];
                        },
                        data: null,
                        name: "nama_wajib_pajak"
                    }, {
                        targets: 6,
                        render: function(data, type, row, meta) {
                            return row[6];
                        },
                        data: null,
                        name: "alamat_op"
                    }, {
                        targets: 7,
                        render: function(data, type, row, meta) {
                            return row[7];
                        },
                        data: null,
                        name: "jumlah_setor",
                        orderable: false,
                        className: "text-right"
                    }, {
                        targets: 8,
                        render: function(data, type, row, meta) {
                            var is_lunas = row[12];
                            var proses = row[11];
                            var aprove_ppat = row[10];

                            if (akses == 'WP' || akses == 'PT') {
                                if (is_lunas == '0') {
                                    var entry = 'Entry';
                                } else if (is_lunas == '1') {
                                    var lunas = '<a href = "#myModal" data-toggle="modal" onclick = "detail(' + row[0] + ')"><span class="label label-success">LUNAS</span></a>';
                                } else if (is_lunas == '2') {
                                    var validasi = '<a href = "#myModal" data-toggle="modal" onclick = "detail(' + row[0] + ')"><span class="label label-success">VALIDASI</span></a>';
                                } else if (is_lunas == '4') {
                                    var batal = '<a href = "#myModal" data-toggle="modal" onclick = "detail(' + row[0] + ')"><span class="label label-danger">BATAL</span></a>';
                                } else if (is_lunas == '5') {
                                    var kadaluarsa = '<a href = "#myModal" data-toggle="modal" onclick = "detail(' + row[0] + ')"><span class="label label-danger">KADALUARSA</span></a>';
                                } else if (is_lunas == '3' && aprove_ppat == '1') {
                                    var dikembalikan_bapenda = '<a href = "#myModal" data-toggle="modal" onclick = "detail(' + row[0] + ')"><span class="label label-danger">DIKEMBALIKAN BAPENDA</span></a>';
                                } else if (is_lunas == '3' && aprove_ppat == '-1') {
                                    var dikembalikan_ppat = '<a href = "#myModal" data-toggle="modal" onclick = "detail(' + row[0] + ')"><span class="label label-danger">DIKEMBALIKAN PPAT</span></a>';
                                } else if (proses == '2' && aprove_ppat == '1') {
                                    var cetak_sspd = '<a href = "#myModal" data-toggle="modal" onclick = "detail(' + row[0] + ')"><span class="label label-info">CETAK INFO PEMBAYARAN</span></a>';
                                } else if (aprove_ppat == '0') {
                                    var proses_ppat = '<a href = "#myModal" data-toggle="modal" onclick = "detail(' + row[0] + ')"><span class="label label-danger">PROSES PPAT</span></a>';
                                } else {
                                    var proses_bapenda2 = '<a href = "#myModal" data-toggle="modal" onclick = "detail(' + row[0] + ')"><span class="label label-info">PROSES BAPENDA</span></a>';
                                }
                            } else {
                                if (is_lunas == '0') {
                                    var entry2 = 'Entry';
                                } else if (is_lunas == '1') {
                                    var lunas2 = '<a href = "#myModal" data-toggle="modal" onclick = "detail(' + row[0] + ')"><span class="label label-success">LUNAS</span></a>';
                                } else if (is_lunas == '2') {
                                    var validasi2 = '<a href = "#myModal" data-toggle="modal" onclick = "detail(' + row[0] + ')"><span class="label label-success">VALIDASI</span></a>';
                                } else if (is_lunas == '4') {
                                    var batal = '<a href = "#myModal" data-toggle="modal" onclick = "detail(' + row[0] + ')"><span class="label label-danger">BATAL</span></a>';
                                } else if (is_lunas == '5') {
                                    var kadaluarsa = '<a href = "#myModal" data-toggle="modal" onclick = "detail(' + row[0] + ')"><span class="label label-danger">KADALUARSA</span></a>';
                                } else if (is_lunas == '3' && proses == '-1' && aprove_ppat == '-1') {
                                    var dikembalikan_ppat2 = '<a href = "#myModal" data-toggle="modal" onclick = "detail(' + row[0] + ')"><span class="label label-danger">DIKEMBALIKAN PPAT</span></a>';
                                } else if (is_lunas == '3' && proses == '-1') {
                                    var dikembalikan = '<a href = "#myModal" data-toggle="modal" onclick = "detail(' + row[0] + ')"><span class="label label-danger">DIKEMBALIKAN</span></a>';
                                } else if (is_lunas == '3' && proses == '0') {
                                    var dikembalikan_kasubid = '<a href = "#myModal" data-toggle="modal" onclick = "detail(' + row[0] + ')"><span class="label label-danger">Dokumen Dikembalikan KASUBID</span></a>';
                                } else if (is_lunas == '3' && proses == '1') {
                                    var dikembalikan_kabid = '<a href = "#myModal" data-toggle="modal" onclick = "detail(' + row[0] + ')"><span class="label label-danger">Dokumen Dikembalikan KABID</span></a>';
                                } else if (aprove_ppat == '0') {
                                    var ppat = '<a href = "#myModal" data-toggle="modal" onclick = "detail(' + row[0] + ')"><span class="label label-ppat">PPAT</span></a>';
                                } else if (proses == '-1') {
                                    var staff = '<a href = "#myModal" data-toggle="modal" onclick = "detail(' + row[0] + ')"><span class="label label-staf">STAFF</span></a>';
                                } else if (proses == '2') {
                                    var cetak_sspd2 = '<a href = "#myModal" data-toggle="modal" onclick = "detail(' + row[0] + ')"><span class="label label-info">CETAK INFO PEMBAYARAN</span></a>';
                                } else if (proses == '1') {
                                    var kabid = '<a href = "#myModal" data-toggle="modal" onclick = "detail(' + row[0] + ')"><span class="label label-info">KEPALA BIDANG</span></a>';
                                } else if (proses == '0') {
                                    var kasubid = '<a href = "#myModal" data-toggle="modal" onclick = "detail(' + row[0] + ')"><span class="label label-info">KEPALA SUBBIDANG</span></a>';
                                }
                            }

                            var semua = [entry, entry2, lunas, lunas2, validasi, validasi2, dikembalikan_bapenda, proses_bapenda2, cetak_sspd, proses_ppat, dikembalikan_ppat, dikembalikan_ppat2, dikembalikan, dikembalikan_kasubid, dikembalikan_kabid, ppat, batal, kadaluarsa, staff, cetak_sspd2, kabid, kasubid];
                            var semua2 = semua.join(' ');
                            return semua2;
                        },
                        data: null,
                        name: "button_status",
                        orderable: false,
                        className: "text-center"
                    }, {
                        targets: 9,
                        render: function(data, type, row, meta) {
                            var is_lunas = row[12];
                            var proses = row[11];
                            var aprove_ppat = row[10];

                            if (akses == 'WP') {
                                var lihat_wp1 = '<a class="btn btn-primary btn-xs" href="<?php echo base_url(); ?>index.php/sptpd/printform/' + row[0] + '" target = "_blank">Lihat</a>';
                                console.log(is_lunas, aprove_ppat);
                                if ((is_lunas == '3' && aprove_ppat == '-1') ||
                                    (is_lunas == '3' && aprove_ppat == '1')) {
                                    var edit_wp1 = '<a href="<?php echo base_url(); ?>index.php/sptpd/edit_sptpd_wp/' + row[0] + '" class="btn btn-xs btn-primary">Edit</a>';
                                }
                                if (aprove_ppat == '1') {
                                    var cetak_wp = '<button type="button" class="btn btn-primary btn-xs" onclick="cetak_buktipendaftaran(' + row[0] + ')">Cetak</button> ';
                                }
                            } else if (akses == 'PT') {
                                var lihat_pt = '<a class="btn btn-primary btn-xs" href="<?php echo base_url(); ?>index.php/sptpd/printform/' + row[0] + '" target = "_blank">Lihat</a>';
                                if (aprove_ppat == '0') {
                                    var aprove = '<a class="btn btn-primary btn-xs" href="<?php echo base_url(); ?>index.php/aprove_sspd/lihat/' + row[0] + '" target = "_blank">Aprove</a>';
                                } else if (is_lunas == '3' && proses == '0' && aprove_ppat == '1') { //ditolak kasubid
                                    var edit_pt1 = '<a href="<?php echo base_url(); ?>index.php/sptpd/edit_sptpd/' + row[0] + '" class="btn btn-xs btn-primary">Edit</a>';
                                } else if (is_lunas == '3' && proses == '-1' && aprove_ppat == '1') { //ditolak staff
                                    var edit_pt2 = '<a href="<?php echo base_url(); ?>index.php/sptpd/edit_sptpd/' + row[0] + '" class="btn btn-xs btn-primary">Edit</a>';
                                } else if (is_lunas == '3' && proses == '1' && aprove_ppat == '1') { //ditolak kabid
                                    var edit_pt3 = '<a href="<?php echo base_url(); ?>index.php/sptpd/edit_sptpd/' + row[0] + '" class="btn btn-xs btn-primary">Edit</a>';
                                }
                            } else if (akses == 'D') {
                                var lihat_dispenda = '<a class="btn btn-primary btn-xs" href="<?php echo base_url(); ?>index.php/sptpd/printform/' + row[0] + '" target = "_blank">Lihat</a>';
                            }

                            var semua = [lihat_wp1, lihat_pt, edit_wp1, edit_pt1, edit_pt2, edit_pt3, lihat_dispenda, aprove];
                            var semua2 = semua.join(' ');
                            return semua2;
                        },
                        data: null,
                        name: "button_detail",
                        orderable: false
                    },
                    {
                        targets: 10,
                        visible: false,
                        searchable: false
                    },
                    {
                        targets: 11,
                        visible: false,
                        searchable: false
                    },
                    {
                        targets: 12,
                        visible: false,
                        searchable: false
                    },
                    {
                        targets: 13,
                        visible: false
                    },
                    {
                        targets: 14,
                        visible: false,
                    },
                ],
                responsive: false,
                initComplete: function() {
                    this.api().columns().every(function() {
                        var that = this;
                        $('input', this.footer()).on('keyup change', function(e) {
                            if (e.keyCode == 13) {
                                that.columns($(this).attr("column")).search(this.value).draw();
                            }
                        });
                        $('button', this.footer()).on('click', function(e) {
                            if ($(this).attr("column") == 8) {
                                input = $(this).parent().siblings("select");
                                kolom_header = (akses == 'WP' || akses == 'PT') ? 7 : 8;
                            } else {
                                kolom_header = $(this).attr("column");
                                input = $(this).parent().siblings("input");
                            }
                            that.columns(kolom_header).search($(input).val()).draw();
                        });

                        // Handle click on "Select all" control
                        $('.select-all').off();
                        $('.select-all').on('click', function() {
                            // Check/uncheck all checkboxes in the table
                            var rows = table.rows({
                                'search': 'applied'
                            }).nodes();
                            $('input[type="checkbox"]', rows).prop('checked', this.checked);
                            $('.select-all').prop('checked', this.checked);
                        });
                    });
                }
            });
        });
    </script>

    <script type="text/javascript">
        function cetak_buktipendaftaran(id_sptpd) {
            $.ajax({
                url: "<?= site_url('sptpd/cetak_buktipendaftaran') ?>",
                type: 'POST',
                data: {
                    id: id_sptpd
                },
            }).done(function(ress) {
                $('#ini_di_print').html(ress);
                $.print("#ini_di_print");
                $('#ini_di_print').html(' ');
            });
        }

        function detail(id_sptpd) {
            $.ajax({
                type: 'POST',
                url: "<?= site_url('sptpd/detail_rejek') ?>",
                data: {
                    id_sptpd: id_sptpd
                }
            }).done(function(ress) {
                $('#detail_rejek').html(ress);
            });
        }
    </script>

    <?php if ($this->session->userdata('jabatan') == '2') : ?>
        <script>
            $(".proses-validasi-massal").click(function(e) {
                $("#myModalInputNIKdanPassphrase").modal("show");
            });

            $(".btn-proses-tte").click(function(e) {
                if ($("#passphrase_tte").val() == "") {
                    Swal.fire({
                        title: 'Oops!',
                        text: 'Masukkan Passphrase Anda Untuk Melakukan Tanda Tangan Secara Digital!',
                        icon: 'warning',
                        confirmButtonText: 'Ok'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Function to call after the alert is closed
                            $("#passphrase_tte").focus();
                        }
                    });
                    return false;
                } else {
                    total_sptpd_terpilih = $(".row-select:checked").length;
                    for (var i = 0; i < $(".row-select:checked").length; i++) {
                        daftar_id_sptpd_mau_divalidasi.push($($(".row-select:checked")[i]).val());
                    }
                    proses_validasi_akhir();
                    return true;
                }
            });

            var proses_validasi_akhir_done = true;
            var index_aktif = 0;

            function proses_validasi_akhir() {
                Swal.fire({
                    title: 'Memproses Validasi dan TTE...',
                    html: `
                        <p>Sedang melakukan validasi dan tanda tangan digital</p>
                        <img src="<?= base_url('assets/images/signing.gif') ?>" alt="loading" width="100" height="100">
                        <div class="progress-bar-text">0/` + total_sptpd_terpilih + ` 0%</div>
                        <div class="progress-bar"><div class="progress"></div></div>
                    `,
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    willClose: () => {
                        // Function to call after the alert is closed
                        alertClosedCallback();
                    },
                });

                var proses_validasi_akhir_interval = setInterval(function(e) {
                    const progressBar = Swal.getHtmlContainer().querySelector('.progress');
                    const progressBarText = Swal.getHtmlContainer().querySelector('.progress-bar-text');
                    if (index_aktif < total_sptpd_terpilih) {
                        if (proses_validasi_akhir_done) {
                            proses_validasi_akhir_done = false;
                            $.ajax({
                                url: "<?= site_url('sptpd/proses_validasi_akhir/') ?>" + daftar_id_sptpd_mau_divalidasi[index_aktif] + "/bulking",
                                method: "post",
                                data: {
                                    nik_tte: $("#nik_tte").val(),
                                    passphrase_tte: $("#passphrase_tte").val(),
                                },
                                dataType: "json",
                                success: function(e) {
                                    let width = 0;
                                    if (e.status) {
                                        jmlBerhasilTTE++;
                                    } else {
                                        jmlGagalTTE++;
                                    }
                                    width = index_aktif / total_sptpd_terpilih * 100;
                                    progressBar.style.width = width + '%';
                                    progressBarText.innerHTML = index_aktif + "/" + total_sptpd_terpilih + " " + Math.ceil(width) + "%";
                                    index_aktif++;
                                    proses_validasi_akhir_done = true;
                                },
                                error: function(e) {
                                    index_aktif++;
                                    proses_validasi_akhir_done = true;
                                }
                            });
                        }
                    } else {
                        var reportJmlBehasilTTE = jmlBerhasilTTE;
                        var reportJmlGagalTTE = jmlGagalTTE;

                        progressBar.style.width = '100%';
                        progressBarText.innerHTML = total_sptpd_terpilih + "/" + total_sptpd_terpilih + " " + "100%";
                        daftar_id_sptpd_mau_divalidasi = [];
                        index_aktif = 0;
                        jmlBerhasilTTE = 0;
                        jmlGagalTTE = 0;

                        table.ajax.reload();
                        $('.select-all').prop('checked', false);

                        // Simulate a network request
                        setTimeout(() => {
                            $("#myModalInputNIKdanPassphrase").modal("hide");
                            Swal.close();

                            Swal.fire({
                                title: 'Info',
                                html: `
                                    <div>Validasi TTE Berhasil : ` + reportJmlBehasilTTE + `</div>
                                    <div>Validasi TTE Gagal : ` + reportJmlGagalTTE + `</div>
                                `,
                                icon: 'info',
                                confirmButtonText: 'Ok',
                            });
                        }, 2000); // Close the alert after 3 seconds
                        clearInterval(proses_validasi_akhir_interval)
                    }
                }, 1000);
            }

            function alertClosedCallback() {
                // Your custom logic here
                console.log('Loading alert has been closed!');
                // You can add more logic here, such as updating the UI or making an API call
            }
        </script>
    <?php endif ?>