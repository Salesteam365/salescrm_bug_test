<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * CodeIgniter PDF Library
 *
 * Generate PDF in CodeIgniter applications.
 *
 * @package            CodeIgniter
 * @subpackage        Libraries
 * @category        Libraries
 * @author            CodexWorld
 * @license            https://www.codexworld.com/license/
 * @link            https://www.codexworld.com
 */

// reference the Dompdf namespace
use Dompdf\Dompdf;
use Dompdf\Options as Options;

class Pdf
{
    /**
    * Construct the Pdf library: loads Dompdf, creates a Dompdf instance and attaches it to the CodeIgniter instance ($CI->dompdf).
    * @example
    * $pdfLib = new Pdf();
    * $CI =& get_instance();
    * echo get_class($CI->dompdf); // sample output: "Dompdf\Dompdf"
    * @param void $none - No parameters are accepted for this constructor.
    * @returns void The constructor does not return a value; it initializes and assigns the Dompdf instance.
    */
    public function __construct(){
        
        // include autoloader
        // require 'vendor/autoload.php';
        require_once dirname(__FILE__).'/dompdf/autoload.inc.php';
        
        // instantiate and use the dompdf class
        $options = $options ?? new \Dompdf\Options();

        // $this->options = $options;
       
        $pdf = new DOMPDF();
       
        $CI =& get_instance();
        $CI->dompdf = $pdf;
        // $this->options->setIsRemoteEnabled(true);
        // $this->dompdf->setOptions($this->options);
    }
}
?>