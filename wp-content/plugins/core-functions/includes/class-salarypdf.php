<?php 
include 'tcpdf/tcpdf.php';

class SALARYPDF extends TCPDF {

//Page header
    public function Header() {
	    // Logo
		$image_file = get_field('site_logo','option');
        $logo_file_info         = pathinfo( $image_file );
		$logo_file_extension    = ( ! empty( $logo_file_info['extension'] ) ) ? ucfirst( $logo_file_info['extension'] ) : '';
        $this->Image( $logo_image_url, 10, 5, 40, '', $logo_file_extension, '', 'T', false, 800, 'L', false, false, 0, false, false, false );
		// Set font
		$this->SetFont('helvetica', 'B', 20);
		// Title
		$this->Cell(0, 15, '<< TCPDF Example 003 >>', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        debug($this);
        die;
	}
	public function Footer() {
	    // Position at 15 mm from bottom
		$this->SetY(-15);
		// Set font
		$this->SetFont('helvetica', 'I', 8);
		// Page number
		$this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}