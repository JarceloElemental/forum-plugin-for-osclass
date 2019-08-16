<?php 

$results = ModelForum::newInstance()->searchForum(Params::getParam('fquery'));

//foreach($results as $result){
	echo $results['ddt_title'];
//}
?>