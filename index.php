<?php
/**
 * @package wordbug
 * @version 0.1
 */
/*
Plugin Name: WordBug
Plugin URI: http://daithi-coombes.io
Description: Manage wordpress options for easy plugin/development
Author: Daithi Coombes
Version: 0.1
Author URI: http://daithi-coombes.io
*/

if(!class_exists('WordBug')):
	/**
	 * The main WordBug class
	 *
	 * Will display search form to search wp_options table and display
	 * the results using print_r() in preformated style.
	 */
	class WordBug{

		//@var array An array of options currently being worked on (search results)
		private $options;

		function __construct(){

			//hooks
			add_action('admin_menu', array(&$this, 'admin_menu'));

			//actions
			if(@$_REQUEST['wordbug-action']){
				$action = $_REQUEST['wordbug-action'];
				if(method_exists($this, $action))
					$this->$action();
			}
		}

		/**
		 * Action callback admin_menu.
		 * Adds the menu to the dashboard
		 */
		public function admin_menu(){
			add_submenu_page('tools.php','WordBug', 'WordBug', 'manage_options', 'wordbug', array(&$this, 'page_dashboard'));
		}

		/**
		 * The menu page for the dashboard
		 * @see WordBug::admin_menu()
		 */
		public function page_dashboard(){

			//search form
			?>
			<h3>WordBug</h3>
			<hr/>
			<form method="post">
				<input type="hidden" name="wordbug-action" value="search"/>
				<input type="text" name="keyword"/>
				<input type="submit" value="Search"/>
			</form>
			<?php
			//end search form

			//list options
			if(count($this->options)){
				print "<pre>";
				print_r($this->options);
				print "</pre>";
			}
		}

		private function search(){
			global $wpdb;
			$keyword = $wpdb->prepare( $_REQUEST['keyword'], array('%s'));

			$options = $wpdb->get_results("
				SELECT * FROM {$wpdb->options}
				WHERE option_name LIKE '$keyword%'
			");

			$this->options = $options;
		}
	}
endif;

$wordbug = new WordBug();