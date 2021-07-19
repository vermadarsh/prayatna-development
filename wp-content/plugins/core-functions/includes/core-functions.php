<?php
/**
 * This file is used for writing all the re-usable custom functions.
 *
 * @since 1.0.0
 * @package Core_Functions
 * @subpackage Core_Functions/includes
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly.

/**
 * Fetch the user full name.
 *
 * @param $user_id int Holds the user ID.
 * @return string
 */
function cf_get_user_full_name( $user_id ) {
	$first_name = get_user_meta( $user_id, 'first_name', true );
	$last_name  = get_user_meta( $user_id, 'last_name', true );

	return "{$first_name} {$last_name}";
}

/**
 * Get the time based text.
 *
 * @return string
 */
function cf_get_time_based_text() {
	$text         = '';
	$current_time = gmdate( 'H:i:s' );

	if ( have_rows( 'good_morning_good_evening_texts', 'option' ) ) {
		while( have_rows( 'good_morning_good_evening_texts', 'option' ) ) {
			the_row();
			$start_time = get_sub_field( 'start_time' );
			$end_time   = get_sub_field( 'end_time' );
			$is_between = cf_time_is_between_two_times( $start_time, $end_time, $current_time );

			if ( $is_between ) {
				$text = get_sub_field( 'time_dependant_text' );
			}
		}
	}

	return $text;
}

/**
 * Check if a time falls in between 2 time values. Format - H:i:s
 *
 * @param $from string Holds the from time.
 * @param $till string Holds the till time.
 * @param $input string Holds the input time.
 * @return boolean
 */
function cf_time_is_between_two_times( $from, $till, $input ) {
	$f = DateTime::createFromFormat( 'H:i:s', $from );
	$t = DateTime::createFromFormat( 'H:i:s', $till );
	$i = DateTime::createFromFormat( 'H:i:s', $input );

	if ( $f > $t ) {
		$t->modify('+1 day');
	}

	return ( $f <= $i && $i <= $t ) || ( $f <= $i->modify( '+1 day' ) && $i <= $t );
}

/**
 * Returns the image source by attachment id.
 *
 * @param int $attachment_id Holds the attachment ID.
 * @return boolean|string
 */
function cf_get_image_url_by_attachment_id( $attachment_id ) {
	// Return false, if the attachment ID is empty.
	if ( empty( $attachment_id ) ) {
		return false;
	}

	return apply_filters( 'cf_prayatna_image_source', wp_get_attachment_url( $attachment_id ), $attachment_id );
}

/**
 * Check to see if the asked user is a therapist.
 *
 * @param int $user_id Holds the user ID.
 * @return boolean
 */
function cf_is_user_therapist( $user_id ) {
	$user = get_userdata( $user_id );

	if ( empty( $user->roles ) || ! is_array( $user->roles ) ) {
		return false;
	}

	if ( ! in_array( 'therapist', $user->roles, true ) ) {
		return false;
	}

	return true;
}

/**
 * Check to see if the asked user is a admin.
 *
 * @param int $user_id Holds the user ID.
 * @return boolean
 */
function cf_is_user_admin( $user_id ) {
	$user = get_userdata( $user_id );

	if ( empty( $user->roles ) || ! is_array( $user->roles ) ) {
		return false;
	}

	if ( ! in_array( 'administrator', $user->roles, true ) ) {
		return false;
	}

	return true;
}

/**
 * Check to see if the asked user is a client.
 *
 * @param int $user_id Holds the user ID.
 * @return boolean
 */
function cf_is_user_client( $user_id ) {
	$user = get_userdata( $user_id );

	if ( empty( $user->roles ) || ! is_array( $user->roles ) ) {
		return false;
	}

	if ( ! in_array( 'client', $user->roles, true ) ) {
		return false;
	}

	return true;
}

/**
 * Check to see if the asked user is a student.
 *
 * @param int $user_id Holds the user ID.
 * @return boolean
 */
function cf_is_user_student( $user_id ) {
	$user = get_userdata( $user_id );

	if ( empty( $user->roles ) || ! is_array( $user->roles ) ) {
		return false;
	}

	if ( ! in_array( 'student', $user->roles, true ) ) {
		return false;
	}

	return true;
}

