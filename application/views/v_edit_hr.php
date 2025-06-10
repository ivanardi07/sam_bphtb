<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Form Edit
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
            <h3 class="box-title">Form Edit</h3>
          </div>
          <!-- /.box-header -->
          <!-- form start -->
          <div class="row">
            <div class="col-md-12">
              <form role="form" method="POST" action="<?php echo base_url(); ?>index.php/harga_refrensi/action_edit/<?= $get->id_hr ?>">
                <div class="box-body">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Alamat</label>
                    <input required="" name="alamat" value="<?= $get->alamat ?>" type="text" class="form-control" id="exampleInputPassword1" placeholder="Masukkan Alamat">
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
                    <input required="" name="harga" type="number" value="<?= $get->harga ?>" class="form-control" id="exampleInputPassword1" placeholder="Masukkan Harga">
                  </div>
                </div>
                <br>
                <!-- /.box-body -->

                <div class="box-footer">
                  <button type="submit" class="btn btn-primary">Kirim</button>
                </div>
              </form>
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