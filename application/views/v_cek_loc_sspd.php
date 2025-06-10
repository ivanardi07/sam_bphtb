<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<!-- PAGE TITLE -->
<!-- <?php //echo @$map['js']; 
        ?> -->
<link rel="stylesheet" href="<?php echo base_url() . 'assets/plugin/leaflet/leaflet.css'; ?>" />
<script src="<?php echo base_url() . 'assets/plugin/leaflet/leaflet.js'; ?>"></script>
<!-- <link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet/v1.0.0-rc.1/leaflet.css" />
<script src="http://cdn.leafletjs.com/leaflet/v1.0.0-rc.1/leaflet.js"></script> -->

<div class="page-title">
    <h2><span class="fa fa-arrow-circle-o-left"> </span><?php if (isset($title)) {
                                                            echo $title;
                                                        }
                                                        ?></h2>

</div>

<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">

                    <div class="row">
                        <div class="col-md-6">
                        </div>

                    </div>

                </div>
                <div class="panel-body">
                    <!-- <?php //echo $map['html']; 
                            ?> -->
                    <div class="col-md-12">
                        <form action="#" method="POST">
                            <div class="col-md-2 pull-right">
                                <input type="submit" class="btn btn-info tombol" value="Lacak">
                            </div>

                            <div class="col-md-2 pull-right">
                                <input type="text" class="form-control pull-right tulisan" name="no_sspd" id="no_sspd" placeholder="No SSPD" value="<?php echo @$_GET['no_sspd']; ?>">
                            </div>
                        </form>
                    </div>
                    <div class="col-md-12" id="map" style="height:500px;">

                    </div>
                </div>

                <div class="panel-footer">
                    <div class="row">
                        <div class="col-md-6">
                        </div>
                        <div class="col-md-offset-2 col-md-4">
                            <!-- PAGINATION BELUM -->


                        </div>
                    </div>
                </div>

                <?php echo $this->session->flashdata('flash_msg'); ?>
            </div </div>

        </div>
    </div>

</div>

<script type="text/javascript">
    jQuery(document).ready(function() {
        var map = L.map('map', {
            center: [-7.9666204, 112.6326321],
            zoom: 13
        });
        L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
            attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://mapbox.com">Mapbox</a>',
            maxZoom: 18,
            id: 'nickymouse.0bfh82db',
            accessToken: 'pk.eyJ1Ijoibmlja3ltb3VzZSIsImEiOiJjaXA2bHRrdGEwMGExdGNseXVnY2JvY3pkIn0.72LT97nJyKD0it1yKiDqhw'
        }).addTo(map);

        var marker = L.marker([-7.9666204, 112.6326321]).addTo(map);
    });
</script>