/**
 * Check to see if the asked user is a receptionist.
 *
 * @param int $user_id Holds the user ID.
 * @return boolean
 */
function cf_is_user_receptionist( $user_id ) {
	$user = get_userdata( $user_id );

	if ( empty( $user->roles ) || ! is_array( $user->roles ) ) {
		return false;
	}

	if ( ! in_array( 'receptionist', $user->roles, true ) ) {
		return false;
	}

	return true;
}

/**
 * Return child's profile registration fields.
 *
 * @param int $index Holds the html index.
 * @return string
 */
function cf_get_child_profile_registration_fields_html( $index ) {
	ob_start();
	?>
	<div class="col-md-12 top__margin__10 child-<?php echo esc_attr( $index ); ?> child-profile-fields">
		<div class="col-md-12"><h5><?php echo sprintf( __( 'Child: %1$d', 'core-functions' ), $index ); ?></h5></div>
		<!-- FIRST NAME -->
		<div class="col-md-6">
			<span class="input input--hfd">
				<input class="input__field input__field--hfd child-first-name" type="text" required onkeypress="return /[a-z]/i.test(event.key)" />
				<label class="input__label input__label--hfd">
					<span class="input__label-content input__label-content--hfd "><?php esc_html_e( 'First Name*', 'core-functions' ); ?></span>
				</label>
			</span>
		</div>
		<!-- LAST NAME -->
		<div class="col-md-6">
			<span class="input input--hfd">
				<input class="input__field input__field--hfd child-last-name" type="text" required onkeypress="return /[a-z]/i.test(event.key)" />
				<label class="input__label input__label--hfd">
					<span class="input__label-content input__label-content--hfd "><?php esc_html_e( 'Last Name*', 'core-functions' ); ?></span>
				</label>
			</span>
		</div>
		<!-- DOB -->
		<div class="col-md-6 top__margin__10">
			<span class="input input--hfd">
				<input class="input__field input__field--hfd cf__date__field child-dob" type="text" required />
				<label class="input__label input__label--hfd">
					<span class="input__label-content input__label-content--hfd"><?php esc_html_e( 'DOB* (DD-MM-YYYY)', 'core-functions' ); ?></span>
				</label>
			</span>
		</div>
		<!-- GENDER -->
		<div class="col-md-6 top__margin__10 child-gender-div">
			<select class="child-gender">
				<option value=""><?php esc_html_e( 'Gender*', 'core-functions' ); ?></option>
				<option value="male"><?php esc_html_e( 'Male', 'core-functions' ); ?></option>
				<option value="female"><?php esc_html_e( 'Female', 'core-functions' ); ?></option>
				<option value="other"><?php esc_html_e( 'Other', 'core-functions' ); ?></option>
			</select>
		</div>
	</div>
	<?php
	return ob_get_clean();
}

/**
 * Register Client Log CPT.
 */
function cf_register_client_log_cpt() {
	$labels = array(
		'name'               => __( 'Client Logs', 'core-functions' ),
		'singular_name'      => __( 'Client Log', 'core-functions' ),
		'menu_name'          => __( 'Client Logs', 'core-functions' ),
		'name_admin_bar'     => __( 'Client Log', 'core-functions' ),
		'add_new'            => __( 'New Client Log', 'core-functions' ),
		'add_new_item'       => __( 'New Client Log', 'core-functions' ),
		'new_item'           => __( 'New Client Log', 'core-functions' ),
		'edit_item'          => __( 'Edit Client Log', 'core-functions' ),
		'view_item'          => __( 'View Client Log', 'core-functions' ),
		'all_items'          => __( 'Client Logs', 'core-functions' ),
		'search_items'       => __( 'Search Client Logs', 'core-functions' ),
		'parent_item_colon'  => __( 'Parent Client Logs:', 'core-functions' ),
		'not_found'          => __( 'No Client Logs Found.', 'core-functions' ),
		'not_found_in_trash' => __( 'No Client Logs Found In Trash.', 'core-functions' )
	);

	$args = array(
		'labels'             => $labels,
		'public'             => false,
		'menu_icon'          => 'dashicons-welcome-write-blog',
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array(
			'slug' => 'client-log'
		),
		'capability_type'    => 'post',
		'capabilities'       => array(
			'edit_post'          => 'edit_client-log',
			'edit_posts'         => 'edit_client-logs',
			'edit_others_posts'  => 'edit_other_client-logs',
			'publish_posts'      => 'publish_client-logs',
			'read_post'          => 'read_client-log',
			'read_private_posts' => 'read_private_client-logs',
			'delete_post'        => 'delete_client-log'
		),
		'has_archive'        => false,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array(
			'title', 'content', 'author'
		)
	);
	register_post_type( 'client-log', $args );

	$set = get_option( 'cpt_cf_client_log_flushed_rewrite_rules' );

	if ( 'yes' !== $set ) {
		flush_rewrite_rules( false );
		update_option( 'cpt_cf_client_log_flushed_rewrite_rules', 'yes' );
	}
}

