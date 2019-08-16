<div class="forum-post-area">
<h3>Create new topic</h3>
<?php if (osc_is_admin_user_logged_in() && !osc_is_web_user_logged_in()) { ?>
<p>You are creating topic as Admin</p>
<?php } ?>
<?php if (osc_is_web_user_logged_in() || osc_is_admin_user_logged_in()){ ?>

<?php osc_redirect_to(dt_forum_topic_url('themes'));//echo dt_forum_topic_url(Params::getParam('forum'));
 ?>

<div class="form-container form-horizontal">
   	<form method="post" action="<?php echo osc_base_url(true);?>">
        <input type="hidden" name="plugin_action" value="topic_add" />
        <input type="hidden" name="forumId" value="<?php echo dt_get_forum_id();?>" />
        <div class="form-row">
            <div class="form-label"><?php _e('Title', 'forum_plugin'); ?></div>
            <div class="form-controls">
                <input type="text" name="t_title" id="t_title">
            </div>
         </div>
       <div class="form-row">
            <div class="form-label"><?php _e('Description', 'forum_plugin'); ?></div>
            <div class="form-controls desc">
                <textarea rows="10" class="t_description" id="t_description" name="t_description"></textarea>
           
            </div>
        </div>
        <div class="form-row">
            <div class="form-controls">
                <button class="btn btn-blue" type="submit"><?php _e('Publish', 'blog'); ?></button>
            </div>
        </div>
        </form>
</div>

<?php } else { echo "You must <a href=".osc_user_login_url().">login</a> to create topic";} ?>
</div>