<?php 
include 'tcpdf/tcpdf.php';

class SALARYPDF extends TCPDF {

//Page header
    public function Header() {
	    // $logo_image_id          = (int) wpir_get_plugin_setting( 'store-logo-id' );
		$logo_image_url         = get_field('site_logo','option');
		$logo_file_info         = pathinfo( $logo_image_url );
        debug($logo_file_info);
        die;
		$logo_file_extension    = ( ! empty( $logo_file_info['extension'] ) ) ? ucfirst( $logo_file_info['extension'] ) : '';
		$store_address          = wpir_get_store_formatted_address();

		// Store Information.
		$store_contact = wpir_get_plugin_setting( 'store-contact-number' );
		$store_website = site_url();
		$store_email   = get_option( 'admin_email' );

		$this->SetFont( 'robotocondensed', 'M', 12 );
		$this->SetXY( 140, 14 );
		$this->writeHTMLCell( 0, 0, '', '', $html, 0, 1, 0, true, 'top', true );
		$this->Image( $logo_image_url, 10, 5, 40, '', $logo_file_extension, '', 'T', false, 800, 'L', false, false, 0, false, false, false );

		$html = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<table cellspacing="0" cellpadding="0" width="60%" border="0">
					<tr width="100%">
						<td style="line-height:14px;font-size:11px;">' . $store_address . '</td>
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