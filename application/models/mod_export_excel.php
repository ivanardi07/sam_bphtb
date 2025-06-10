<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mod_export_excel extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		
	}

	public function export_laporan($value='')
	{

		// $sql='select * from tbl_sptpd limit 0,20';
		// $sql = 'select '
		// die('sek');
		// $pencarian = $this->session->userdata('pencarian');

        
  //        if (@$pencarian['ppat'] != '') {
  //           $this->db->where('id_ppat', @$pencarian['ppat']);
  //       }
  //        if (@$pencarian['tgl_validasi'] != '') {
  //           $this->db->where('validasi_dispenda', @$pencarian['tgl_validasi']);
  //       }
  //        if (@$pencarian['tgl_pelayanan'] != '') {
  //           $this->db->where('tanggal', @$pencarian['tgl_pelayanan']);
  //       }
  //        if (@$pencarian['jns_perolehan'] != '') {
  //           $this->db->where('jenis_perolehan', @$pencarian['jns_perolehan']);
  //       }
  //        if (@$pencarian['kecamatan'] != '') {
  //           $this->db->where('tbl_sptpd.kd_kecamatan', @$pencarian['kecamatan']);
  //       }
  //       $this->db->select('tbl_sptpd.*,tbl_nik.nama as nik_nama,tbl_kelurahan.nama as kel_nama,tbl_kecamatan.nama as kec_nama,master_jenis_perolehan.jp_nama,tbl_ppat.nama as ppat_nama,tbl_nop.rtrw_op');
  //       $this->db->join('tbl_nik', 'tbl_sptpd.nik = tbl_nik.nik', 'left');
  //       $this->db->join('tbl_kecamatan', 'tbl_sptpd.kd_kecamatan = tbl_kecamatan.kd_kecamatan and tbl_kecamatan.kd_kabupaten="21" and tbl_kecamatan.kd_propinsi="35" ', 'left');
  //       $this->db->join('tbl_kelurahan', 'tbl_sptpd.kd_kecamatan = tbl_kelurahan.kd_kecamatan and tbl_sptpd.kd_kelurahan = tbl_kelurahan.kd_kelurahan and tbl_kelurahan.kd_kabupaten="21" and tbl_kelurahan.kd_propinsi="35" ', 'left');
  //       $this->db->join('master_jenis_perolehan', 'master_jenis_perolehan.jp_kode = tbl_sptpd.jenis_perolehan', 'left');
  //       $this->db->join('tbl_ppat', 'tbl_ppat.id_ppat = tbl_sptpd.id_ppat', 'left');
  //       $this->db->join('tbl_nop', 'tbl_nop.kd_propinsi = tbl_sptpd.kd_propinsi and tbl_nop.kd_kabupaten = tbl_sptpd.kd_kabupaten and tbl_nop.kd_kecamatan = tbl_sptpd.kd_kecamatan and tbl_nop.kd_kelurahan = tbl_sptpd.kd_kelurahan and tbl_nop.kd_blok = tbl_sptpd.kd_blok and tbl_nop.no_urut = tbl_sptpd.no_urut and tbl_nop.kd_jns_op = tbl_sptpd.kd_jns_op ', 'left');
  //      $this->db->limit('20');
        $query = $this->db->get('tbl_sptpd');
       
		// echo $this->db->last_query();
		$data=$query->result();
		// echo "<pre>";
		// print_r ($data);
		// echo "</pre>";;
		$this->load->library('Excel');
					PHPExcel_Settings::setZipClass(PHPExcel_Settings::PCLZIP);
					// $this->excel->set_font('Calibri', 10); 
		$this->excel->setActiveSheetIndex(0);
						// $this->excel->set_title('Laporan');
						$this->excel->getActiveSheet()->getStyle("A2")->getFont()->setBold(true)
										//->setName('Verdana')
										->setSize(16);
						// $this->excel->getActiveSheet()
							// ->getStyle("J4:K5")
							// ->getAlignment()
							// ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
						// $this->excel->getActiveSheet()
							// ->getStyle( $this->excel->getActiveSheet()->calculateWorksheetDimension() )
							// ->getAlignment()->setWrapText(true);
						// $this->excel->width(array(array('B', 7),array('C', 20), array('D', 40), array('E', 20), array('F', 13), array('G', 13), array('H', 13),array('M', 13),array('N', 13), array('I', 13), array('J', 13), array('K', 13)));
						 $no = 2;
						 $number = $no+6;
						 $i = $number+1;

						 $jml_terutang = 0;
						 $jml_total=0;
						 $jml_njop=0;
						foreach($data as $key =>  $val){

							// $this->excel->getActiveSheet()->getStyle('K'.$i)->getNumberFormat()->setFormatCode('#,##0.00');
							// $this->excel->getActiveSheet()->getStyle('N'.$i)->getNumberFormat()->setFormatCode('#,##0.00');
							$this->excel->setActiveSheetIndex(0)
							->setCellValue('A'.$i, $i-$number)
							->setCellValue('B'.$i, @$val->id_sptpd)
							->setCellValue('C'.$i, @$val->id_ppat)
							->setCellValue('D'.$i, @$val->nik)
							->setCellValue('E'.$i, @$val->no_urut)
							->setCellValue('F'.$i, @$val->jenis_perolehan)
							->setCellValue('G'.$i, @$val->luas_tanah_op)
							->setCellValue('H'.$i, @$val->luas_bangunan_op)
							->setCellValue('I'.$i, @$val->njop_tanah_op)
							->setCellValue('J'.$i, @$val->njop_bangunan_op)
							->setCellValue('K'.$i, @$val->nilai_op)
							->setCellValue('L'.$i, @$val->nilai_pasar)
							->setCellValue('M'.$i, @$val->no_sertifikat_op)
							->setCellValue('N'.$i, @$val->njop_pbb_op)
							->setCellValue('O'.$i, @$val->thn_pajak_sppt)
							->setCellValue('P'.$i, @$val->no_dokumen);
							// ->setCellValue('Q'.$i, @$val->kel_nama);
							// ->setCellValue('E'.$i, $data['STOK AWAL'] == "" ? 0 : $data['STOK AWAL'])
							// ->setCellValue('F'.$i, $data['MASUK PBF'] == "" ? 0 : $data['MASUK PBF'])
							// ->setCellValue('G'.$i, $data['MASUK SARANA'] == "" ? 0 : $data['MASUK SARANA'])
							// ->setCellValue('H'.$i, $data['KELUAR RUMAH SAKIT'] == "" ? 0 : $data['KELUAR RUMAH SAKIT'])
							// ->setCellValue('I'.$i, $data['KELUAR APOTEK'] == "" ? 0 : $data['KELUAR APOTEK'])
							// ->setCellValue('J'.$i, $data['KELUAR PBF'] == "" ? 0 : $data['KELUAR PBF'])
							// ->setCellValue('K'.$i, $data['KELUAR PEMERINTAH'] == "" ? 0 : $data['KELUAR PEMERINTAH'])
							// ->setCellValue('L'.$i, $data['KELUAR SWASTA'] == "" ? 0 : $data['KELUAR SWASTA'])
							// ->setCellValue('M'.$i, $data['STOK AKHIR'] == "" ? 0 : $data['STOK AKHIR'])
							// ->setCellValue('N'.$i, $data['HJD'] == "" ? 0 : 'Rp. '.$data['HJD'] );

							$i++;
						}
						// $this->excel->getActiveSheet()->getStyle('K'.$i)->getNumberFormat()->setFormatCode('#,##0.00');
						// 	$this->excel->getActiveSheet()->getStyle('N'.$i)->getNumberFormat()->setFormatCode('#,##0.00');
						// $this->excel->setActiveSheetIndex(0)
						// 	->setCellValue('A'.$i, 'JUMLAH')
						// 	->setCellValueExplicit('K'.$i, @$jml_total, PHPExcel_Cell_DataType::TYPE_STRING)
						// 	->setCellValueExplicit('M'.$i, @$jml_njop, PHPExcel_Cell_DataType::TYPE_STRING)
						// 	->setCellValueExplicit('N'.$i, @$jml_terutang, PHPExcel_Cell_DataType::TYPE_STRING);
						// exit();

						// $this->excel->mergecell(array(array('A2', 'P2'), array('A3', 'P3'),array('A4', 'P4'), array('A6' ,'A8' ),array('B6' ,'B8' ),array('C6' ,'D7' ),array('E6' ,'H7' ),array('I6' ,'J6' ),array('K6' ,'K8' ),array('L6' ,'M7' ),array('N6' ,'N8' ),array('O6' ,'O8' ),array('P6' ,'P8' ),array('Q6' ,'Q8' )), TRUE);

						$this->excel->width(array(array('A', 10),array('B', 10), array('C', 15), array('D', 25), array('E', 10), array('F', 20), array('G', 25),array('H', 25),array('I', 25), array('J', 25), array('K', 25), array('L', 25),array('M', 25),array('N', 25),array('O', 25),array('P', 25)));
						
						$this->excel->setActiveSheetIndex(0)->setCellValue('A'.$no, 'LAPORAN SSPD ')
						->setCellValue('A'.($no+1), 'TANGGAL '.date('Y-m-d'))
						->setCellValue('A8', 'No ')
						->setCellValue('B8', 'ID SSPD ')
						->setCellValue('C8', 'ID PPAT')
						->setCellValue('D8', 'NIK ')
						->setCellValue('E8', 'No Urut ')
						->setCellValue('F8', 'Jns Perolehan ')
						->setCellValue('G8', 'Luas Tanah OP ')
						->setCellValue('H8', 'Luas Bangunan OP ')
						->setCellValue('I8', 'NJOP Tanah OP ')
						->setCellValue('J8', 'NJOP Bangunan OP ')
						->setCellValue('K8', 'Nilai OP ')
						->setCellValue('L8', 'Nilai Pasar ')
						->setCellValue('M8', 'No Sertifikat')
						->setCellValue('N8', 'NJOP PBB OP ')
						->setCellValue('O8', 'Tahun SPPT ')
						->setCellValue('P8', 'NO Dokumen ')
						;
						ob_clean();
				$file = "SSPDEXCEL ";
				// header("Content-type: application/x-msdownload");
				// header("Content-Disposition: attachment; filename=$file.xls");
				// header("Cache-Control: max-age=0");
				// header("Pragma: no-cache");
				// header("Expires: 0");
				// header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
				// header("Content-Disposition: attachment;filename=\"$file.xls\"");
				// header("Cache-Control: max-age=0");
				header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
				header("Content-Disposition: attachment;filename=\"$file.xls\"");
				header("Cache-Control: max-age=0");
				
				//PHPExcel_Settings::setZipClass(PHPExcel_Settings::PCLZIP);
				$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
				$objWriter->save('php://output');
				// exit();
						
						
	}
	

}

/* End of file mod_export_excel.php */
/* Location: ./application/models/mod_export_excel.php */