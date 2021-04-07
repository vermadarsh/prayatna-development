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
			$payment_history_table_data[]['author']              = 'author';
			$payment_history_table_data[]['published_date']      = 'pub date';
			$payment_history_table_data[]['student_name']        = 'student name';
			$payment_history_table_data[]['internship_duration'] = 'internship duration';
			$payment_history_table_data[]['amount_paid']         = 'amt. paid';
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
