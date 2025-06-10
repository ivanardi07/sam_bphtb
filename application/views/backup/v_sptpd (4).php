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
    <h2><span class="fa fa-arrow-circle-o-left"></span> SSPD - BPHTB</h2>
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

                            <?php
                            $add_url_dispenda = $c_loc . '/add_by_dispenda';
                            $add_url_wp       = $c_loc . '/add_by_wp';
                            $add_url          = $c_loc . '/add';
                            ?>

                            <?php if ($akses == 'D' && $userdata['jabatan'] == '0') { ?>
                                <a class="btn btn-info" href="<?php echo $add_url_dispenda; ?>"><span class="fa fa-plus"></span>Tambah</a>
                            <?php } elseif ($akses == 'WP') { ?>
                                <a class="btn btn-info" href="<?php echo $add_url_wp; ?>"><span class="fa fa-plus"></span>Tambah</a>
                            <?php } ?>
                            <a class="btn btn-success" href="<?php echo $c_loc . '/' . 'refresh'; ?>"><span class="fa fa-refresh"></span>Refresh Data</a>
                        </div>
                        <?php if ($akses == 'D') { ?>
                            <div class="col-md-6">
                                <button class="btn btn-warning pull-right" value="proses" id="proses"><span class="fa fa-file"></span><?php echo $count; ?> Berkas Harus Diproses</button>
                            </div>
                        <?php } ?>

                    </div>
                </div>

                <table id="tabelsptpd" class="table table-striped table-bordered" style="width:100%;">

                    <thead>
                        <tr class="tblhead">
                            <th class="text-center" style="width: 10px; display: none">ID_SPTPD</th>
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



    <script src="<?= base_url() . 'assets/scripts/jquery.print/jquery.print.js' ?>"></script>

    <!-- tambah script di assets/scripts/search_sptpd -->

    <!-- <script src="<?= base_url() . 'assets/scripts/search_sptpd/jquery-3.5.1.js' ?>"></script> -->
    <script src="<?= base_url() . 'assets/scripts/search_sptpd/jquery.dataTables.min.js' ?>"></script>
    <script src="<?= base_url() . 'assets/scripts/search_sptpd/dataTables.bootstrap4.min.js' ?>"></script>
    <script src="https://cdn.datatables.net/rowreorder/1.2.7/js/dataTables.rowReorder.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.5/js/dataTables.responsive.min.js"></script>

    <script type="text/javascript">
        var akses = "<?php print($akses); ?>";
        var jabatan = "<?php print($userdata['jabatan']); ?>";

        $(document).ready(function() {
            var columnCount = 0;
            var columnDisabledInput = [1, 8];
            var format = {
                "2": {
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

                    if (columnCount == 7) {
                        if (akses == 'WP' || akses == 'PT') {
                            columnNum = 14;
                            daftar_status = ['LUNAS',
                                'VALIDASI',
                                'BATAL',
                                'KADALUARSA',
                                'DIKEMBALIKAN BAPENDA',
                                'DIKEMBALIKAN PPAT',
                                'CETAK SSPD',
                                'PROSES PPAT',
                                'PROSES BAPENDA'
                            ]
                        } else {
                            daftar_status = ['LUNAS',
                                'VALIDASI',
                                'BATAL',
                                'KADALUARSA',
                                'DIKEMBALIKAN PPAT',
                                'DIKEMBALIKAN',
                                'DOKUMEN DIKEMBALIKAN KASUBID',
                                'DOKUMEN DIKEMBALIKAN KABID',
                                'PPAT',
                                'STAFF',
                                'CETAK SSPD',
                                'KEPALA BIDANG',
                                'KEPALA SUBBIDANG'
                            ]
                            columnNum = 15;
                        }
                    }

                    if (columnCount == 7) {
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

            var table = $('#tabelsptpd').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "<?= base_url('index.php/serverside') ?>",
                    "data": function(outData, d) {
                        return outData;
                    },
                    dataFilter: function(inData, d) {
                        return inData;
                    },
                    error: function(err, status) {
                        console.log(err);
                    },
                    type: 'POST',
                    data: {
                        akses: akses,
                        id_ppat: id_ppat,
                        userdata: userdata,
                        id_wp: id_wp
                    },
                    "dataSrc": "data"
                },
                order: [
                    [1, 'desc']
                ],
                columnDefs: [{
                        targets: 0,
                        visible: false,
                        searchable: false,
                    }, {
                        targets: 1,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                        data: null,
                        name: "row_num"
                    }, {
                        targets: 2,
                        render: function(data, type, row, meta) {
                            return row[2];
                        },
                        data: null,
                        name: "row_tanggal"
                    }, {
                        targets: 3,
                        render: function(data, type, row, meta) {
                            return row[3];
                        },
                        data: null,
                        name: "row_nopel"
                    }, {
                        targets: 4,
                        render: function(data, type, row, meta) {
                            return row[4];
                        },
                        data: null,
                        name: "nama_wajib_pajak"
                    }, {
                        targets: 5,
                        render: function(data, type, row, meta) {
                            return row[5];
                        },
                        data: null,
                        name: "alamat_op"
                    }, {
                        targets: 6,
                        render: function(data, type, row, meta) {
                            return row[6];
                        },
                        data: null,
                        name: "jumlah setor"
                    }, {
                        targets: 7,
                        render: function(data, type, row, meta) {
                            var is_lunas = row[11];
                            var proses = row[10];
                            var aprove_ppat = row[9];

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
                                    var cetak_sspd = '<a href = "#myModal" data-toggle="modal" onclick = "detail(' + row[0] + ')"><span class="label label-info">CETAK SSPD</span></a>';
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
                                    var cetak_sspd2 = ' <span class="label label-info">CETAK SSPD</span>';
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
                        name: "button_status"
                    }, {
                        targets: 8,
                        render: function(data, type, row, meta) {
                            var is_lunas = row[11];
                            var proses = row[10];
                            var aprove_ppat = row[9];

                            if (akses == 'WP') {
                                var lihat_wp1 = '<a class="btn btn-primary btn-xs" href="<?php echo base_url(); ?>index.php/sptpd/printform/' + row[0] + '" target = "_blank">Lihat</a>';

                                if (is_lunas == '3' && aprove_ppat == '-1') {
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
                        name: "button_detail"
                    },
                    {
                        targets: 9,
                        visible: false,
                        searchable: false
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
                        visible: false
                    },
                    {
                        targets: 13,
                        visible: false,
                    },
                ],
                responsive: true,
                initComplete: function() {
                    this.api().columns().every(function() {
                        var that = this;
                        $('input', this.footer()).on('keyup change', function(e) {
                            if (e.keyCode == 13) {
                                that.columns($(this).attr("column")).search(this.value).draw();
                            }
                        });
                        $('button', this.footer()).on('click', function(e) {
                            if ($(this).attr("column") == 7) {
                                input = $(this).parent().siblings("select");
                                kolom_header = (akses == 'WP' || akses == 'PT') ? 7 : 8;
                            } else {
                                kolom_header = $(this).attr("column");
                                input = $(this).parent().siblings("input");
                            }
                            that.columns(kolom_header).search($(input).val()).draw();
                        });
                        if (akses == 'D' && jabatan == '0') {
                            $('#proses').on('click', function() {
                                table.columns(7).search("STAFF").draw();
                            });
                        }
                        if (akses == 'D' && jabatan == '1') {
                            $('#proses').on('click', function() {
                                table.columns(7).search("KEPALA SUBBIDANG").draw();
                            });
                        }
                        if (akses == 'D' && jabatan == '2') {
                            $('#proses').on('click', function() {
                                table.columns(7).search("KEPALA BIDANG").draw();
                            });
                        }
                    });
                }
            });

            // $('#tabelsptpd tbody').on('click', '.no_pelayanan', function () {
            //   var id = $(this).attr("id").match(/\d+/)[0];
            //   var data = $('#tabelsptpd').DataTable().row( id ).data();
            //   // console.log(data);
            // });

        });
    </script>

    <script type="text/javascript">
        //     $(document).ready(function() {
        //   $('#tabelsptpd tr').each(function() {
        //     console.log(this.id)
        //   })
        // });

        // tombol.foreach(actionLihat1);

        // function actionLihat1() {
        // var tombol = '<button id="manageBtn" type="button" onclick = "myFunc()" class="btn btn-success btn-xs">Lihat</button>'; 
        //     return tombol;
        // }
        // function myFunc() {
        //     console.log("asd");
        // }

        function cetak_buktipendaftaran(id_sptpd) {
            $.ajax({
                    url: "<?= site_url('sptpd/cetak_buktipendaftaran') ?>",
                    type: 'POST',
                    data: {
                        id: id_sptpd
                    },
                })
                .done(function(ress) {
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
                })
                .done(function(ress) {
                    $('#detail_rejek').html(ress);
                });
        }
    </script>