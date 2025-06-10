<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * CodeIgniter Esign Library
 *
 * Generate PDF's Signed By BSRE in your CodeIgniter applications.
 *
 * @package			CodeIgniter
 * @subpackage		Libraries
 * @category		Libraries
 * @author			MOKHAMAD FAIZAL ALI FAHMI
 * @license			GANOK
 * @link			https://github.com/m-faizal-a-f
 */

// Include all necessary files for Guzzle
require_once APPPATH . '/third_party/guzzlehttp/guzzle_autoload.php';
require_once APPPATH . '/third_party/bapendakotamalang/e-sign-bsre-php/src/ESignBsre.php';
require_once APPPATH . '/third_party/bapendakotamalang/e-sign-bsre-php/src/ESignBsreResponse.php';

use BAPENDAKOTAMALANG\ESignBsrePhp\ESignBsre;

class Esign
{
    /**
     * Get an instance of CodeIgniter
     *
     * @access	protected
     * @return	void
     */
    protected function ci()
    {
        return get_instance();
    }

    /**
     * proses TTE
     *
     * @access	public
     * @param	string	$view The view to load
     * @param	array	$data The view data
     * @return	void
     */
    public function proses_tte($data_proses)
    {
        $baseUrl    = '103.135.14.149';
        $username   = 'esign';
        $password   = 'qwerty';

        $file       = file_get_contents($data_proses["full_path"]);
        $filename   = "signed_" . $data_proses["timestamp"] . ".pdf";

        $nik        = $data_proses["nik_tte"];
        $passphrase = $data_proses["passphrase_tte"];

        $esign      = new ESignBSrE($baseUrl, $username, $password);
        $esign->setFile($file, $filename);
        $response   = $esign->signInvisible($nik, $passphrase);

        if ($response->getStatus() == 200) {
            return array(
                "status_code"   => $response->getStatus(), //integer sample => 200
                "error_message" => $response->getErrors(), //null
                "data_blob_pdf" => $response->getData()    //{ "nama_dokumen": "SSPDBPHTBPDF.pdf", "jumlah_signature": 1, "notes": "Dokumen valid, Sertifikat yang digunakan terpercaya", "details": [ { "info_tsa": { "name": "Timestamp Authority Badan Siber dan Sandi Negara", "tsa_cert_validity": "" }, "signature_field": "sig_1717554118238", "info_signer": { "issuer_dn": "C=ID,O=Lembaga Sandi Negara,CN=OSD LU Kelas 2", "signer_name": "Yuyun Nanik Ekowati", "signer_cert_validity": "2024-06-05 09:32:40.86 to 2024-06-05 09:32:40.86", "signer_dn": "Yuyun Nanik Ekowati", "cert_user_certified": 1 }, "signature_document": { "signed_using_tsa": 1, "reason": "percobaan", "document_integrity": 1, "signature_value": "", "signed_in": "2024-06-05 09:32:40.86", "location": "Pemerintah Kota Malang", "hash_value": "" } } ], "summary": "VALID" }
            );
        } else {
            return array(
                "status_code"   => $response->getStatus(), //integer sample => 400
                "error_message" => $response->getErrors(), //json sample => {"error":"Passphrase anda salah","status_code":2031}
            );
        }
    }

    public function validasi_tte($data_proses)
    {
    }
}