/**
 * Register Learning Lounge CPT.
 */
function cf_register_learning_lounge_log_cpt() {
	$labels = array(
		'name'               => __( 'Learning Lounge Logs', 'core-functions' ),
		'singular_name'      => __( 'Learning Lounge Log', 'core-functions' ),
		'menu_name'          => __( 'Learning Lounge Logs', 'core-functions' ),
		'name_admin_bar'     => __( 'Learning Lounge Log', 'core-functions' ),
		'add_new'            => __( 'New Learning Lounge Log', 'core-functions' ),
		'add_new_item'       => __( 'New Learning Lounge Log', 'core-functions' ),
		'new_item'           => __( 'New Learning Lounge Log', 'core-functions' ),
		'edit_item'          => __( 'Edit Learning Lounge Log', 'core-functions' ),
		'view_item'          => __( 'View Learning Lounge Log', 'core-functions' ),
		'all_items'          => __( 'Learning Lounge Logs', 'core-functions' ),
		'search_items'       => __( 'Search Learning Lounge Logs', 'core-functions' ),
		'parent_item_colon'  => __( 'Parent Learning Lounge Logs:', 'core-functions' ),
		'not_found'          => __( 'No Learning Lounge Logs Found.', 'core-functions' ),
		'not_found_in_trash' => __( 'No Learning Lounge Logs Found In Trash.', 'core-functions' )
	);

	$args = array(
		'labels'             => $labels,
		'public'             => false,
		'menu_icon'          => 'dashicons-welcome-write-blog',
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array(
			'slug' => 'learning-lounge-log'
		),
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array(
			'title', 'content', 'author'
		)
	);
	register_post_type( 'learning-lounge-log', $args );

	$set = get_option( 'cpt_cf_learning_lounge_log_flushed_rewrite_rules' );

	if ( 'yes' !== $set ) {
		flush_rewrite_rules( false );
		update_option( 'cpt_cf_learning_lounge_log_flushed_rewrite_rules', 'yes' );
	}
}

/**
 * Register Leave CPT.
 */
