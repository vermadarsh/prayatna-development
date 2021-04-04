<?php
/**
 * This file holds the markup for exporting learning lounge log modal.
 *
 * @since   1.0.0
 * @package Core_Functions
 * @subpackage Core_Functions/admin/templates/modals
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly.
?>
<div id="cf-export-learning-lounge-log-modal" class="cf_modal">
	<div class="cf_modal-content">
		<span class="cf_close">&times;</span>
		<h3><?php esc_html_e( 'Export Logs', 'core-functions' ); ?></h3>
		<div class="cf-date-ranges">
			<div class="from">
				<label for="cf-date-from"><?php esc_html_e( 'From', 'core-functions' ); ?></label>
				<input type="date" id="cf-date-from" />
			</div>
			<div class="to">
				<label for="cf-date-to"><?php esc_html_e( 'To', 'core-functions' ); ?></label>
				<input type="date" id="cf-date-to" />
			</div>
			<div class="submit">
				<button class="button export-learning-lounge-log" type="button"><?php esc_html_e( 'Submit', 'core-functions' ); ?></button>
			</div>
		</div>
	</div>
</div>
