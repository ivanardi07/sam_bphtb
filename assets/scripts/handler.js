$(document).ready(function(){
	// var url_bphtb = 'http://localhost/bphtb_mysql/';
	var url_bphtb = 'http://10.10.10.37:5151/bphtb_blitar/';

	$('#btnPPATdetail').click(function(){
		var val = $('#id_ppat_id').val();
		
		$.ajax({
			url:url_bphtb+'index.php/ppat/check_ppat',
			data:{enPpatValue:val,ajax:1},
			type:'POST',
			dataType:'json',
			success: function(data) {
				if(data['result'].length > 0) {
					$('#nama_ppat_id').text(data['result']);
				} else {
					$('#id_ppat_id').val('');
					$('#nama_ppat_id').text('');
					$('#ppat_error').before('<br id="hapus"/>');
					$('#ppat_error').css('margin-left',0);
					$('#ppat_error').text('No ID PPAT '+val+' Tidak Ditemukan');
					$('#id_ppat_id').focus();
					$('#ppat_error').fadeIn(300).delay(1000).fadeOut('fast');
					$('#hapus').remove();
					//alert('No ID PPAT '+val+' Tidak Ditemukan');  
				}
			}
		});     
	});
	
	$('#btnNIKdetail').click(function(){
		var val = $('#id_nik_id').val();
		
		$.ajax({
			url:url_bphtb+'index.php/web_service/check_nik',
			data:{enNikValue:val,ajax:1},
			type:'POST',
			dataType:'json',
			success: function(data) {
				if(data['nama'].length > 0) {
					$('#nama_nik_id').text(data['nama']);
					$('#alamat_nik_id').text(data['alamat']);
					$('#kelurahan_nik_id').text(data['kelurahan']);
					$('#rtrw_nik_id').text(data['rtrw']);
					$('#kecamatan_nik_id').text(data['kecamatan']);
					$('#kotakab_nik_id').text(data['kota']);
					$('#kodepos_nik_id').text(data['kodepos']);
					$('#nama_nik_id_text').hide();
					$('#alamat_nik_id_text').hide();
					$('#rtrw_nik_id_text').hide();
					$('#kodepos_nik_id_text').hide();
					$('#propinsi_nik_id_text').hide();
					$('#kotakab_nik_id_text').hide();
					$('#kecamatan_nik_id_text').hide();
					$('#kelurahan_nik_id_text').hide();
				} else {
					$('#nama_nik_id').val('');
					$('#alamat_nik_id').text('');
					$('#kelurahan_nik_id').text('');
					$('#rtrw_nik_id').text('');
					$('#kecamatan_nik_id').text('');
					$('#kotakab_nik_id').text('');
					$('#kodepos_nik_id').text('');
					alert('Nik '+val+' Tidak Ditemukan'); 
					$('#id_nik_id').focus();
					$('#nama_nik_id_text').show();
					$('#alamat_nik_id_text').show();
					$('#rtrw_nik_id_text').show();
					$('#kodepos_nik_id_text').show();
					$('#propinsi_nik_id_text').show();
					$('#kotakab_nik_id_text').show();
					$('#kecamatan_nik_id_text').show();
					$('#kelurahan_nik_id_text').show();
				}
			}
		});     
	});
	
	$('#btnNOPdetail').click(function(){
		var val = $('#nop_id').val();
		
		$.ajax({
			url:url_bphtb+'index.php/nop/check_nop',
			data:{enNopValue:val,ajax:1},
			type:'POST',
			dataType:'json',
			success: function(data) {
				if(data['lokasi'].length > 0) {
					$('#lokasi_nop_id').text(data['lokasi']);
					$('#kotakab_nop_id').text(data['kotakab']);
					$('#kecamatan_nop_id').text(data['kecamatan']);
					$('#kelurahan_nop_id').text(data['kelurahan']);
					$('#rtrw_nop_id').text(data['rtrw']);
					$('#njop_tanah_nop_id').text(data['njop_tanah']);
					$('#njop_bangunan_nop_id').text(data['njop_bangunan']);
					$('#luas_tanah_nop_id').text(data['luas_tanah']);
					$('#luas_bangunan_nop_id').text(data['luas_bangunan']);
					$('#l_njop_tanah_nop_id').text(data['l_njop_tanah']);
					$('#l_njop_bangunan_nop_id').text(data['l_njop_bangunan']);
					$('#njop_pbb_nop_id').text(data['njop_pbb']);
					$('#nilai_nop_id').text(data['nilai_nop']);
					$('#jns_perolehan_nop_id').text(data['jns_perolehan']);
					$('#no_sertipikat_nop_id').text(data['no_sertipikat']);
				} else {
				$('#nop_id').val('');
					$('#lokasi_nop_id').text('');
					$('#kotakab_nop_id').text('');
					$('#kecamatan_nop_id').text('');
					$('#kelurahan_nop_id').text('');
					$('#rtrw_nop_id').text('');
					$('#njop_tanah_nop_id').text('');
					$('#njop_bangunan_nop_id').text('');
					$('#luas_tanah_nop_id').text('');
					$('#luas_bangunan_nop_id').text('');
					$('#l_njop_tanah_nop_id').text('');
					$('#l_njop_bangunan_nop_id').text('');
					$('#njop_pbb_nop_id').text('');
					$('#nilai_nop_id').text('');
					$('#jns_perolehan_nop_id').text('');
					$('#no_sertipikat_nop_id').text('');
					$('#nop_error').text('NOP '+val+' Tidak Ditemukan');
					$('#nop_error').fadeIn(300).delay(1000).fadeOut('fast');
					//alert('NOP '+val+' Tidak Ditemukan'); 
					$('#nop_id').focus();
				}
			}
		});     
	});

});