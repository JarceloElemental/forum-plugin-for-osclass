fdfdfddsds
<?php
function varible($param){
	return $param;
}
$data = array('name', 'age');

foreach ($data as $value) {
	echo varible($value);
}


// class forum {
// 	private $forumName;

// 	public function get_all() {
// 		$data = array('one', 'two', 'three');

// 		foreach ($data as $value) {
// 			echo $value;
// 		}
// 	}

// 	public function forum_name() {
// 		$this->forumName = 
// 	}

// }

// $data = new forum;
// echo $data->get_all();


if (Params::getParam('forum') && !Params::getParam('topic')) {
	include osc_plugin_path(osc_plugin_folder(__FILE__).'themes/default/topics.php');//osc_plugin_folder(__FILE__).'themes/default/topics.php';
} else if (Params::getParam('topic')) {
	include osc_plugin_path(osc_plugin_folder(__FILE__).'themes/default/replies.php');//
} else {
	$forums = ModelForum::newInstance()->getForums();
	include osc_plugin_path(osc_plugin_folder(__FILE__).'themes/default/main.php');//
}
?>