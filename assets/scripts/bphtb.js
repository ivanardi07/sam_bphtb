
function count_calc(a, b, operator, output) {
    var luas_njop_tanah;
    if(operator == '+'){ luas_njop_tanah = parseInt(a) + parseInt(b); }
    else if(operator == '-'){ luas_njop_tanah = parseInt(a) - parseInt(b); }
    else if(operator == '*'){ luas_njop_tanah = parseInt(a) * parseInt(b); }
    else if(operator == '/'){ luas_njop_tanah = parseInt(a) / parseInt(b); }
    $('#'+output).html(number_format(luas_njop_tanah, 0, ',', '.'));
    $('#h_'+output).val(luas_njop_tanah);
    $('#njop_pbb_id').val(parseInt($('#h_l_njop_tanah').val()) + parseInt($('#h_l_njop_bangunan').val()));
    $('#njop_pbb_lbl_id').html(number_format(parseInt($('#h_l_njop_tanah').val()) + parseInt($('#h_l_njop_bangunan').val()), 0, ',', '.'));
}

function count_njop_pbb(a, b, operator, output) {
    var luas_njop_tanah;
    if(operator == '+'){ luas_njop_tanah = parseInt(a) + parseInt(b); }
    else if(operator == '-'){ luas_njop_tanah = parseInt(a) - parseInt(b); }
    else if(operator == '*'){ luas_njop_tanah = parseInt(a) * parseInt(b); }
    else if(operator == '/'){ luas_njop_tanah = parseInt(a) / parseInt(b); }
    $('#njop_pbb_id').val(luas_njop_tanah);
    $('#njop_pbb_lbl_id').html(number_format(luas_njop_tanah, 0, ',', '.'));
}

function count_njop_sptpd(a, b, c, nik, skbkb)
{

    if(nik != '') {
        if(skbkb == ''){ skbkb = ''; }
        $.post(JS_HOME+"index.php/sptpd/get_prev_bynik", {
            rx_id_nik: "" + nik + "" , rx_skbkb: "" + skbkb + ""
        }, function(data){
            if(data == '1') {
                $('#npoptkp_id').val('0');
                $('#npoptkp_lbl_id').html('0');
                var count_npopkp = parseInt(a);
                var npopkp = count_npopkp;
                var bea_perolehan = npopkp*0.05;
                var pengenaan50 = 0;
                if(npopkp < 0){ npopkp = 0; }
                if(bea_perolehan < 0){ bea_perolehan = 0; }
                $('#npopkp_id').html(number_format(npopkp, 0, ',', '.'));
                $('#bea_perolehan_id').html(number_format(bea_perolehan, 0, ',', '.'));
                $('#bea_perolehan_h_id').val(bea_perolehan, 0, ',', '.');
                $('#bea_bayar_id').html(number_format(bea_perolehan, 0, ',', '.'));
                $('#bea_bayar_h_id').val(bea_perolehan, 0, ',', '.');
                $('#jml_setor_id').val(bea_perolehan, 0, ',', '.');
                if(c == '04' || c == '05') {
                    pengenaan50 = bea_perolehan*0.5;
                    if(pengenaan50 < 0){ pengenaan50 = 0; }
                    $('#bea_bayar_id').html(number_format(pengenaan50, 0, ',', '.'));
                    $('#bea_bayar_h_id').val(pengenaan50, 0, ',', '.');
                }
                $('#pengenaan50_id').html(number_format(pengenaan50, 0, ',', '.'));
                $('#pengenaan50_h_id').val(pengenaan50, 0, ',', '.');
            } else {
                var count_npopkp = parseInt(a)-parseInt(b);
                var npopkp = count_npopkp;
                var bea_perolehan = npopkp*0.05;
                var pengenaan50 = 0;
                if(npopkp < 0){ npopkp = 0; }
                if(bea_perolehan < 0){ bea_perolehan = 0; }
                $('#npopkp_id').html(number_format(npopkp, 0, ',', '.'));
                $('#bea_perolehan_id').html(number_format(bea_perolehan, 0, ',', '.'));
                $('#bea_perolehan_h_id').val(bea_perolehan, 0, ',', '.');
                $('#bea_bayar_id').html(number_format(bea_perolehan, 0, ',', '.'));
                $('#bea_bayar_h_id').val(bea_perolehan, 0, ',', '.');
                $('#jml_setor_id').val(bea_perolehan, 0, ',', '.');
                if(c == '04' || c == '05') {
                    pengenaan50 = bea_perolehan*0.5;
                    if(pengenaan50 < 0){ pengenaan50 = 0; }
                    $('#bea_bayar_id').html(number_format(pengenaan50, 0, ',', '.'));
                    $('#bea_bayar_h_id').val(pengenaan50, 0, ',', '.');
                }
                $('#pengenaan50_id').html(number_format(pengenaan50, 0, ',', '.'));
                $('#pengenaan50_h_id').val(pengenaan50, 0, ',', '.');
            }
        });
    } else {
        var count_npopkp = parseInt(a)-parseInt(b);
        var npopkp = count_npopkp;
        var bea_perolehan = npopkp*0.05;
        var pengenaan50 = 0;
        if(npopkp < 0){ npopkp = 0; }
        if(bea_perolehan < 0){ bea_perolehan = 0; }
        $('#npopkp_id').html(number_format(npopkp, 0, ',', '.'));
        $('#bea_perolehan_id').html(number_format(bea_perolehan, 0, ',', '.'));
        $('#bea_perolehan_h_id').val(bea_perolehan, 0, ',', '.');
        $('#bea_bayar_id').html(number_format(bea_perolehan, 0, ',', '.'));
        $('#bea_bayar_h_id').val(bea_perolehan, 0, ',', '.');
        $('#jml_setor_id').val(bea_perolehan, 0, ',', '.');
        if(c == '04' || c == '05') {
            pengenaan50 = bea_perolehan*0.5;
            if(pengenaan50 < 0){ pengenaan50 = 0; }
            $('#bea_bayar_id').html(number_format(pengenaan50, 0, ',', '.'));
            $('#bea_bayar_h_id').val(pengenaan50, 0, ',', '.');
        }
        $('#pengenaan50_id').html(number_format(pengenaan50, 0, ',', '.'));
        $('#pengenaan50_h_id').val(pengenaan50, 0, ',', '.');
    }
}

