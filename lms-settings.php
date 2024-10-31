<?php
namespace BZ_LMS;

define('BZLMS_BASE_DIR', 	dirname(__FILE__) . '/');
define('BZLMS_PRODUCT_ID',   'RLP');
define('BZLMS_VERSION',   	'1.0');
define('BZLMS_DIR_PATH', plugin_dir_path( __DIR__ ));
define('BZ_LMS_NS','BZ_LMS');
define('BZLMS_PLUGIN_FILE', 'rebrand-lifterlms-lite/rebrand-lifterlms-lite.php');   //Main base file

class BZRebrandLifterLMSSettings {
		
		public $pageslug 	   = 'llms-rebrand';
	
		static public $rebranding = array();
		static public $redefaultData = array();
	
		public function init() { 
		
			$blog_id = get_current_blog_id();
			
			self::$redefaultData = array(
				'plugin_name'       	=> '',
				'plugin_desc'       	=> '',
				'plugin_author'     	=> '',
				'plugin_uri'        	=> '',
				
			);
        if ( is_plugin_active( 'blitz-rebrand-lifterlms-pro/blitz-rebrand-lifterlms-pro.php' ) ) {
			
			deactivate_plugins( plugin_basename(__FILE__) );
			$error_message = '<p style="font-family:-apple-system,BlinkMacSystemFont,\'Segoe UI\',Roboto,Oxygen-Sans,Ubuntu,Cantarell,\'Helvetica Neue\',sans-serif;font-size: 13px;line-height: 1.5;color:#444;">' . esc_html__( 'Plugin could not be activated, either deactivate the Lite version or Pro version', 'simplewlv' ). '</p>';
			die($error_message); 
		 
			return;
		}
			
			$this->bzlms_activation_hooks();	
		}
		
	
		
		/**
		 * Init Hooks
		*/
		public function bzlms_activation_hooks() {
		
			global $blog_id;
	
			add_filter( 'gettext', 					array($this, 'bzlms_update_label'), 20, 3 );
			add_filter( 'all_plugins', 				array($this, 'bzlms_plugin_branding'), 10, 1 );
			add_action( 'admin_menu',				array($this, 'bzlms_menu'), 100 );
			add_action( 'admin_enqueue_scripts', 	array($this, 'bzlms_adminloadStyles'));
			add_action( 'admin_init',				array($this, 'bzlms_save_settings'));			
	        add_action( 'admin_head', 				array($this, 'bzlms_branding_scripts_styles') );
	        if(is_multisite()){
				if( $blog_id == 1 ) {
					switch_to_blog($blog_id);
						add_filter('screen_settings',			array($this, 'bzlms_hide_rebrand_from_menu'), 20, 2);	
					restore_current_blog();
				}
			} else {
				add_filter('screen_settings',			array($this, 'bzlms_hide_rebrand_from_menu'), 20, 2);
			}
		}
		
	
	
	
			
		/**
		 * Add screen option to hide/show rebrand options
		*/
		public function bzlms_hide_rebrand_from_menu($lmscurrent, $screen) {

			$rebranding = $this->bzlms_get_rebranding();

			$lmscurrent .= '<fieldset class="admin_ui_menu"> <legend> Rebrand - '.$rebranding['plugin_name'].' </legend><p><a href="https://rebrandpress.com/pricing" target="_blank">Get Pro</a> to use this feature.</p>';
			
			$redirectUrl = $_SERVER['REQUEST_URI'];
			

			if($this->bzlms_getOption( 'rebrand_lms_screen_option','' )){
				
				$cartflows_screen_option = $this->bzlms_getOption( 'rebrand_lms_screen_option',''); 
				
				if($cartflows_screen_option=='show'){
					//$current .='It is showing now. ';
					$lmscurrent .= __('Hide the "','bzlms').$rebranding['plugin_name'].__(' - Rebrand" menu item?','bzlms') .$hide;
					$lmscurrent .= '<style>#adminmenu .toplevel_page_lifterlms a[href="admin.php?page=llms-rebrand"]{display:block;}</style>';
				} else {
					//$current .='It is disabling now. ';
					$lmscurrent .= __('Show the "','bzlms').$rebranding['plugin_name'].__(' - Rebrand" menu item?','bzlms') .$show;
					$lmscurrent .= '<style>#adminmenu .toplevel_page_lifterlms a[href="admin.php?page=llms-rebrand"]{display:none;}</style>';
				}		
				
			} else {
					//$current .='It is showing now. ';
					$lmscurrent .= __('Hide the "','bzlms').$rebranding['plugin_name'].__(' - Rebrand" menu item?','bzlms') .$hide;
					$lmscurrent .= '<style>#adminmenu .toplevel_page_lifterlms a[href="admin.php?page=llms-rebrand"]{display:block;}</style>';
			}	

			$lmscurrent .=' <br/><br/> </fieldset>' ;
			
			return $lmscurrent;
		}
		
		
		
				
		
