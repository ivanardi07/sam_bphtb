<?php defined('BASEPATH') or exit('No direct script access allowed');
/**


 * CodeIgniter PDF Library
 *
 * Generate PDF's in your CodeIgniter applications.
 *
 * @package         CodeIgniter
 * @subpackage      Libraries
 * @category        Libraries
 * @author          Mokhamad Faizal Ali Fahmi
 * @license         Gaono
 * @link            Gaono



 */

require_once APPPATH . 'third_party/tcpdf/qr/qrlib.php';

class Qris extends QRcode
{
    /**
     * Get an instance of CodeIgniter
     *
     * @access  protected
     * @return  void
     */
    protected function ci()
    {
        return get_instance();
    }

    /**
     * Load a CodeIgniter view into domPDF
     *
     * @access  public
     * @param   string  $view The view to load
     * @param   array   $data The view data
     * @return  void
     */
    public function generateQRIS($qrValue, $return = "img")
    {
        $randomize           = substr(str_shuffle("abcdefghijklmnopqrstuvwxyz123456789"), 0, 17);

        //$codeContents      = $row["KD_PROPINSI"].$row["KD_DATI2"].$row["KD_KECAMATAN"].$row["KD_KELURAHAN"].$row["KD_BLOK"].$row["NO_URUT"].'2021 xASDFASGAGDAFGERMKTFASNRFO8437YFN9O42H5I3NTIWQANF9Q3N4T9QNG9NHGR9Q3NG9QNT9QNBTUJFOADNVINGPQNTNTPQNT9P4NTQ39THQ9TH';
        $codeContents        = $qrValue;
        $fileName            = $randomize . md5($qrValue) . '.png';

        $blank_qr            = base_url() . "assets/images/blank.png";
        $PictDir             = base_url() . "assets/images/qrcode/";

        $pngAbsoluteFilePath = "./assets/images/qrcode/" . $fileName;
        $urlRelativeFilePath = $PictDir . $fileName;

        if (!file_exists($pngAbsoluteFilePath)) {
            QRcode::png($codeContents, $pngAbsoluteFilePath, QR_ECLEVEL_M, 4, 1);
            $imgsrc = ($return == "img") ? '<img src="' . $urlRelativeFilePath . '" />' : (($return == "file_name") ? $fileName : $urlRelativeFilePath);
        } else {
            $imgsrc = ($return == "img") ? '<img src="' . $blank_qr . '" />' : (($return == "file_name") ? $fileName : $urlRelativeFilePath);
        }
        return $imgsrc;
    }
}