function cf_register_leave_cpt() {
	$labels = array(
		'name'               => __( 'Leaves', 'core-functions' ),
		'singular_name'      => __( 'Leave', 'core-functions' ),
		'menu_name'          => __( 'Leaves', 'core-functions' ),
		'name_admin_bar'     => __( 'Leave', 'core-functions' ),
		'add_new'            => __( 'New Leave', 'core-functions' ),
		'add_new_item'       => __( 'New Leave', 'core-functions' ),
		'new_item'           => __( 'New Leave', 'core-functions' ),
		'edit_item'          => __( 'Edit Leave', 'core-functions' ),
		'view_item'          => __( 'View Leave', 'core-functions' ),
		'all_items'          => __( 'Leaves', 'core-functions' ),
		'search_items'       => __( 'Search Leaves', 'core-functions' ),
		'parent_item_colon'  => __( 'Parent Leaves:', 'core-functions' ),
		'not_found'          => __( 'No Leaves Found.', 'core-functions' ),
		'not_found_in_trash' => __( 'No Leaves Found In Trash.', 'core-functions' )
	);

	$args = array(
		'labels'             => $labels,
		'public'             => false,
		'menu_icon'          => 'dashicons-welcome-write-blog',
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array(
			'slug' => 'leave'
		),
		'capability_type'    => 'post',
		'capabilities'       => array(
			'edit_post'            => 'edit_leave',
			'edit_posts'           => 'edit_leaves',
			'edit_other_posts'     => 'edit_other_leaves',
			'edit_others_posts'    => 'edit_others_leaves',
			'edit_others_post'     => 'edit_others_leave',
			'edit_published_post'  => 'edit_published_leave',
			'edit_published_posts' => 'edit_published_leaves',
			'publish_post'         => 'publish_leave',
			'publish_posts'        => 'publish_leaves',
			'read_post'            => 'read_leave',
			'read_private_post'    => 'read_private_leave',
			'read_private_posts'   => 'read_private_leaves',
			'delete_post'          => 'delete_leave',
			'delete_posts'         => 'delete_leaves'
		),
		'has_archive'        => false,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array(
			'title', 'content', 'author'
		)
	);
	register_post_type( 'leave', $args );

	$set = get_option( 'cpt_cf_leave_flushed_rewrite_rules' );

	if ( 'yes' !== $set ) {
		flush_rewrite_rules( false );
		update_option( 'cpt_cf_leave_flushed_rewrite_rules', 'yes' );
	}
}

/**
 * Return the clients.
 *
 * @return array
 */
function cf_get_clients() {

	return get_users(
		array(
			'fields' => 'ids',
			'role'   => 'client',
		)
	);
}

/**
 * Get children list.
 *
 * @return array
 */
function cf_get_children() {
	$clients  = cf_get_clients();
	$children = array();

	// Return empty array if no client's available.
	if ( empty( $clients ) || ! is_array( $clients ) ) {
		return $children;
	}

	// Iterate through the client to get their children details.
	foreach ( $clients as $client_id ) {
		if ( ! have_rows( 'children_details', "user_{$client_id}" ) ) {
			continue;
		}

		// Iterate through the children details to prepare array.
		while( have_rows( 'children_details', "user_{$client_id}" ) ) {
			the_row();
			$children[] = array(
				'client_id'  => $client_id,
				'first_name' => get_sub_field( 'child_first_name' ),
				'last_name'  => get_sub_field( 'child_last_name' ),
				'dob'        => get_sub_field( 'child_dob' ),
			);
		}
	}

	return $children;
}

/**
 * Get the client logs.
 *
 * @return object
 */
function cf_get_client_logs( $paged = 1, $posts_per_page = -1 ) {
	$args = array(
		'post_type'      => 'client-log',
		'paged'          => $paged,
		'posts_per_page' => $posts_per_page,
		'post_status'    => 'publish',
		'fields'         => 'ids',
		'orderby'        => 'date',
		'order'          => 'DESC',
	);

	/**
	 * Client logs listing arguments filter.
	 *
	 * This filter helps to modify the arguments for retreiving client logs.
	 *
	 * @param array $args Holds the client log arguments.
	 * @return array
	 */
	$args = apply_filters( 'cf_client_logs_args', $args );

	return new WP_Query( $args );
}

/**
 * Get the learning lounge logs.
 *
 * @return object
 */
function cf_get_learning_lounge_logs( $author = '', $paged = 1, $posts_per_page = -1 ) {
	$args = array(
		'post_type'      => 'learning-lounge-log',
		'paged'          => $paged,
		'posts_per_page' => $posts_per_page,
		'post_status'    => 'publish',
		'fields'         => 'ids',
		'orderby'        => 'date',
		'order'          => 'DESC',
	);

	// If author is provided.
	if ( ! empty( $author ) ) {
		$args['author'] = $author;
	}

	/**
	 * Learning lounge logs listing arguments filter.
	 *
	 * This filter helps to modify the arguments for retreiving learning lounge logs.
	 *
	 * @param array $args Holds the learning lounge log arguments.
	 * @return array
	 */
	$args = apply_filters( 'cf_learning_lounge_logs_args', $args );

	return new WP_Query( $args );
}

