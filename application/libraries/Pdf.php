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