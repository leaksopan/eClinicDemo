<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'third_party/mpdf/vendor/autoload.php';

class Pdf {
    public $mpdf;
    
    public function __construct() {
        $this->mpdf = new \Mpdf\Mpdf([
            'margin_top' => 10,
            'margin_right' => 10,
            'margin_bottom' => 10,
            'margin_left' => 10
        ]);
    }
    
    public function load($html, $filename = 'document.pdf') {
        $this->mpdf->WriteHTML($html);
        $this->mpdf->Output($filename, 'I');
    }
} 