function count_tanah_add_sptpd_1() {
    var nti = $('#njop_tanah_id').val();
    nti = nti.replace('.','');

    var ltni = $('#luas_tanah_id').val() * nti; 
    $('#l_njop_tanah_nop_h_id').val(ltni);

    $('#l_njop_tanah_nop_id').html(number_format(ltni, 0, ',', '.'));
    $('#luas_tanah_nop_id').html($('#luas_tanah_id').val());
    
    console.log($('#luas_tanah_id').val() + '+' + $('#njop_tanah_id').val() + '=' + ltni);
    // $('#idnopsave_luas_tanah').val($('#luas_tanah_id').val());
     
    var npni = parseInt($('#l_njop_tanah_nop_h_id').val())+parseInt($('#l_njop_bangunan_nop_h_id').val()); 
    $('#njop_pbb_nop_id').html(number_format(npni, 0, ',', '.')); $('#njop_pbb_nop_h_id').val(npni);
    count_nilai_pasar_max_sptpd();
}


function count_bangunan_add_sptpd_1() {

    var nbi = $('#njop_bangunan_id').val();
    nbi = nbi.replace('.','');

    var lbni = $('#luas_bangunan_id').val() * nbi; 
    $('#l_njop_bangunan_nop_h_id').val(lbni); 
    $('#l_njop_bangunan_nop_id').html(number_format(lbni, 0, ',', '.')); 
    var lbi = $('#luas_bangunan_id').val();

    $('#luas_bangunan_nop_id').html(lbi);
    console.log($('#luas_bangunan_id').val() + ' x ' + $('#njop_bangunan_id').val() + '=' + lbni);
    // $('#idnopsave_luas_bangunan').val($('#luas_bangunan_id').val());
    
    var npni = parseInt($('#l_njop_tanah_nop_h_id').val())+parseInt($('#l_njop_bangunan_nop_h_id').val()); 
    $('#njop_pbb_nop_id').html(number_format(npni, 0, ',', '.')); $('#njop_pbb_nop_h_id').val(npni);
    count_nilai_pasar_max_sptpd();
}

function count_nilai_pasar_max_sptpd() {
    var nilai_pasar_id      = $('#nilai_pasar_id').val();
    var nilai_pasar_arr     = nilai_pasar_id.split('.');
    var pasar               = nilai_pasar_arr.join('');

    var jenis               = $('#jns_perolehan_op_id').val();

    if(jenis == '08') {
        $('#npop_id').val($('#nilai_pasar_id').val());
    } else {
        if(parseInt($('#njop_pbb_nop_h_id').val()) < pasar) {
            $('#npop_id').val($('#nilai_pasar_id').val()); 
        }
        else { 
            $('#npop_id').val(number_format($('#njop_pbb_nop_h_id').val()));
        }
    }

    var id_jenis = $('#jns_perolehan_op_id').val();
    
    if (id_jenis != '') {
        count_all(id_jenis);
    }
    
     count_njop_sptpd($('#npop_id').val(), $('#npoptkp_id').val(), $('#jns_perolehan_op_id').val(), $('#id_nik_id').val());
}

