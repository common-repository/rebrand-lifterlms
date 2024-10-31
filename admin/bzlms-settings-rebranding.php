<div class="llms-wl-settings-header">
	<h3><?php _e('Rebrand LifterLMS', 'bzlms'); ?></h3>
</div>
<div class="llms-wl-settings-wlms">

	<div class="llms-wl-settings">
		<form method="post" id="form" enctype="multipart/form-data">

			<?php wp_nonce_field( 'llms_wl_nonce', 'llms_wl_nonce' ); ?>

			<div class="llms-wl-setting-tabs-content">

				<div id="llms-wl-branding" class="llms-wl-setting-tab-content active">
					<h3 class="bzlms-section-title"><?php esc_html_e('Branding', 'bzlms'); ?></h3>
					<p><?php esc_html_e('You can white label the plugin as per your requirement.', 'bzlms'); ?></p>
					<table class="form-table llms-wl-fields">
						<tbody>
							<tr valign="top">
								<th scope="row" valign="top">
									<label for="llms_wl_plugin_name"><?php esc_html_e('Plugin Name', 'bzlms'); ?></label>
								</th>
								<td>
									<input id="llms_wl_plugin_name" name="llms_wl_plugin_name" type="text" class="regular-text" value="<?php echo esc_attr($branding['plugin_name']); ?>" placeholder="" />
								</td>
							</tr>
							<tr valign="top">
								<th scope="row" valign="top">
									<label for="llms_wl_plugin_desc"><?php esc_html_e('Plugin Description', 'bzlms'); ?></label>
								</th>
								<td>
									<input id="llms_wl_plugin_desc" name="llms_wl_plugin_desc" type="text" class="regular-text" value="<?php echo esc_attr($branding['plugin_desc']); ?>"/>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row" valign="top">
									<label for="llms_wl_plugin_author"><?php esc_html_e('Developer / Agency', 'bzlms'); ?></label>
								</th>
								<td>
									<input id="llms_wl_plugin_author" name="llms_wl_plugin_author" type="text" class="regular-text" value="<?php echo esc_attr($branding['plugin_author']); ?>"/>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row" valign="top">
									<label for="llms_wl_plugin_uri"><?php esc_html_e('Website URL', 'bzlms'); ?></label>
								</th>
								<td>
									<input id="llms_wl_plugin_uri" name="llms_wl_plugin_uri" type="text" class="regular-text" value="<?php echo esc_attr($branding['plugin_uri']); ?>"/>
								</td>
							</tr>

							<tr valign="top">
								<th scope="row" valign="top">
									<label for="llms_wl_primary_color"><?php esc_html_e('Primary Color', 'bzlms'); ?></label>
								</th>
								<td>
									<input id="llms_wl_primary_color" name="llms_wl_primary_color" type="text" class="llms-wl-color-picker" value="" disabled />
									<p><a href="https://rebrandpress.com/pricing" target="_blank">Get Pro</a> to use this feature.</p>
								</td>
							</tr>
							
														
							<tr valign="top">
								<th scope="row" valign="top">
									<label for="llms_menu_icon"><?php esc_html_e('Menu Icon', 'bzlms'); ?></label>
								</th>
								<td>
									<input class="regular-text" name="llms_menu_icon" id="llms_menu_icon" type="text" value="" disabled />
									<input class="button" type="button" value="Choose Icon"/>
									<p><a href="https://rebrandpress.com/pricing" target="_blank">Get Pro</a> to use this feature.</p>
								</td>
							</tr>
							
							<tr valign="top">
								<th scope="row" valign="top">
									<label for="llms_wl_logo"><?php esc_html_e('Logo', 'bzlms'); ?></label>
								</th>
								<td>
								<?php 
									
									$default_image = plugins_url('uploads/NoImage.png', __FILE__);

								?>
									<div class="bzlms upload">
										<img data-src="<?php echo esc_attr($default_image); ?>" src="<?php echo esc_attr($default_image); ?>" />
										<div class="btns">
											<input type="hidden" name="llms_wl_logo" id="llms_wl_logo" value="<?php echo esc_attr($value);?>" />
											<button type="button" class="bzlms_upload_image_button button"><?php _e('Upload','bzlms'); ?></button>
											<button type="button" class="bzlms_remove_image_button button">&times;</button>
											<p><a href="https://rebrandpress.com/pricing" target="_blank">Get Pro</a> to use this feature.</p>
										</div>
									</div>
								</td>
							</tr>

							
						</tbody>
					</table>
				</div>
				
				<div class="llms-wl-setting-footer">
					<p class="submit">
						<input type="submit" name="llms_submit" id="llms_save_branding" class="button button-primary bzlms-save-button" value="<?php esc_html_e('Save Settings', 'bzlms'); ?>" />
					</p>
				</div>
			</div>
		</form>
	</div>
</div>
