<?php $reply = ModelForum::newInstance()->getReplyById(Params::getParam('reply'));
$topic = ModelForum::newInstance()->getTopicById(Params::getParam('topic'));
$forum = ModelForum::newInstance()->getForumById(Params::getParam('forum')); ?>

<h2 class="forum-breadcrumb"> <a href="index.php?page=custom&file=forum_plugin/view.php">Forums</a> &raquo; <a href="index.php?page=custom&file=forum_plugin/topics.php&forum=<?php echo $forum['ddf_id']; ?>"><?php echo $forum['ddf_title']; ?></a> &raquo; Modify message (<?php echo $topic['ddt_title']; ?>)</h2>
<div class="forum-edit">
<?php if (osc_is_web_user_logged_in() || osc_is_admin_user_logged_in()){ ?>
<?php if(osc_logged_user_id() == $reply['ddr_user'] || osc_is_admin_user_logged_in() ) { ?>

<?php if (osc_is_admin_user_logged_in()){ echo "<p>You are editing as forum admin</p>"; } ?>

<h3>Edit <?php if (Params::getParam('reply')) { ?> Reply to <?php } ?> this topic</h3>
<?php if (Params::getParam('reply')) { 
$title = $reply['ddr_title'];
$description = $reply['ddr_description'];
 } else {
$title = $topic['ddt_title'];
$description = $topic['ddt_description'];
}
  ?>
</div>
<div class="forum-post-area">
<div class="form-container form-horizontal">
   	<form method="post" action="<?php echo 'index.php?page=custom&file=forum_plugin/replies.php';?>">
    	<?php if (Params::getParam('reply')) { ?>
        <input type="hidden" name="plugin_action" value="reply_edit" />
        <input type="hidden" name="reply" value="<?php echo Params::getParam('reply');?>" />
        <?php } else { ?>
        <input type="hidden" name="plugin_action" value="topic_edit" />
        <?php } ?>
        <input type="hidden" name="topic" value="<?php echo Params::getParam('topic');?>" />
		<input type="hidden" name="forum" value="<?php echo Params::getParam('forum');?>" />
        <div class="form-row">
            <div class="form-label"><?php _e('Title', 'forum_plugin'); ?></div>
            <div class="form-controls">
                <input type="text" name="r_title" id="r_title" value="<?php echo $title; ?>">
            </div>
         </div>
       <div class="form-row">
            <div class="form-label"><?php _e('Description', 'forum_plugin'); ?></div>
            <div class="form-controls desc">
                <textarea rows="10" class="r_description" id="r_description" name="r_description"><?php echo $description; ?></textarea>
           
            </div>
        </div>
        <div class="form-row">
            <div class="form-controls">
                <button class="btn btn-blue" type="submit"><?php _e('Publish', 'blog'); ?></button>
            </div>
        </div>
        </form>
</div>
<?php } else { echo "you dont have permission to do that"; } ?>
<?php } else { header('Location:'. osc_user_login_url());}

 ?>
 </div>
 <div class="google-ads">
 google ads
 </div>
 <div class="clearfix"></div>
<script>
			var textarea = document.getElementById('r_description');
			sceditor.create(textarea, {
				format: 'bbcode',
				icons: 'monocons',
				style: 'default.min.css'
			});

		</script>