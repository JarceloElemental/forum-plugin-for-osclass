fdfdsfdsfdffdfdfdfs
<?php

$page = (Params::getParam('iPage') != '') ? Params::getParam('iPage') : 1;
$replies = ModelForum::newInstance()->getReplies(Params::getParam('topic'), $page);

$topic = ModelForum::newInstance()->getTopicByName(Params::getParam('topic'));
$forum = ModelForum::newInstance()->getForumById(Params::getParam('forum'));

ModelForum::newInstance()->updateTopicViews(Params::getParam('topic'), $topic['ddt_views']+1);

if(osc_is_web_user_logged_in() && osc_is_admin_user_logged_in()){
	$user = osc_logged_user_id();
} else if(!osc_is_web_user_logged_in() && osc_is_admin_user_logged_in()) {
	$user = "admin";
} else {
	$user = osc_logged_user_id();
}

switch(Params::getParam("plugin_action")) {
	case("reply_add"):
		if(Params::getParam("r_description")) {
			
			ModelForum::newInstance()->insertReply( Params::getParam('forum'), Params::getParam('topic'), Params::getParam('r_title'), Params::getParam('r_description'), $user);
			ModelForum::newInstance()->updateTopicdate(Params::getParam('topic'));
				
				osc_add_flash_ok_message(__('Post created successfully', 'blog'));
				
				header('Location:index.php?page=custom&file=forum_plugin/replies.php&forum='. Params::getParam('forum')  . '&topic=' . Params::getParam('topic'));	
			
		} else {
			osc_add_flash_error_message(__('Empty Reply not allowed', 'blog'));
			header('Location:index.php?page=custom&file=forum_plugin/replies.php&forum='. Params::getParam('forum') . '&topic=' . Params::getParam('topic'));	
		} 
	break;
	case("reply_edit"):
		if(Params::getParam("r_description")) {
			ModelForum::newInstance()->updateReply( Params::getParam('reply'), Params::getParam('r_title'), Params::getParam('r_title'), Params::getParam('r_description') );
										
				osc_add_flash_ok_message(__('Post updated successfully', 'blog'));
				header('Location:index.php?page=custom&file=forum_plugin/replies.php&forum='. Params::getParam('forum')  . '&topic=' . Params::getParam('topic'));	
			
		} else {
			osc_add_flash_error_message(__('Empty Reply not allowed', 'blog'));
			header('Location:index.php?page=custom&file=forum_plugin/replies.php&forum='. Params::getParam('forum') . '&topic=' . Params::getParam('topic'));	
		} 
	break;
	case("topic_edit"):
		if(Params::getParam("r_title")) {
			ModelForum::newInstance()->updateTopic( Params::getParam('topic'), Params::getParam('r_title'), Params::getParam('r_title'), Params::getParam('r_description') );
										
				osc_add_flash_ok_message(__('Topic updated successfully', 'blog'));
				header('Location:index.php?page=custom&file=forum_plugin/replies.php&forum='. Params::getParam('forum')  . '&topic=' . Params::getParam('topic'));	
			
		} else {
			osc_add_flash_error_message(__('Empty Reply not allowed', 'blog'));
			header('Location:index.php?page=custom&file=forum_plugin/replies.php&forum='. Params::getParam('forum') . '&topic=' . Params::getParam('topic'));	
		} 
	break;
	case("topic_delete"):
		if(Params::getParam("tid")) {
			
			if (osc_is_web_user_logged_in() || osc_is_admin_user_logged_in()){
				
				if(osc_logged_user_id() == $topic['ddt_user'] || osc_is_admin_user_logged_in() ) {
					ModelForum::newInstance()->deleteTopic( Params::getParam('tid'));
					osc_add_flash_ok_message(__('Topic deleted successfully', 'blog'));
				} else {
					osc_add_flash_ok_message(__('You dont have permission to delete', 'blog'));
				}
			}
				
				header('Location:index.php?page=custom&file=forum_plugin/topics.php&forum='. Params::getParam('forum'));	
			
		} else {
			osc_add_flash_error_message(__('Somthing wrong', 'blog'));
			header('Location:index.php?page=custom&file=forum_plugin/replies.php&forum='. Params::getParam('forum') . '&topic=' . Params::getParam('topic'));	
		} 
	break;
	case("reply_delete"):
		if(Params::getParam("rid")) {
			
			if (osc_is_web_user_logged_in() || osc_is_admin_user_logged_in()){
				$reply = ModelForum::newInstance()->getReplyById(Params::getParam('rid'));
				if(osc_logged_user_id() == $reply['ddr_user'] || osc_is_admin_user_logged_in() ) {
					ModelForum::newInstance()->deleteReply( Params::getParam('rid'));
					osc_add_flash_ok_message(__('Post deleted successfully', 'blog'));
				} else {
					osc_add_flash_ok_message(__('You dont have permission to delete', 'blog'));
				}
			}
				
				header('Location:index.php?page=custom&file=forum_plugin/replies.php&forum='. Params::getParam('forum')  . '&topic=' . Params::getParam('topic'));	
			
		} else {
			osc_add_flash_error_message(__('Somthing wrong', 'blog'));
			header('Location:index.php?page=custom&file=forum_plugin/replies.php&forum='. Params::getParam('forum') . '&topic=' . Params::getParam('topic'));	
		} 
	break;
}