		/**
		* Loads admin styles & scripts
		*/
		public function bzlms_adminloadStyles(){
			
			if(isset($_REQUEST['page'])){
				
				if($_REQUEST['page'] == $this->pageslug){
				
				    wp_register_style( 'bzlms_css', plugins_url('assets/css/bzlms-main.css', __FILE__) );
					wp_enqueue_style( 'bzlms_css' );
					
					wp_register_script( 'bzlms_js', plugins_url('assets/js/bzlms-main-settings.js', __FILE__ ), '', '', true );
					wp_enqueue_script( 'bzlms_js' );
				}
			}
		}	
		
		
		
		
	   public function bzlms_get_rebranding() {
			
			if ( ! is_array( self::$rebranding ) || empty( self::$rebranding ) ) {
				if(is_multisite()){
					switch_to_blog(1);
						self::$rebranding = get_option( 'liftlms_rebrand');
					restore_current_blog();
				} else {
					self::$rebranding = get_option( 'liftlms_rebrand');	
				}
			}

			return self::$rebranding;
		}
		
		
		
	    /**
		 * Render branding fields.
		 *
		 * @since 1.0.0
		 * @return void
		 */
		public function bzlms_render_fields() {
			
			$branding = get_option( 'liftlms_rebrand');
			include BZLMS_BASE_DIR . 'admin/bzlms-settings-rebranding.php';
		}
		
		
		
		/**
		 * Admin Menu
		*/
		public function bzlms_menu() {  
			
			global $menu, $blog_id;
			global $submenu;	
			
		    $admin_label = __('Rebrand', 'bzlms');
			$rebranding = $this->bzlms_get_rebranding();
			
			if ( current_user_can( 'manage_options' ) ) {

				$title = $admin_label;
				$cap   = 'manage_options';
				$slug  = $this->pageslug;
				$func  = array($this, 'bzlms_render');

				if( is_multisite() ) {
					if( $blog_id == 1 ) { 
						add_submenu_page( 'lifterlms', $title, $title, $cap, $slug, $func );
					}
				} else {
					add_submenu_page( 'lifterlms', $title, $title, $cap, $slug, $func );
				}
			}	
			
			//~ echo '<pre/>';
			//~ print_r($menu);
				
			foreach($menu as $custommenusK => $custommenusv ) {
				if( $custommenusK == '51.84482' ) {
					$menu[$custommenusK][0] = $rebranding['plugin_name']; //change menu Label
								
				}
			}
			return $menu;
		}
		
			
		
		/**
		 * Renders to fields
		*/
		public function bzlms_render() {	
			$this->bzlms_render_fields();
		}
		
	
		
		/**
		 * Save the field settings
		*/
		public function bzlms_save_settings() {
			
			if ( ! isset( $_POST['llms_wl_nonce'] ) || ! wp_verify_nonce( $_POST['llms_wl_nonce'], 'llms_wl_nonce' ) ) {
				return;
			}

			if ( ! isset( $_POST['llms_submit'] ) ) {
				return;
			}
			$this->bzlms_update_branding();
		}
		
		
		
		
		/**
		 * Include scripts & styles
		*/
		public function bzlms_branding_scripts_styles() {
			
			global $blog_id;
			
			if ( ! is_user_logged_in() ) {
				return; 
			}
			$rebranding = $this->bzlms_get_rebranding();
			
			echo '<style id="llms-wl-admin-style">';
			include BZLMS_BASE_DIR . 'admin/bzlms-style.css.php';
			echo '</style>';
			
			echo '<script id="llms-wl-admin-script">';
			include BZLMS_BASE_DIR . 'admin/bzlms-script.js.php';
			echo '</script>';
			
		}	  
	
	

