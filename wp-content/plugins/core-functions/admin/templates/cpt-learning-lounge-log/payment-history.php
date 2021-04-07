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
			'singular' => __( 'box-swap record', 'tcb-subscriptions' ),
			'plural'   => __( 'box-swap records', 'tcb-subscriptions' ),
			'ajax'     => false,
		) );

		add_action( 'admin_head', array( $this, 'admin_header' ) );

	}

	public function admin_header() {
		$page = ( isset( $_GET['page'] ) ) ? esc_attr( $_GET['page'] ) : false;
		if ( 'box-swap-tracking' != $page ) {
			return;
		}
	}

	public function no_items() {
		_e( 'No data found.' );
	}

	public function column_default( $item, $column_name ) {
		switch ( $column_name ) {
			case 'sub_id':
				return $item['sub_id'];
			case 'customer_email':
				return $item['customer_email'];
			case 'sub_item':
				return $item['sub_item'];
			case 'skipped_swap':
				return $item['skipped_swap'];
			case 'box_swap_item':
				return $item['box_swap_item'];
			case 'date_of_change':
				return $item['date_of_change'];
			default:
				return print_r( $item, true ); //Show the whole array for troubleshooting purposes
		}
	}

	public function get_sortable_columns() {
		$sortable_columns = array(
			'sub_id'         => array( 'sub_id', false ),
			'customer_email' => array( 'customer_email', false ),
			'sub_item'       => array( 'sub_item', false ),
		);

		return $sortable_columns;
	}

	public function get_columns() {
		$columns = array(
			'cb'             => '<input type="checkbox" />',
			'sub_id'         => __( 'Subscription ID', 'mylisttable' ),
			'customer_email' => __( 'Customer Email', 'mylisttable' ),
			'sub_item'       => __( 'Sub Item', 'mylisttable' ),
			'skipped_swap'   => __( 'Skipped/Swapped', 'mylisttable' ),
			'box_swap_item'  => __( 'Box Swap Item', 'mylisttable' ),
			'date_of_change' => __( 'Date of Change', 'mylisttable' ),
		);

		return $columns;
	}

	public function box_swap_usort_reorder( $a, $b ) {
		// If no sort, default to title
		$orderby = ( ! empty( $_GET['orderby'] ) ) ? $_GET['orderby'] : 'date_of_change';
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

		$box_swap_table_columns  = $this->get_columns();
		$hidden                  = array();
		$sortable                = $this->get_sortable_columns();
		$this->_column_headers   = array( $box_swap_table_columns, $hidden, $sortable );
		$subscription_table_data = array();

		$per_page      = $this->get_items_per_page( 'box_swap_data_per_page', 20 );
		$current_page  = $this->get_pagenum();
		// $subscriptions = wcs_get_subscriptions( [ 'subscriptions_per_page' => 5000 ] );
		$subscriptions = get_option( 'test_subscriptions' );
		$total_items   = count( $subscriptions );

		
		foreach ( $subscriptions as $subscription_id => $subscription_data ) {
			$subscription_table_data[ $subscription_id ]['sub_id']         = $subscription_data['sub_id'];
			$subscription_table_data[ $subscription_id ]['customer_email'] = $subscription_data['customer_email'];
			$subscription_table_data[ $subscription_id ]['sub_item']       = $subscription_data['sub_item'];
			$subscription_table_data[ $subscription_id ]['skipped_swap']   = $subscription_data['skipped_swap'];
			$subscription_table_data[ $subscription_id ]['box_swap_item']  = $subscription_data['box_swap_item'];
			$subscription_table_data[ $subscription_id ]['date_of_change'] = $subscription_data['date_of_change'];
		}

		// if ( ! empty( $subscriptions ) ) {
		// 	foreach ( $subscriptions as $subscription ) {

		// 		$sub_item_name      = 'N/A';
		// 		$skipped_swapped    = 'N/A';
		// 		$box_swap_item_name = 'N/A';

		// 		$subscription_id            = $subscription->get_id();
		// 		$subscription_data          = $subscription->get_data();
		// 		$customer_email             = $subscription_data['billing']['email'];
		// 		$subscription_items         = $subscription->get_items();
		// 		$current_user_id            = $subscription->get_user_id();
		// 		$subscription_date_modified = $subscription->get_date_modified();
		// 		$subscription_date_updated  = $subscription_date_modified->date( "m/d/Y H:i:s" );
		// 		$skip_next_shipping         = get_option( 'tcb_skip_next_shipping_' . $subscription_id, true );
		// 		if ( 'skip' === $skip_next_shipping ) {
		// 			$skipped_swapped = 'Skipped';
		// 		}

		// 		$box_swap_product_id = get_user_meta( $current_user_id, 'tcb_monthly_box_workshop_for' . $subscription_id, true );
		// 		if ( ! empty( $box_swap_product_id ) ) {
		// 			$skipped_swapped    = 'Swapped';
		// 			$box_swap_product   = wc_get_product( $box_swap_product_id );
		// 			$box_swap_item_name = $box_swap_product->get_title();
		// 		}

		// 		if ( ( 'Skipped' !== $skipped_swapped ) || ( 'Skipped' !== $skipped_swapped ) ) {
		// 			continue;
		// 		}

		// 		if ( ! empty( $subscription_items ) ) {
		// 			foreach ( $subscription_items as $subscription_item ) {
		// 				$sub_item_data = $subscription_item->get_data();
		// 				$sub_item_name = $sub_item_data['name'];
		// 			}
		// 		}

		// 		$subscription_table_data[ $subscription_id ]['sub_id']         = $subscription_id;
		// 		$subscription_table_data[ $subscription_id ]['customer_email'] = $customer_email;
		// 		$subscription_table_data[ $subscription_id ]['sub_item']       = $sub_item_name;
		// 		$subscription_table_data[ $subscription_id ]['skipped_swap']   = $skipped_swapped;
		// 		$subscription_table_data[ $subscription_id ]['box_swap_item']  = $box_swap_item_name;
		// 		$subscription_table_data[ $subscription_id ]['date_of_change'] = $subscription_date_updated;
		// 	}
		// }

		usort( $subscription_table_data, array( $this, 'box_swap_usort_reorder' ) );

		$box_swap_found_data = array_slice( $subscription_table_data, ( ( $current_page - 1 ) * $per_page ), $per_page );
		$this->items         = $box_swap_found_data;

		$this->set_pagination_args( array(
			'total_items' => $total_items,
			'per_page'    => $per_page,
			'total_pages' => ceil( $total_items / $per_page ),
		) );

	}

}
