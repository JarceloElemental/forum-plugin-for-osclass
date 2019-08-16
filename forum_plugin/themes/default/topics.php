<?php include_once('header.php');
echo ModelForum::newInstance()->getlastTopic();
switch(Params::getParam("plugin_action")) {
	
}
$forum = ModelForum::newInstance()->getForumBySlug(Params::getParam('forum'));
$page = (Params::getParam('iPage') != '') ? Params::getParam('iPage') : 1;
$slug = ModelForum::newInstance()->getForumBySlug(Params::getParam('forum'));
$topics = ModelForum::newInstance()->getTopics($slug['ddf_id'], $page);?>
<table width="100%">
    <tr class="table-header-forum" bgcolor="#8294A8">
        <td><b>Topics</b></td>
        <td class="center"><b>Replies</b></td>
        <td><b>Last post</b></td>
    </tr>
	<?php if( count($topics) > 0 ) {
		foreach ($topics as $topic){
			$lastTopic = ModelForum::newInstance()->lastTopic(Params::getParam('forum'));
			$lastPost = ModelForum::newInstance()->lastPostByTopic($topic['ddt_id']);?>
            <tr class="table-body-forum">
                <td class="forum-inner-topic"><a href="<?php echo dt_forum_reply_url($topic['ddt_slug']); ?>"><?php echo $topic['ddt_title'];?></a>
                <td class="forum-topic-count"><small><?php echo ModelForum::newInstance()->countReplies($topic['ddt_id']);?> Replies <br />
                    <?php echo $topic['ddt_views'];?> Views</small></td>
                <td class="forum-topic-post">
                    <?php if( count($lastPost) != '0' ) { ?>
                        <?php  $user = User::newInstance()->findByPrimaryKey($lastPost['ddr_user']);?>
                        <b>by:</b> <?php if($lastPost['ddr_user'] == "admin"){ echo "Admin";} else { echo $user['s_name']; }?></br> <b>on</b>  <?php echo $lastPost['ddr_date'];?>
                        <?php //echo $lastPost['ddr_id'];?>
                            <br />
                    <?php } else { ?>
                        <?php  $user = User::newInstance()->findByPrimaryKey($topic['ddt_user']);?>
                        <b>by:</b> <?php if($topic['ddt_user'] == "admin"){ echo "Admin";} else { echo $user['s_name'];}?></br> <b>on</b> <?php echo $topic['ddt_date'];?> 
                          <?php //echo $topic['ddt_id'];?>
                 	<?php } ?>
                  </td>
            </tr>
	<?php } ?>
	<?php } else { echo "No topics were found!"; } ?>
</table>
 <ul class="pagination">
	<?php echo dt_topic_pagination(); ?>
 </ul>
<?php include_once('add-topic.php'); ?>
<?php include_once('header.php'); ?>