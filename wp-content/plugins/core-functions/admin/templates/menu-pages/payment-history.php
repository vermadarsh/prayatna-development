<?php
/**
 * Provide a admin payment history data table view for the plugin
 */

if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class Cf_Payment_History_Table extends WP_List_Table {

	public function __construct() {
		global $status, $page;

		parent::__construct( array(
			'singular' => __( 'payemnt record', 'tcb-subscriptions' ),
			'plural'   => __( 'payment records', 'tcb-subscriptions' ),
			'ajax'     => false,
		) );

		add_action( 'admin_head', array( $this, 'admin_header' ) );
	}

	public function admin_header() {
		$page = ( isset( $_GET['page'] ) ) ? esc_attr( $_GET['page'] ) : false;
		if ( 'payment-history' !== $page ) {
			return;
		}
	}

	public function no_items() {
		esc_html_e( 'No payment record found.', 'core-functions' );
	}

	public function column_default( $item, $column_name ) {
		switch ( $column_name ) {
			case 'student_name':
				return $item['student_name'];
			case 'internship_duration':
				return $item['internship_duration'];
			case 'amount_paid':
				return $item['amount_paid'];
			case 'author':
				return $item['author'];
			case 'published_date':
				return $item['published_date'];
			default:
				return print_r( $item, true ); //Show the whole array for troubleshooting purposes
		}
	}

	public function get_sortable_columns() {
		$sortable_columns = array(
			'published_date' => array( 'published_date', false ),
			'student_name'   => array( 'student_name', false ),
		);

		return $sortable_columns;
	}

	public function get_columns() {
		$columns = array(
			'cb'                  => '<input type="checkbox" />',
			'author'              => __( 'Author', 'core-functions' ),
			'published_date'      => __( 'Record Added Date', 'core-functions' ),
			'student_name'        => __( 'Student Name', 'core-functions' ),
			'internship_duration' => __( 'Internship Duration', 'core-functions' ),
			'amount_paid'         => __( 'Amount Paid', 'core-functions' ),
		);

		return $columns;
	}

	public function payment_history_usort_reorder( $a, $b ) {
		// If no sort, default to title
		$orderby = ( ! empty( $_GET['orderby'] ) ) ? $_GET['orderby'] : 'published_date';
		// If no order, default to asc
		$order = ( ! empty( $_GET['order'] ) ) ? $_GET['order'] : 'desc';
		// Determine sort order
		$result = strcmp( $a[ $orderby ], $b[ $orderby ] );

		// Send final sort direction to usort
		return ( $order === 'asc' ) ? $result : - $result;
	}

	public function column_cb( $item ) {
		return sprintf(
			'<input type="checkbox" name="book[]" value="%s" />', ( ! empty( $item['ID'] ) ) ? $item['ID'] : ''
		);
	}

	public function prepare_items() {
		$payment_history_table_columns = $this->get_columns();
		$hidden                        = array();
		$sortable                      = $this->get_sortable_columns();
		$this->_column_headers         = array( $payment_history_table_columns, $hidden, $sortable );
		$payment_history_table_data    = array();

		$per_page     = $this->get_items_per_page( 'payment_history_data_per_page', 20 );
		$current_page = $this->get_pagenum();
		$payments_obj = cf_get_learning_lounge_logs( get_current_user_id() );
		$payments     = $payments_obj->posts;
		$total_items  = count( $payments );

		foreach ( $payments as $log_id ) {
			$log_post            = get_post( $log_id );
			$internship_duration = get_field( 'internship_duration', $log_id );
			$course_opted        = get_field( 'course_opted', $log_id );
			$internship_data     = sprintf( __( '%1$s%2$sCourse Opted: %3$s', 'core-functions' ), $internship_duration, '<br />', $course_opted );
			$amount_paid         = '???' . get_field( 'amount_paid', $log_id );
			$mode_of_payment     = get_field( 'mode_of_payment', $log_id );
			$bank_name           = get_field( 'name_of_the_bank', $log_id );
			$payment_date        = gmdate( 'F j, Y', strtotime( get_field( 'payment_date', $log_id ) ) );
			$transaction_id      = get_field( 'transaction_id', $log_id );
			$amount_paid_data    = sprintf( __( '%1$s (%3$s)%2$son: %5$s%2$svia: %4$s%2$sTxn. ID: %6$s', 'core-functions' ), $amount_paid, '<br />', $mode_of_payment, $bank_name, $payment_date, $transaction_id );
			$record_added_date   = sprintf( __( '%1$s at %2$s', 'core-functions' ), gmdate( 'F j, Y', strtotime( $log_post->post_date ) ), gmdate( 'H:i A', strtotime( $log_post->post_date ) ) );
			$post_author         = $log_post->post_author;
			$post_author_data    = get_userdata( $post_author );
			$post_author_name    = $post_author_data->data->display_name;

			$payment_history_table_data[] = array(
				'author'              => $post_author_name,
				'published_date'      => $record_added_date,
				'student_name'        => get_field( 'student_name', $log_id ),
				'internship_duration' => $internship_data,
				'amount_paid'         => $amount_paid_data,
			);
		}

		usort( $payment_history_table_data, array( $this, 'payment_history_usort_reorder' ) );

		$payment_history_data = array_slice( $payment_history_table_data, ( ( $current_page - 1 ) * $per_page ), $per_page );
		$this->items          = $payment_history_data;

		$this->set_pagination_args( array(
			'total_items' => $total_items,
			'per_page'    => $per_page,
			'total_pages' => ceil( $total_items / $per_page ),
		) );

	}

}