function check_add_sptpd() {
    /*GENIO*/
    var jml_setor = $('#jml_setor_id').val();
    // var b = $('#bea_bayar_h_id').val();
    var bea_perolehan_terhutang = $('#bea_perolehan_h_id').val();

    if($('input[value=SKBKBT][type=radio]').is(':checked') || $('input[value=SKBKB][type=radio]').is(':checked')){
        return true;
    }
    else if(jml_setor < bea_perolehan_terhutang) {
        alert('Jumlah setor kurang dari Bea Perolehan yang harus dibayar.');
        return false;
    }
    var r = confirm("Apakah data yang dientri sudah benar?");
    if (r == true) {
        return true;
    } else {
        return false;
    }
    // return true;
}

function check_add_sptpd_new() {
    if($('input[value=SKBKBT][type=radio]').is(':checked') || $('input[value=SKBKB][type=radio]').is(':checked')){
        return true;
    }
    else if($('#jml_setor_id').val() < $('#kurang_bayar_h_id').val()) {
        alert('Jumlah setor kurang dari Bea Perolehan yang harus dibayar.');
        return false;
    } 
    var r = confirm("Apakah data yang dientri sudah benar?");
    if (r == true) {
        return true;
    } else {
        return false;
    }
    // return true; 
}

function number_format(a, b, c, d) {
    a = Math.round(a * Math.pow(10, b)) / Math.pow(10, b);
    e = a + '';
    f = e.split('.');
    
    if (!f[0]) {
        f[0] = '0';
    }
    
    if (!f[1]) {
        f[1] = '';
    }
    
    if (f[1].length < b) {
        g = f[1];
        for (i=f[1].length + 1; i <= b; i++) {
            g += '0';
        }
        f[1] = g;
    }
 
    if(d != '' && f[0].length > 3) {
        h = f[0];
        f[0] = '';
        for(j = 3; j < h.length; j+=3) {
            i = h.slice(h.length - j, h.length - j + 3);
            f[0] = d + i +  f[0] + '';
        }
        j = h.substr(0, (h.length % 3 == 0) ? 3 : (h.length % 3));
        f[0] = j + f[0];
    }
    c = (b <= 0) ? '' : c;
    
    return f[0] + c + f[1];
}

function count_tanah_add_sptpd_2() {
    var aphb1       = $('#tanah_inp_aphb1').val();
    var aphb2       = $('#tanah_inp_aphb2').val();
    var nti_id      = $('#njop_tanah_id').val();
    var luas_tanah  = $('#luas_tanah_id').val();
    
    var nti_arr         = nti_id.split('.');
    var nti             = nti_arr.join('');
    // nti = nti_id.replace('.','');

    //luas_tanah = luas_tanah.replace('.','');

    var aphb3 = (aphb1 / aphb2) * luas_tanah;
    $('#tanah_inp_aphb3').val(aphb3);

    var ltni = ((aphb1 / aphb2) * luas_tanah) * nti; 
    $('#l_njop_tanah_nop_h_id').val(ltni);

    $('#l_njop_tanah_nop_id').html(number_format(ltni, 0, ',', '.'));
    $('#luas_tanah_nop_id').html($('#luas_tanah_id').val());
    
    // console.log($('#tanah_inp_aphb3').val() + ' x ' + $('#njop_tanah_id').val() + '=' + ltni);
    // $('#idnopsave_luas_tanah').val($('#luas_tanah_id').val());
     
    var npni = parseInt($('#l_njop_tanah_nop_h_id').val())+parseInt($('#l_njop_bangunan_nop_h_id').val())+parseInt($('#l_njop_tanah_b_nop_h_id').val())+parseInt($('#l_njop_bangunan_b_nop_h_id').val()); 
    $('#njop_pbb_nop_id').html(number_format(npni, 0, ',', '.'));
    $('#njop_pbb_nop_h_id').val(npni);
    count_nilai_pasar_max_sptpd();
}

