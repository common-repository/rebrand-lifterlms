jQuery(document).ready(function() {
	
	jQuery('.llms-wl-setting-tabs').on('click', '.llms-wl-tab', function(e) {
		e.preventDefault();
		var id = jQuery(this).attr('href');
		jQuery(this).siblings().removeClass('active');
		jQuery(this).addClass('active');
		jQuery('.llms-wl-setting-tabs-content .llms-wl-setting-tab-content').removeClass('active');
		jQuery('.llms-wl-setting-tabs-content').find(id).addClass('active');
	});

});
 