		/**
		 * Update branding
		*/
	    public function bzlms_update_branding() {
			
			if ( ! isset($_POST['llms_wl_nonce']) ) {
				return;
			}
			

			$data = array(
				'plugin_name'       => isset( $_POST['llms_wl_plugin_name'] ) ? sanitize_text_field( $_POST['llms_wl_plugin_name'] ) : '',
				
				'plugin_desc'       => isset( $_POST['llms_wl_plugin_desc'] ) ? sanitize_text_field( $_POST['llms_wl_plugin_desc'] ) : '',
				
				'plugin_author'     => isset( $_POST['llms_wl_plugin_author'] ) ? sanitize_text_field( $_POST['llms_wl_plugin_author'] ) : '',
				
				'plugin_uri'        => isset( $_POST['llms_wl_plugin_uri'] ) ? sanitize_text_field( $_POST['llms_wl_plugin_uri'] ) : '',
				
				
								
			);

			update_option( 'liftlms_rebrand', $data );
		}
    
    
     
  
  
		
		/**
		 * change plugin meta
		*/  
        public function bzlms_plugin_branding( $all_plugins ) {
			
			
			if (  ! isset( $all_plugins['lifterlms/lifterlms.php'] ) ) {
				return $all_plugins;
			}
		
			$rebranding = $this->bzlms_get_rebranding();
			
			$all_plugins['lifterlms/lifterlms.php']['Name']           = ! empty( $rebranding['plugin_name'] )     ? $rebranding['plugin_name']      : $all_plugins['lifterlms/lifterlms.php']['Name'];
			
			$all_plugins['lifterlms/lifterlms.php']['PluginURI']      = ! empty( $rebranding['plugin_uri'] )      ? $rebranding['plugin_uri']       : $all_plugins['lifterlms/lifterlms.php']['PluginURI'];
			
			$all_plugins['lifterlms/lifterlms.php']['Description']    = ! empty( $rebranding['plugin_desc'] )     ? $rebranding['plugin_desc']      : $all_plugins['lifterlms/lifterlms.php']['Description'];
			
			$all_plugins['lifterlms/lifterlms.php']['Author']         = ! empty( $rebranding['plugin_author'] )   ? $rebranding['plugin_author']    : $all_plugins['lifterlms/lifterlms.php']['Author'];
			
			$all_plugins['lifterlms/lifterlms.php']['AuthorURI']      = ! empty( $rebranding['plugin_uri'] )      ? $rebranding['plugin_uri']       : $all_plugins['lifterlms/lifterlms.php']['AuthorURI'];
			
			$all_plugins['lifterlms/lifterlms.php']['Title']          = ! empty( $rebranding['plugin_name'] )     ? $rebranding['plugin_name']      : $all_plugins['lifterlms/lifterlms.php']['Title'];
			
			$all_plugins['lifterlms/lifterlms.php']['AuthorName']     = ! empty( $rebranding['plugin_author'] )   ? $rebranding['plugin_author']    : $all_plugins['lifterlms/lifterlms.php']['AuthorName'];
			
			return $all_plugins;
			
		}
	
    	
	
		   
		/**
		 * update plugin label
		*/
		public function bzlms_update_label( $translated_text, $untranslated_text, $domain ) {
			
			$rebranding = $this->bzlms_get_rebranding();
			
			$bzlms_new_text = $translated_text;
			$bzlms_name = isset( $rebranding['plugin_name'] ) && ! empty( $rebranding['plugin_name'] ) ? $rebranding['plugin_name'] : '';
			
			if ( ! empty( $bzlms_name ) ) {
				$bzlms_new_text = str_replace( 'LifterLMS', $bzlms_name, $bzlms_new_text );
			}
			
			return $bzlms_new_text;
		}
	
	
	
		
		   
		/**
		 * update options
		*/
		public function bzlms_updateOption($key,$value) {
			if(is_multisite()){
				return  update_site_option($key,$value);
			}else{
				return update_option($key,$value);
			}
		}
		
		
	
		
		   
		/**
		 * get options
		*/	
		public function bzlms_getOption($key,$default=False) {
			if(is_multisite()){
				switch_to_blog(1);
				$value = get_site_option($key,$default);
				restore_current_blog();
			}else{
				$value = get_option($key,$default);
			}
			return $value;
		}
		
	
} //end Class