/**
 * Check if the function exists.
 */
if ( ! function_exists( 'cf_get_dates_within_2_dates' ) ) {
	/**
	 * Get dates that fall between 2 dates.
	 *
	 * @param string $from Start date.
	 * @param string $to End date.
	 * @return boolean|DatePeriod
	 * @since 1.0.0
	 */
	function cf_get_dates_within_2_dates( $from, $to ) {
		// Return if either of the date is not provided.
		if ( empty( $from ) || empty( $to ) ) {
			return false;
		}

		// If end date falls before the $from date, let's swap.
		if ( ( strtotime( $to ) < strtotime( $from ) ) ) {
			$temp = $to;
			$to   = $from;
			$from = $temp;
		}

		// Get the dates array.
		$from     = new DateTime( $from );
		$to       = new DateTime( $to );
		$to       = $to->modify( '+1 day' );
		$interval = new DateInterval( 'P1D' );
		$period   = new DatePeriod( $from, $interval, $to );
		$dates    = array();

		if ( ! empty( $period ) ) {
			foreach ( $period as $date ) {
				$dates[] = $date->format( 'Y-m-d' );
			}
		}

		return $dates;
	}
}

/**
 * Return the current date according to local date.
 *
 * @return string
 */
function cf_get_current_date( $format = 'Y-m-d' ) {
	$timezone_format = _x( $format, 'timezone date format' );

	return date_i18n( $timezone_format );
}
/**
 * Function to generate PDF
 */
function cf_create_exporting_pdf() {
	if ( isset( $_POST['ttpe-export-text-to-pdf'] ) ) {
		include 'tcpdf/tcpdf.php';

		$pdf = new TCPDF( PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false );

		$pdf->SetCreator( PDF_CREATOR );
		$pdf->SetAuthor( 'Nicola Asuni' );
		$pdf->SetTitle( 'TCPDF Example 001' );
		$pdf->SetSubject( 'TCPDF Tutorial' );
		$pdf->SetKeywords( 'TCPDF, PDF, example, test, guide' );

		$pdf->SetHeaderData( PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE . ' 001', PDF_HEADER_STRING, array(
			0,
			64,
			255
		), array( 0, 64, 128 ) );
		$pdf->setFooterData( array( 0, 64, 0 ), array( 0, 64, 128 ) );
		$pdf->setHeaderFont( Array( PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN ) );
		$pdf->setFooterFont( Array( PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA ) );
		$pdf->SetDefaultMonospacedFont( PDF_FONT_MONOSPACED );
		$pdf->SetMargins( PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT );
		$pdf->SetHeaderMargin( PDF_MARGIN_HEADER );
		$pdf->SetFooterMargin( PDF_MARGIN_FOOTER );
		$pdf->SetAutoPageBreak( true, PDF_MARGIN_BOTTOM );
		$pdf->setImageScale( PDF_IMAGE_SCALE_RATIO );
		if ( @file_exists( dirname( __FILE__ ) . '/lang/eng.php' ) ) {
			require_once( dirname( __FILE__ ) . '/lang/eng.php' );
			$pdf->setLanguageArray( $l );
		}
		$pdf->setFontSubsetting( true );
		$pdf->SetFont( 'dejavusans', '', 14, '', true );
		$pdf->AddPage();
		$pdf->setTextShadow( array(
			'enabled'    => true,
			'depth_w'    => 0.2,
			'depth_h'    => 0.2,
			'color'      => array( 196, 196, 196 ),
			'opacity'    => 1,
			'blend_mode' => 'Normal'
		) );

		ob_start();
		?>
        <p>good morning</p>
		<?php
		$html = ob_get_clean();
		$pdf->writeHTMLCell( 0, 0, '', '', $html, 0, 1, 0, true, '', true );
		// $pdf->Output( 'example_001.pdf', 'D' );
		$pdf->Output(CF_PLUGIN_PATH . 'pdf-generation/example_001.pdf', 'F');
	}
}
