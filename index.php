<?php

/*

Plugin Name: Shortcode Poll

Plugin URI: http://blogwordpress.ws/plugin-shortcode-poll

Description: Plugin to add polls on posts and pages just adding a shortcode in that.

Author: Anderson Makiyama

Version: 0.2

Author URI: http://blogwordpress.ws

*/





class Anderson_Makiyama_Shortcode_Poll{

	const CLASS_NAME = 'Anderson_Makiyama_Shortcode_Poll';

	public static $CLASS_NAME = self::CLASS_NAME;

	const PLUGIN_ID = 7;

	public static $PLUGIN_ID = self::PLUGIN_ID;

	const PLUGIN_NAME = 'Shortcode Poll';

	public static $PLUGIN_NAME = self::PLUGIN_NAME;

	const PLUGIN_PAGE = 'http://blogwordpress.ws/plugin-shortcode-poll';

	public static $PLUGIN_PAGE = self::PLUGIN_PAGE;

	const PLUGIN_VERSION = '0.2';

	public static $PLUGIN_VERSION = self::PLUGIN_VERSION;

	public $plugin_slug = "anderson_makiyama_";

	public $plugin_base_name;

	

    public function getStaticVar($var) {

        return self::$$var;

    }	

	

	public function __construct(){

		$this->plugin_base_name = plugin_basename(__FILE__);

		$this->plugin_slug.= strtolower(str_replace(" ","_",self::PLUGIN_NAME));

		load_plugin_textdomain( self::CLASS_NAME, '', strtolower(str_replace(" ","-",self::PLUGIN_NAME)) . '/lang' );	

		

	}

	

	public function settings_link($links) { 

	  $settings_link = '<a href="options-general.php?page='. strtolower(str_replace(" ","-",self::PLUGIN_NAME)) .'/index.php">'. __('Settings', self::CLASS_NAME). '</a>'; 

	  array_unshift($links, $settings_link); 

	  return $links; 

	}

	

	public function options(){

		global $anderson_makiyama;

		global $user_level;

		get_currentuserinfo();

		if ($user_level < 10) {

			return;

		}



		  if (function_exists('add_options_page')) {

			add_options_page(__(self::PLUGIN_NAME), __(self::PLUGIN_NAME), 1, __FILE__, array(self::CLASS_NAME,'options_page'));

		  }

		

	}	

	

	public function options_page(){

		global $anderson_makiyama;

		global $user_level;

		get_currentuserinfo();

		if ($user_level < 10) {

			return;

		}

		

		$options = get_option($anderson_makiyama[self::PLUGIN_ID]->plugin_slug."_options");

		

		if ($_POST['submit']) {

			$options['title'] = $_POST['title'];

			

			update_option($anderson_makiyama[self::PLUGIN_ID]->plugin_slug."_options", $options);

			 echo '<div class="updated"><p>' . __('Options saved', self::CLASS_NAME) . '</p></div>';

		}

				

		

		include("templates/options.php");

	}	

	public static function get_max($atts=array(),$content=""){

		global $post, $anderson_makiyama;

		
		$options = get_option($anderson_makiyama[self::PLUGIN_ID]->plugin_slug."_" . $post->ID);

		$max = max($options);
		
		$keys = array_keys($options, $max);
		
		$tops = implode(" / ",$keys);

		return $tops;

		
	}

	public static function show_poll($atts=array(),$content=""){

		global $post, $anderson_makiyama;

		

		$options = get_option($anderson_makiyama[self::PLUGIN_ID]->plugin_slug."_" . $post->ID);

		$new_options = array();

		if(!empty($atts)){

			foreach($atts as $key=>$value){

				if(!isset($options[$value])) $options[$value] = 0;

				if(!array_key_exists($value,$options)) continue;

				

				$new_options[$value] = $options[$value];

			}

		}

		

		update_option($anderson_makiyama[self::PLUGIN_ID]->plugin_slug."_" . $post->ID, $new_options);

		

		$options = get_option($anderson_makiyama[self::PLUGIN_ID]->plugin_slug."_" . $post->ID);

		

		$url = site_url() . '/wp-content/plugins/shortcode-poll/post-form.php?p='.$post->ID;

		return "<iframe src='$url' frameborder='0' class='sourceView' noresize='noresize' style='height:350px;width:100%;z-index:10;-webkit-box-sizing: border-box;'></iframe>";

	}	

	

	public function is_checked($place){

		global $anderson_makiyama;



		$options = get_option($anderson_makiyama[self::PLUGIN_ID]->plugin_slug."_options");

		$places_ = $options[$anderson_makiyama[self::PLUGIN_ID]->plugin_slug."_places"];

		

		if(is_array($places_) && in_array($place,$places_)) return " checked='checked' ";

		

		return "";

		

	}	

	

	public static function makeData($data, $anoConta,$mesConta,$diaConta){

	   $ano = substr($data,0,4);

	   $mes = substr($data,5,2);

	   $dia = substr($data,8,2);

	   return date('Y-m-d',mktime (0, 0, 0, $mes+($mesConta), $dia+($diaConta), $ano+($anoConta)));	

	}

	

	public static function get_data_array($data,$part=''){

	   $data_ = array();

	   $data_["ano"] = substr($data,0,4);

	   $data_["mes"] = substr($data,5,2);

	   $data_["dia"] = substr($data,8,2);

	   if(empty($part))return $data_;

	   return $data_[$part];

	}	

	

	public static function is_selected($campo, $varCampo){

		if($campo==$varCampo) return " selected=selected ";

		return "";

	}	

}

if(!isset($anderson_makiyama)) $anderson_makiyama = array();

$anderson_makiyama_indice = Anderson_Makiyama_Shortcode_Poll::PLUGIN_ID;

$anderson_makiyama[$anderson_makiyama_indice] = new Anderson_Makiyama_Shortcode_Poll();

add_filter("admin_menu", array($anderson_makiyama[$anderson_makiyama_indice]->getStaticVar('CLASS_NAME'), 'options'),30);



add_filter("plugin_action_links_". $anderson_makiyama[$anderson_makiyama_indice]->plugin_base_name, array($anderson_makiyama[$anderson_makiyama_indice]->getStaticVar('CLASS_NAME'), 'settings_link') );

add_shortcode('show_poll',array($anderson_makiyama[$anderson_makiyama_indice]->getStaticVar('CLASS_NAME'), 'show_poll'));

add_shortcode('get_max_voted',array($anderson_makiyama[$anderson_makiyama_indice]->getStaticVar('CLASS_NAME'), 'get_max'));

?>