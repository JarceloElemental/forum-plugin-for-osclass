<h2>Forums</h2>
<?php
if(Params::getParam('del')){
	ModelForum::newInstance()->deleteForum(Params::getParam('del'));
	header('Location: index.php?page=plugins&action=renderplugin&file=forum_plugin/admin/forums.php');
}


$data = ModelForum::newInstance()->getForumById(Params::getParam('edit'));

?>
<div class="help">
	<h3>Show forum menu</h3>
	<pre>&lt;?php if(function_exists('forum_menu')) { echo forum_menu();} ?></pre>
</div>
<div class="form-horizontal">
    <div class="leftSide" style="float:left; width:500px">

    	<form method="post" action="<?php echo osc_admin_render_plugin_url(osc_plugin_path(dirname(__FILE__)) . '/index.php');?>">
   		<?php if(Params::getParam('edit')){ ?>
        <input type="hidden" name="plugin_action" value="forum_edit" />
        <input type="hidden" name="edit" value="<?php echo Params::getParam('edit'); ?>" />
        <?php } else { ?>
        <input type="hidden" name="plugin_action" value="forum_add" />
        <?php } ?>
        <div class="form-row">
            <div class="form-label"><?php _e('Title', 'forum_plugin'); ?></div>
            <div class="form-controls">
                <input type="text" value="<?php echo $data['ddf_title']; ?>" placeholder="<?php echo osc_esc_html(__('Enter title here', 'forum_plugin'));?>" name="f_title" id="f_title">
            </div>
         </div>
       <div class="form-row">
            <div class="form-label"><?php _e('Description', 'forum_plugin'); ?></div>
            <div class="form-controls desc">
                <textarea rows="10" class="f_description" id="f_description" name="f_description"><?php echo $data['ddf_description']; ?></textarea>
           
            </div>
        </div>
        <div class="form-row">
            <div class="form-controls">
                <button class="btn btn-blue" type="submit"><?php _e('Publish', 'blog'); ?></button>
            </div>
        </div>
        </form>
      
       </div><!--leftSide-->
       
        <div style="float:left; width:500px" class="rightSide">
        <table width="100%">
        	<tr>
        	<td><strong>Forum</strong></td>
            <td><strong>Action</strong></td>
            </tr>
            
            <?php $forums = ModelForum::newInstance()->getForums();
			foreach ($forums as $forum){?>
            <tr>
			<td><?php echo $forum['ddf_title']; ?></td>
            <td><a href="index.php?page=plugins&action=renderplugin&file=forum_plugin/admin/forums.php&edit=<?php echo $forum['ddf_id']; ?>">Edit</a> | <a href="index.php?page=plugins&action=renderplugin&file=forum_plugin/admin/forums.php&del=<?php echo $forum['ddf_id']; ?>">Delete</a></td>
             </tr>
			<?php }?>
           
        </table>
        	
            
            <?php $topics = ModelForum::newInstance()->getTopics();
			foreach ($topics as $topic){
			echo $forum['ddt_title'];
			}?>
        
        </div>
    	<div class="clear"></div>
        
      
        
        
        
     </div>


