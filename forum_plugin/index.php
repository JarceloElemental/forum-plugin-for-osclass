<?php
/*
Plugin Name: Forum for oslcass
Plugin URI: http://www.osclass.org/
Description: Forum Osclass plugin .
Version: 1.0.0
Author: fre2mansur
Author URI: http://www.osclass.com/
Short name: forum
Plugin update URI: osclass-forum
*/

include_once 'ModelForum.php';
include_once 'assets/classes/hForum.php';
include 'forumAction.php';

define('VERSION', '1.0.0');
define('TOTALITEMS', 10);
define('THEME', 'default');
/* Install Plugin */
function ddForum_install() {

	ModelForum::newInstance()->import('forum_plugin/assets/struct.sql');
}

function ddForum_add_css(){ ?>
	<link rel="stylesheet" type="text/css" href="<?php echo osc_base_url()."oc-content/plugins/forum_plugin/themes/". THEME ."/css/forum.css" ?>">
	<script src="<?php echo osc_base_url()."oc-content/plugins/forum_plugin/assets/minified/sceditor.min.js" ?>"></script>
	<script src="<?php echo osc_base_url()."oc-content/plugins/forum_plugin/assets/icons/monocons.js" ?>"></script>
	<script src="<?php echo osc_base_url()."oc-content/plugins/forum_plugin/assets/formats/bbcode.js" ?>"></script>
	<script src="<?php echo osc_base_url()."oc-content/plugins/forum_plugin/assets/formats/xhtml.js" ?>"></script>	
	<link rel="stylesheet" type="text/css" href="<?php echo osc_base_url()."oc-content/plugins/forum_plugin/default.min.css" ?>">
<?php }
osc_add_hook('header', 'ddForum_add_css');
/* Uninstall Plugin */
function ddForum_uninstall() {

	ModelForum::newInstance()->uninstall();
}

function increment_string($str, $separator = '-', $first = 1)
{
    preg_match('/(.+)'.$separator.'([0-9]+)$/', $str, $match);

    return isset($match[2]) ? $match[1].$separator.($match[2] + 1) : $str.$separator.$first;
}

function slugify($text) {
	$slug = ModelForum::newInstance()->getForumBySlug($text);
	// replace non letter or digits by -
  	$text = preg_replace('~[^\pL\d]+~u', '-', $text);
	// transliterate
  	$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
	// remove unwanted characters
  	$text = preg_replace('~[^-\w]+~', '', $text);
	// trim
  	$text = trim($text, '-');
	// remove duplicate -
  	$text = preg_replace('~-+~', '-', $text);
	// lowercase
  	$text = strtolower($text);
	if (empty($text)) {
    	return 'n-a';
  	}
	if(count($slug) == 0){
		return $text;
	} else {
	 	return $text.'-'.+1;
	 }
}
function super_page($page) {
	if($page == "24") {
		require osc_plugin_path(osc_plugin_folder(__FILE__).'themes/default/main.php');
	}
}
osc_add_hook('page_template', 'super_page');
function forum_bredcrumb(){ ?>
	<h2 class="forum-breadcrumb"> <a href="<?php echo osc_route_url('forum'); ?>">Forums</a> &raquo; <?php echo Params::getParam('forum') ?></h2>
<?php }
osc_add_hook('dt_forum_header', 'forum_bredcrumb');		

function forum_menu() { ?>
    <li><a href='<?php echo osc_route_url('forums'); ?>'>Forum</a></li>
<?php }
//osc_add_route('forum_thread', '/thread/', '/{thread}',osc_plugin_folder(__FILE__).'view.php','','custom','', '');

//osc_add_route('forum_thread','/thread/?(.*)/?','forums/{thread}',osc_plugin_folder(__FILE__).'/view.php','','custom','', 'FORUMS');


osc_add_route( 'forums', 'forums/?', 'forums', osc_plugin_folder(__FILE__).'/view.php');

//osc_add_route( 'topics', 'forums/?(.*)/?/?(.*)/?', 'forums/{forum}/{topic}', osc_plugin_folder(__FILE__).'/view.php', '','custom','topics', 'Topics');



//osc_add_route( 'topics', 'forums/?(.*)/(.*)?', 'forums/{forum}/{topic}', osc_plugin_folder(__FILE__).'/view.php');




osc_add_hook('header_menu', 'forum_menu');

osc_add_hook(osc_plugin_path(__FILE__) . '_uninstall', 'ddForum_uninstall') ;
osc_register_plugin(osc_plugin_path(__FILE__), 'ddForum_install') ;
/* Admin Menu */
osc_add_admin_menu_page(__('Dashboard', 'blog'),osc_admin_base_url(),'dash','moderator');
osc_add_admin_menu_page(__('Listing', 'blog'),osc_admin_base_url(true).'?page=items','items','moderator'); 
osc_add_admin_menu_page(__('Forum', 'forum'),osc_admin_render_plugin_url(osc_plugin_path(dirname(__FILE__)) . '/admin/forums.php'),'osc_forum','moderator');

?>