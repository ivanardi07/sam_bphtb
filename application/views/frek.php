<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<form class="form-inline" role="form">
  <div class="form-group">
    <div class="input-group">
      <select class="form-control select2" name="propinsi" onchange="lookup($(this).val());">
        <option value="">Pilih Provinsi</option>
        <?php foreach ($propinsis as $propinsi) : ?>
          <option <?php if ($propinsi->kd_propinsi == @$kecamatan->kd_propinsi) ?> value="<?php echo $propinsi->kd_propinsi; ?>"><?php echo $propinsi->nama; ?></option>
        <?php endforeach; ?>
      </select>
    </div>
  </div>
  <div class="form-group">
    <label class="sr-only" for="exampleInputPassword2">Password</label>
    <input type="password" class="form-control" id="exampleInputPassword2" placeholder="Password">
  </div>
  <div class="checkbox">
    <label>
      <input type="checkbox"> Remember me
    </label>
  </div>
  <button type="submit" class="btn btn-default">Sign in</button>
</form>
<div class="col-md-3">

</div>
<div class="col-md-3">
  <select class="form-control select2" id="dati2_id" name="kd_dati2">
    <?php if ($kecamatan->kd_kabupaten == '') : ?>
      <option>Pilih Kabupaten</option>
    <?php else : ?>
      <?php foreach ($dati2s as $dati2) : ?>
        <option <?php if ($dati2->kd_kabupaten == @$kecamatan->kd_kabupaten) ?> value="<?php echo $dati2->kd_kabupaten; ?>"><?php echo $dati2->nama; ?></option>
      <?php endforeach; ?>
    <?php endif; ?>
  </select>
</div>
<div class="col-md-5">
  <input type="text" class="form-control pull-right tulisan" name="cari" placeholder="Nama Kabupaten" value="<?php echo @$_GET['kabupaten']; ?>">
</div>
<div class="col-md-5">
  <input type="submit" class="btn btn-info pull-right tombol" value="Cari">
</div>