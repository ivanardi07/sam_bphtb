<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Form Input
      <small></small>
    </h1>
  </section>
  <section class="content">
    <div class="row">
      <!-- left column -->
      <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Form Input</h3>
          </div>
          <!-- /.box-header -->
          <!-- form start -->
          <div class="row">
            <div class="col-md-12">
              <form role="form" method="POST" action="<?php echo base_url(); ?>index.php/harga_refrensi/action">
                <div class="box-body">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Alamat</label>
                    <input required="" name="alamat" type="text" class="form-control" id="exampleInputPassword1" placeholder="Masukkan Alamat">
                  </div>
                  <div class="form-group">
                    <label for="name" class="cols-sm-2 control-label">kecamatan</label>
                    <div class="cols-sm-10">
                      <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user fa" aria-hidden="true"></i></span>
                        <select id="kecamatan_nik_id_text" name="kecamatan" class="form-control select2-c" onchange="lookup_kelurahan_text();" style="">
                          <option value=""></option>
                          <?php foreach ($kecamatan as $kecamatan) : ?>
                            <option value="<?php echo $kecamatan->kd_kecamatan; ?>"><?php echo $kecamatan->kd_kecamatan . ' - ' . $kecamatan->nama; ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="name" class="cols-sm-2 control-label">Kelurahan</label>
                    <div class="cols-sm-10">
                      <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user fa" aria-hidden="true"></i></span>
                        <select id="kelurahan_nik_id_text" name="kelurahan" class="form-control select2-c" style="">
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Harga</label>
                    <input required="" name="harga" type="number" class="form-control" id="exampleInputPassword1" placeholder="Masukkan Harga">
                  </div>
                </div>
                <br>
                <!-- /.box-body -->

                <div class="box-footer">
                  <button type="submit" class="btn btn-primary">Kirim</button>
                </div>
              </form>
            </div>
            <div class="col-md-12">
              <div style="margin: 10px">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Alamat</th>
                      <th>Kode Kecamatan</th>
                      <th>Kode Kelurahan</th>
                      <th>Harga</th>
                      <th>action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $no = 1;
                    foreach ($hr as $key => $dt) {
                    ?>
                      <tr>
                        <td><?= $no ?></td>
                        <td><?php echo $dt->alamat ?></td>
                        <td><?php echo $dt->kd_kec ?></td>
                        <td><?php echo $dt->kd_kel ?></td>
                        <td><?php echo $dt->harga ?></td>
                        <td><a class="btn btn-primary" href="<?php echo base_url(); ?>index.php/harga_refrensi/edit/<?= $dt->id_hr ?>">Edit</a>
                          <a class="btn btn-primary" href="<?php echo base_url(); ?>index.php/harga_refrensi/action_delete/<?= $dt->id_hr ?>">Hapus</a>
                        </td>
                      </tr>
                    <?php
                      $no++;
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <!-- /.box -->


      </div>
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>


<?php if ($this->session->flashdata('info')) { ?>
  <div class="portfolio-modal modal fade" id="popup" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-login">
      <div class="container " style="text-align: center; background: white; margin-top: 200px;">
        <div class="row">
          <div class="">
            <div class="modal-body">
              <div class="close-modal clo1" data-dismiss="modal" style="float: right;
            margin-right: 30px;">
                <div class="lr r">
                  <div class="rl r"></div>
                </div>
              </div>
              <div>
                <h3>Info</h3>
                <h5><?php echo $this->session->flashdata('info'); ?></h5>

              </div>
              <div style="text-align: center;">
                <button type="button" class="btn btn-default" data-dismiss="modal" style="background:#d9241b; color: white; ">Tutup</button>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

<?php } ?>


<script type="text/javascript">
  $(document).ready(function() {
    // select2();
  });


  function lookup_kecamatan_text() {
    var id_kec = $('#propinsi_nik_id_text').val();
    $.ajax({
      url: "<?php echo base_url(); ?>index.php/register/get_kec",
      type: "POST",
      data: {
        id_p: id_p,
        id_kab: id_kab
      },
      cache: false,
      success: function(data) {
        // $str =''
        data = JSON.parse(data);
        var str_kec = '<option class="kc" value="">Pilih Kecamatan</option>';
        console.log(data);
        $.each(data, function(i, val) {

          str_kec += '<option class="kc" value="' + val.kd_kecamatan + '">' + val.nama + '</option>';
        });

        // $('#kecamatan_nik_id_text').remove();
        $('.kc').remove();
        $('.kl').remove();
        $('#kecamatan_nik_id_text').append(str_kec);

      }
    });
  }


  // Jika Session Kecamatan ada




  /* Memilih kelurahan */

  function lookup_kelurahan_text() {
    var kd_propinsi = '35';
    var kd_kabupaten = '73';
    var string = $('#kecamatan_nik_id_text').val();
    if (string == '') {
      $('#kelurahan_nik_id_text').html('');
    } else {
      $.ajax({
        url: "<?php echo base_url(); ?>index.php/harga_refrensi/get_kel",
        type: "POST",
        data: {
          id_p: kd_propinsi,
          id_kab: kd_kabupaten,
          id_kec: string,
        },
        cache: false,
        success: function(data) {
          // console.log()
          // $str =''
          data = JSON.parse(data);
          var str_kel = '<option class="kl" value="">Pilih Kelurahan</option>';
          console.log(data);
          $.each(data, function(i, val) {

            str_kel += '<option class="kl" value="' + val.kd_kelurahan + '">' + val.kd_kelurahan + ' - ' + val.nama + '</option>';
          });

          // $('#kecamatan_nik_id_text').remove();
          $('.kl').remove();
          $('#kelurahan_nik_id_text').append(str_kel);
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
</script>