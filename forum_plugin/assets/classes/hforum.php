<?php
/**
 * Gets the topic url
 *
 * @param $forum  in the url is needed
 * @return string
 */



function dt_forum_topic_url($forum){
	return osc_route_url('forums', array('forum'=>$forum));

}
function dt_forum_reply_url($topic){
	return osc_route_url('forums', array('forum'=>Params::getParam('forum'), 'topic'=>$topic));
}
function dt_topic_pagination(){
	$forum = ModelForum::newInstance()->getForumBySlug(Params::getParam('forum'));
	$paginate = ModelForum::newInstance()->topicPaginate($forum['ddf_id']);
	$url = osc_route_url('topic', array('forum'=>Params::getParam('forum')));
	for ($i=1; $i <= $paginate; $i++) {
		echo '<li><a href="'. osc_route_url('topic_page_multi', array('forum' => Params::getParam('forum'), 'iPage' => $i)) .'">'.$i.'</a></li>';
	}
}
function dt_forum_user(){
	if(osc_is_web_user_logged_in() && osc_is_admin_user_logged_in()){
		return osc_logged_user_id();
	} else if(!osc_is_web_user_logged_in() && osc_is_admin_user_logged_in()) {
		return  "admin";
	} else {
		return osc_logged_user_id();
	}
}
function dt_last_topic_id() {
	return ModelForum::newInstance()->getlastTopic();
}
function dt_get_forum_id() {
	$data = ModelForum::newInstance()->getForumByName(Params::getParam('forum'));
	return $data['ddf_id'];
}



?>