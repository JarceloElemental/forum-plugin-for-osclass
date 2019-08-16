<?php include_once('header.php');?>
<ul>
  <table width="100%">
    <tr class="table-header-forum" bgcolor="#8294A8">
    <td><b>Forum</b></td>
    <td class="center"><b>Topics</b></td>
    <td><b>Last post</b></td>
    </tr>
 
<?php
if( count($forums) > 0 ) {
	foreach ($forums as $forum){?>
  		
        <?php  $lastTopic = ModelForum::newInstance()->lastTopic($forum['ddf_id']);?>
        <?php  $lastPost = ModelForum::newInstance()->lastPostByTopic($lastTopic['ddt_id']);?>
        
    	<tr class="table-body-forum">
        <!--index.php?page=custom&file=forum_plugin/topics.php&forum=<?php //echo $forum['ddf_id'];?>-->
    		<td class="forum-topic-info"><a href="<?php echo dt_forum_topic_url($forum['ddf_slug']); ?>"><?php echo $forum['ddf_title'];?></a>
    			<p><?php echo $forum['ddf_description'];?></p>
            </td>
            
    		<td class="forum-topic-count"><?php echo ModelForum::newInstance()->countTopics($forum['ddf_id']);?></td>
            
            <td class="forum-topic-post">
            	<?php if( count($lastPost) != '0' ) { ?>
                	<?php  $user = User::newInstance()->findByPrimaryKey($lastPost['ddr_user']);?>
            		<b>by:</b> <?php if($lastPost['ddr_user'] == "admin"){ echo "Admin";} else { echo $user['s_name'];}?></br> <b>on</b>  <?php echo $lastPost['ddr_date'];?>
                	<?php //echo $lastPost['ddr_id'];?>
						<br />
                <?php } else if( count($lastTopic) != '0' ) { ?>
                	<?php  $user = User::newInstance()->findByPrimaryKey($lastTopic['ddt_user']);?>
                    <b>by:</b> <?php if($lastTopic['ddt_user'] == "admin"){ echo "Admin";} else { echo $user['s_name'];}?></br> <b>on</b> <?php echo $lastTopic['ddt_date'];?> 
                      <?php //echo $lastTopic['ddt_id'];?>
                <?php } else { ?>
                      No topics.   
                <?php } ?>
                </td>
         
        
               
            <?php //} ?>
    	</tr>
	<?php }
	 } else { echo "No topics were found!";
 }?>

    </table>
</ul>
<?php include_once('footer.php');?>