<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<!-- PAGE TITLE -->
<div class="page-title">
    <h2><span class="fa fa-arrow-circle-o-left"></span>propinsi</h2>
</div>

<div class="page-content-wrap">


    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class='col-md-12'>
                    <?= $this->session->flashdata('flash_message'); ?>
                </div>
                <div class="panel-heading">

                    <div class="row">
                        <div class="col-md-6">
                            <?php if ($this->session->userdata('s_tipe_bphtb') == 'D') : ?><a class="btn btn-info" href="<?php echo $c_loc; ?>/add"><span class="fa fa-plus"></span>Tambah</a><?php endif; ?>
                            <a class="btn btn-default" href="<?php echo $c_loc; ?>"><span class="fa fa-refresh"></span>Refresh Data</a>
                        </div>


                    </div>

                </div>
                <div class='col-md-6'>

                </div>
                <div class='col-md-6'>
                    <form class="" action="" method="post">
                        <div class="form-group">
                            <div class='col-md-4'>
                            </div>
                            <div class="col-md-6">
                                <input class="form-control tulisan" id="nama" type="text" placeholder='Masukkan Nama' name="txt_nama" value="<?php echo @$search['nama'];  ?>" />
                            </div>

                            <div class="col-md-2 text-center">
                                <input class="btn btn-info tombol" type="submit" value="Cari" name="search" />&nbsp;
                            </div>
                        </div>
                    </form>
                </div>
                <form name="frm_dati" method="post" action="">
                    <div class="panel-body">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <td colspan="<?php echo ($this->session->userdata('s_tipe_bphtb') == 'D') ? 2 : 1; ?>">No</td>
                                    <td width='1'>Kode</td>
                                    <td>Nama propinsi</td>
                                    <?php if ($this->session->userdata('s_tipe_bphtb') == 'D') : ?><td width='120'>Action</td><?php endif; ?>
                                </tr>
                            </thead>
                            <?php if (!$propinsis) : echo '<tbody><tr><td colspan = "4"><center>*Data Kosong*</center><td/></tr></tbody>';
                            else : ?>
                                <?php
                                $i = 1;
                                $l = 0;
                                foreach ($propinsis as $propinsi) :
                                ?>
                                    <tbody>
                                        <tr bgcolor="<?php if ($i % 2) : echo "#E5E5E5";
                                                        else : echo "#F5F5F5";
                                                        endif; ?>">
                                            <td width='1'><?php echo $start + $i; ?></td>
                                            <?php if ($this->session->userdata('s_tipe_bphtb') == 'D') : ?><td width='1'> <input type="checkbox" name="check[]" id="id<?php echo $l; ?>" value="<?php echo $propinsi->kd_propinsi; ?>" /> </td><?php endif; ?>
                                            <td><?php echo $propinsi->kd_propinsi; ?></td>
                                            <td><?php echo $propinsi->nama; ?></td>
                                            <?php if ($this->session->userdata('s_tipe_bphtb') == 'D') : ?>
                                                <td>
                                                    <a class="btn btn-success" href="<?php echo base_url(); ?>index.php/propinsi/edit/<?php echo $propinsi->kd_propinsi; ?>"><i class="fa fa-pencil"></i></a>
                                                    <?php /* 
                                                        $check_dati = $this->mod_nik->check_dati($dati->kd_dati2);
                                                        $check_dati_nop = $this->mod_nop->check_dati($dati->kd_dati2);
                                                        if( ! $check_dati && ! $check_dati_nop): */
                                                    ?>
                                                    <?php
                                                    $lokasi = $propinsi->kd_propinsi;
                                                    if (cek_data_lokasi($lokasi, 'propinsi') == 'kosong') {
                                                    ?>
                                                        <a class="btn btn-danger" href="<?php echo base_url(); ?>index.php/propinsi/delete/<?php echo $propinsi->kd_propinsi; ?>" onclick="return confirm('Are you sure to delete &quot;<?php echo addslashes($propinsi->nama); ?>&quot;?')"><i class="fa fa-trash-o"></i></a>
                                                    <?php
                                                    } ?>
                                                    <?php //endif; 
                                                    ?>
                                                </td>
                                            <?php endif; ?>
                                        </tr>
                                    </tbody>
                                <?php $i++;
                                    $l++;
                                endforeach; ?>
                        </table>
                    </div>

                    <div class="panel-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <?php if ($this->session->userdata('s_tipe_bphtb') == 'D') : ?>
                                    <a class="btn btn-default" href="#" onclick="for (k = 0; k < <?php echo $l; ?>; k++) document.getElementById('id'+k).checked = true;"><span class="fa fa-check"></span>Check All</a> -
                                    <a class="btn btn-default" href="#" onclick="for (k = 0; k < <?php echo $l; ?>; k++) document.getElementById('id'+k).checked = false;"><span class="fa fa fa-check-square-o"></span>Uncheck All</a>
                                    - with selected :
                                    <button class="multi_submit btn btn-danger" type="submit" name="submit_multi" value="delete" title="Delete" onclick="return confirm('Are you sure to delete these records status?')"><span class="fa fa-trash-o"></span>
                                    </button>
                                <?php endif; ?>


                            </div>
                            <div class="col-md-offset-2 col-md-4">
                                <!-- PAGINATION BELUM -->
                                <div class="dataTables_paginate paging_bootstrap pagination"><?php echo $page_link; ?></div>

                            </div>
                        </div>
                    </div>
                </form>
            </div </div>

        </div>
    </div>

</div>
<?php endif; ?>
<style type="text/css">
    .tulisan {
        margin: 3px;
        margin-top: 20px;
    }

    .tombol {
        margin: 3px;
        margin-top: 20px;
    }
</style>