function count_bangunan_add_sptpd_2() {
    var aphb1           = $('#bangunan_inp_aphb1').val();
    var aphb2           = $('#bangunan_inp_aphb2').val();
    var nbi_id          = $('#njop_bangunan_id').val();
    var luas_bangunan   = $('#luas_bangunan_id').val();
    
    // nbi = nbi.replace('.','');
    var nbi_arr         = nbi_id.split('.');
    var nbi             = nbi_arr.join('');
    //luas_bangunan = luas_bangunan.replace('.','');

    var aphb3 = (aphb1 / aphb2) * luas_bangunan;
    $('#bangunan_inp_aphb3').val(aphb3);

    var lbni = ((aphb1 / aphb2) * luas_bangunan) * nbi;
    $('#l_njop_bangunan_nop_h_id').val(lbni); 

    $('#l_njop_bangunan_nop_id').html(number_format(lbni, 0, ',', '.')); 
    var lbi = $('#luas_bangunan_id').val();

    $('#luas_bangunan_nop_id').html(lbi);
    // console.log($('#bangunan_inp_aphb3').val() + ' x ' + $('#njop_bangunan_id').val() + '=' + lbni);
    // $('#idnopsave_luas_bangunan').val($('#luas_bangunan_id').val());
    
    var npni = parseInt($('#l_njop_tanah_nop_h_id').val())+parseInt($('#l_njop_bangunan_nop_h_id').val())+parseInt($('#l_njop_tanah_b_nop_h_id').val())+parseInt($('#l_njop_bangunan_b_nop_h_id').val()); 
    $('#njop_pbb_nop_id').html(number_format(npni, 0, ',', '.')); $('#njop_pbb_nop_h_id').val(npni);
    count_nilai_pasar_max_sptpd();
}

function count_tanah_b_add_sptpd_2() {
    var aphb1           = $('#tanah_b_inp_aphb1').val();
    var aphb2           = $('#tanah_b_inp_aphb2').val();
    var nbi_id          = $('#njop_tanah_b_id').val();
    var luas_tbb   = $('#luas_tanah_b_id').val();
    
    // nbi = nbi.replace('.','');
    var nbi_arr         = nbi_id.split('.');
    var nbi             = nbi_arr.join('');
    luas_tbb = luas_tbb.replace('.','');

    var aphb3 = (aphb1 / aphb2) * luas_tbb;
    $('#tanah_b_inp_aphb3').val(aphb3);

    var lbni = ((aphb1 / aphb2) * luas_tbb) * nbi;
    $('#l_njop_tanah_b_nop_h_id').val(lbni); 

    $('#l_njop_tanah_b_nop_id').html(number_format(lbni, 0, ',', '.')); 
    var lbi = $('#luas_tanah_b_id').val();

    $('#luas_tanah_b_nop_id').html(lbi);
    // console.log($('#tanah_b_inp_aphb3').val() + ' x ' + $('#njop_tanah_b_id').val() + '=' + lbni);
    // $('#idnopsave_luas_tbb').val($('#luas_tanah_b_id').val());
    
    var npni = parseInt($('#l_njop_tanah_nop_h_id').val())+parseInt($('#l_njop_bangunan_nop_h_id').val())+parseInt($('#l_njop_tanah_b_nop_h_id').val())+parseInt($('#l_njop_bangunan_b_nop_h_id').val()); 
    $('#njop_pbb_nop_id').html(number_format(npni, 0, ',', '.')); $('#njop_pbb_nop_h_id').val(npni);
    count_nilai_pasar_max_sptpd();
}

function count_bangunan_b_add_sptpd_2() {
    var aphb1           = $('#bangunan_b_inp_aphb1').val();
    var aphb2           = $('#bangunan_b_inp_aphb2').val();
    var nbi_id          = $('#njop_bangunan_b_id').val();
    var luas_tbb   = $('#luas_bangunan_b_id').val();
    
    // nbi = nbi.replace('.','');
    var nbi_arr         = nbi_id.split('.');
    var nbi             = nbi_arr.join('');
    luas_tbb = luas_tbb.replace('.','');

    var aphb3 = (aphb1 / aphb2) * luas_tbb;
    $('#bangunan_b_inp_aphb3').val(aphb3);

    var lbni = ((aphb1 / aphb2) * luas_tbb) * nbi;
    $('#l_njop_bangunan_b_nop_h_id').val(lbni); 

    $('#l_njop_bangunan_b_nop_id').html(number_format(lbni, 0, ',', '.')); 
    var lbi = $('#luas_bangunan_b_id').val();

    $('#luas_bangunan_b_nop_id').html(lbi);
    // console.log($('#bangunan_b_inp_aphb3').val() + ' x ' + $('#njop_bangunan_b_id').val() + '=' + lbni);
    // $('#idnopsave_luas_tbb').val($('#luas_bangunan_b_id').val());
    
    var npni = parseInt($('#l_njop_tanah_nop_h_id').val())+parseInt($('#l_njop_bangunan_nop_h_id').val())+parseInt($('#l_njop_tanah_b_nop_h_id').val())+parseInt($('#l_njop_bangunan_b_nop_h_id').val()); 
    $('#njop_pbb_nop_id').html(number_format(npni, 0, ',', '.')); $('#njop_pbb_nop_h_id').val(npni);
    count_nilai_pasar_max_sptpd();
}