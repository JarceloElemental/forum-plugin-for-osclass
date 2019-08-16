<?php
switch(Params::getParam("plugin_action")) {
	case("topic_add"):
		if(Params::getParam("t_title")) {
				ModelForum::newInstance()->insertTopic( Params::getParam("forumId"), Params::getParam("t_title"), Params::getParam("t_description"));
				osc_add_flash_ok_message(__('Topic created successfully', 'forum_plugin'));
				//header('Location:'. dt_forum_topic_url('plugins'));
				osc_redirect();
						
						
		} else {
			osc_add_flash_error_message(__('Title missing', 'forum_plugin'));
			header('Location:' . dt_forum_topic_url(Params::getParam('forum')));
		}                        
	break;
}?>