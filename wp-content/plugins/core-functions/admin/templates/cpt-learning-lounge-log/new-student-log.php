<?php
/**
 * This file holds the markup for adding new learning lounge log by the student.
 *
 * @since   1.0.0
 * @package Core_Functions
 * @subpackage Core_Functions/admin/templates/cpt-learning-lounge-log
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly.
?>
<div class="wrap">
	<h1>Hello</h1>
	<?php
		if( function_exists('acf_add_local_field_group') ):

			acf_add_local_field_group(array(
				'key' => 'group_60697752da345',
				'title' => 'Post Type - Learning Lounge Log',
				'fields' => array(
					array(
						'key' => 'field_606977658b7ce',
						'label' => 'Student Name',
						'name' => 'student_name',
						'type' => 'text',
						'instructions' => 'Provide the student name here.',
						'required' => 1,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '33',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_6069777d8b7cf',
						'label' => 'Internship Duration',
						'name' => 'internship_duration',
						'type' => 'text',
						'instructions' => 'How long would the internship go?',
						'required' => 1,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '33',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_606ad0fc2070b',
						'label' => 'Course Opted',
						'name' => 'course_opted',
						'type' => 'text',
						'instructions' => 'Which course did you opt?',
						'required' => 1,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '33',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_606977948b7d0',
						'label' => 'Amount Paid',
						'name' => 'amount_paid',
						'type' => 'number',
						'instructions' => 'How much did the student pay?',
						'required' => 1,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '25',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'min' => '',
						'max' => '',
						'step' => '0.01',
					),
					array(
						'key' => 'field_606acfaa9ed47',
						'label' => 'Mode of Payment',
						'name' => 'mode_of_payment',
						'type' => 'select',
						'instructions' => 'How was the payment made?',
						'required' => 1,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '25',
							'class' => '',
							'id' => '',
						),
						'choices' => array(
							'online' => 'Online',
							'cheque' => 'Cheque',
						),
						'default_value' => false,
						'allow_null' => 0,
						'multiple' => 0,
						'ui' => 0,
						'return_format' => 'value',
						'ajax' => 0,
						'placeholder' => '',
					),
					array(
						'key' => 'field_606ad01e9ed49',
						'label' => 'Payment Date',
						'name' => 'payment_date',
						'type' => 'date_picker',
						'instructions' => 'When was the payment done?',
						'required' => 1,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '25',
							'class' => '',
							'id' => '',
						),
						'display_format' => 'Y-m-d',
						'return_format' => 'Y-m-d',
						'first_day' => 1,
					),
					array(
						'key' => 'field_606acff89ed48',
						'label' => 'Name of the Bank',
						'name' => 'name_of_the_bank',
						'type' => 'text',
						'instructions' => 'From which bank was the payment initiated?',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '25',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_606ad0479ed4a',
						'label' => 'Transaction ID',
						'name' => 'transaction_id',
						'type' => 'text',
						'instructions' => 'Put in the transaction ID for verification purposes.',
						'required' => 1,
						'conditional_logic' => array(
							array(
								array(
									'field' => 'field_606acfaa9ed47',
									'operator' => '==',
									'value' => 'online',
								),
							),
						),
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
				),
				'location' => array(
					array(
						array(
							'param' => 'post_type',
							'operator' => '==',
							'value' => 'learning-lounge-log',
						),
					),
				),
				'menu_order' => 0,
				'position' => 'normal',
				'style' => 'default',
				'label_placement' => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen' => '',
				'active' => true,
				'description' => '',
			));
			
			endif;
	?>
</div>