?>

<h2 class="forum-breadcrumb"> 
	<a href="index.php?page=custom&file=forum_plugin/view.php">Forums</a>
	 &raquo; 
	 <a href="index.php?page=custom&file=forum_plugin/topics.php&forum=<?php echo $forum['ddf_id']; ?>"><?php echo $forum['ddf_title']; ?></a>
	  &raquo; <?php echo $topic['ddt_title']; ?>
 </h2>




<table width="100%">

   <tr class="table-header-forum" bgcolor="#8294A8">
		<td><b>Author</b></td>
		<td><b>Topic: <?php echo $topic['ddt_title']; ?> Read  (<?php echo $topic['ddt_views']; ?>) times</b></td>
    </tr>
    
    <tr bgcolor="#E7EAEF">
		<td class="forum-author-name">
			<?php $user = User::newInstance()->findByPrimaryKey($topic['ddt_user']);
			 echo $user['s_name']; ?>
		 </td>
		<td class="forum-user">
			<div class="forum-ques">
				<b><a href="index.php?page=custom&file=forum_plugin/replies.php&forum=<?php echo Params::getParam('forum'); ?>&topic=<?php echo Params::getParam('topic'); ?>#"><?php echo $topic['ddt_title']; ?></a></b><br />
				<small><b>on</b> <?php echo $topic['ddt_date']; ?></small>
			</div>
			<div class="forum-ans">
				<?php echo $topic['ddt_description']; ?>
			</div>
			<div class="tool">
				<?php if(osc_logged_user_id() == $topic['ddr_user'] || osc_is_admin_user_logged_in()){ ?>
					<a href="index.php?page=custom&file=forum_plugin/edit.php&forum=<?php echo Params::getParam('forum'); ?>&topic=<?php echo Params::getParam('topic'); ?>">Edit</a> 
				
				<a href="index.php?page=custom&file=forum_plugin/replies.php&forum=<?php echo Params::getParam('forum'); ?>&topic=<?php echo Params::getParam('topic'); ?>&plugin_action=topic_delete&tid=<?php echo $topic['ddt_id']; ?>">Delete</a> 
				<?php } ?>
			</div>
		</td>
    </tr>
    
    <?php if( count($replies) > 0 ) {?>
    	<?php foreach ($replies as $reply){?>
        	
        	<tr class="form-user-post" id="msg<?php echo $reply['ddr_id']; ?>">
          
    			<td class="forum-author-name">
				<?php
					if($reply['ddr_user'] == "admin"){ echo "Admin";} else {
					$user = User::newInstance()->findByPrimaryKey($reply['ddr_user']);
					 echo $user['s_name']; }?>
				 </td>
				 
    			<td class="forum-user">
					<div class="forum-ques">
						<b>Re: <a id="<?php echo $reply['ddr_id']; ?>" href="index.php?page=custom&file=forum_plugin/replies.php&forum=<?php echo Params::getParam('forum'); ?>&topic=<?php echo Params::getParam('topic'); ?>#msg<?php echo $reply['ddr_id']; ?>"><?php echo $topic['ddt_title']; ?></a></b><br />
						 <small><b>on</b> <?php echo $reply['ddr_date']; ?></small>
					</div>
					<div class="forum-ans">
						<?php echo $reply['ddr_description']; ?>
					   
					</div>				   
    				<div class="tool">
                    <?php if(osc_logged_user_id() == $reply['ddr_user'] || osc_is_admin_user_logged_in()){ ?>
                    	<a href="index.php?page=custom&file=forum_plugin/edit.php&forum=<?php echo Params::getParam('forum'); ?>&topic=<?php echo Params::getParam('topic'); ?>&reply=<?php echo $reply['ddr_id']; ?>">Edit</a> 
                    
						<a href="index.php?page=custom&file=forum_plugin/replies.php&forum=<?php echo Params::getParam('forum'); ?>&topic=<?php echo Params::getParam('topic'); ?>&reply=<?php echo $reply['ddr_id']; ?>&plugin_action=reply_delete&rid=<?php echo $reply['ddr_id']; ?>">Delete</a> 
                    <?php } ?>
                    </div>
    			</td>
    		</tr>
        
        <?php } ?>
        
     <?php $tbl_name = ModelForum::newInstance()->getTable_Replies();
    $count = new DAO();
    $count->dao->select('COUNT(*) AS count');
    $count->dao->from($tbl_name);
    
    $result = $count->dao->get()->row();
    $total_records = $result['count'];
    $total_pages = ceil($total_records / 5); 
          
    for ($i=1; $i<=$total_pages; $i++) { ?>
               <a href='index.php?page=custom&file=forum_plugin/replies.php&forum=<?php echo Params::getParam('forum');?>&topic=<?php echo Params::getParam('topic'); ?>&iPage=<?php echo $i; ?>'><?php echo $i; ?></a> 
    <?php }  ?>
    <?php } ?>
    
    </table>
 <div class="forum-post-area">
		<h3>Reply to this topic</h3>

		<?php if (osc_is_admin_user_logged_in() && !osc_is_web_user_logged_in()) { ?>
		<p>You are creating topic as Admin</p>
		<?php } ?>
		<?php if (osc_is_web_user_logged_in() || osc_is_admin_user_logged_in()){ ?>

		<div class="form-container form-horizontal">
			<form method="post" action="<?php echo 'index.php?page=custom&file=forum_plugin/replies.php';?>">
				<input type="hidden" name="plugin_action" value="reply_add" />
				<input type="hidden" name="topic" value="<?php echo Params::getParam('topic');?>" />
				<input type="hidden" name="forum" value="<?php echo Params::getParam('forum');?>" />
				<div class="form-row">
					<div class="form-label"><?php _e('Title', 'forum_plugin'); ?></div>
					<div class="form-controls">
						<input type="text" name="r_title" id="r_title">
					</div>
				 </div>
			   <div class="form-row">
					<div class="form-label"><?php _e('Description', 'forum_plugin'); ?></div>
					<div class="form-controls desc">
						<textarea rows="10" class="r_description" id="r_description" name="r_description"></textarea>
				   
					</div>
				</div>
				<div class="form-row">
					<div class="form-controls">
						<button class="btn btn-blue" type="submit"><?php _e('Publish', 'blog'); ?></button>
					</div>
				</div>
				</form>
		</div>

		<?php } else { echo "You must <a href=".osc_user_login_url().">login</a> to reply to this topic";}

		 ?>
		
</div>
<div class="google-ads">
	google ad
</div>
