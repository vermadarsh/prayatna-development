<?php 
include 'tcpdf/tcpdf.php';

class SALARYPDF extends TCPDF {

//Page header
    public function Header() {
	    $logo_image_id          = (int) get_field('site_logo','option');
        $logo_image_url         = cf_get_image_url( $logo_image_id );
        // debug($logo_image_url);
        // die;
		$logo_file_info         = pathinfo( $logo_image_url );
		$logo_file_extension    = ( ! empty( $logo_file_info['extension'] ) ) ? ucfirst( $logo_file_info['extension'] ) : '';
		$this->SetFont( 'helvetica', 'M', 12 );
		$this->SetXY( 140, 14 );
		$this->writeHTMLCell( 0, 0, '', '', $html, 0, 1, 0, true, 'top', true );
		$this->Image( $logo_image_url, 10, 5, 40, '', $logo_file_extension, '', 'T', false, 800, 'L', false, false, 0, false, false, false );
        // debug($this->Image);
        // die;
		$html = '<table cellspacing="0" cellpadding="0" width="60%" border="0">
					<tr width="100%">
						<td style="line-height:14px;font-size:11px;"><img src="'. $logo_image_url .'"></td>
					</tr>
				</table>';

		$this->SetXY( 50, 5 );
		$this->writeHTMLCell( 0, 0, '', '', $html, 0, 1, 0, true, 'top', true );
		$style = array(
			'width' => 0.25,
			'cap'   => 'butt',
			'join'  => 'miter',
			'dash'  => 0,
			'color' => array( 222, 219, 219 ),
		);
		$this->Line( 0, 30, 220, 30, $style );
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