<?php  switch(Params::getParam("plugin_action")) {
 		case("forum_add"):
			if(Params::getParam("f_title")) {
				$string = slugify(Params::getParam("f_title"));
				$count = ModelForum::newInstance()->checkForumSlug($string);
				echo $count;
				if($count == 0 ){
					$slug = $string;
				} else {
					$slug = increment_string($string); 
				}
					
					
					ModelForum::newInstance()->insertForum( Params::getParam("f_title"), Params::getParam("f_description"), slugify($slug));
					osc_add_flash_ok_message(__('Forum created successfully', 'forum_plugin'), 'admin');
    				header('Location:'.osc_admin_render_plugin_url(osc_plugin_path(dirname(__FILE__)) . '/forums.php'));	
							
			} else {
				osc_add_flash_error_message(__('Title missing', 'blog'), 'admin');
    			header('Location:'.osc_admin_render_plugin_url(osc_plugin_path(dirname(__FILE__)) . '/forums.php'));	
			}                        
		break;
		case("forum_edit"):
			if(Params::getParam("f_title")) {
				$string = slugify(Params::getParam("f_title"));
				$count = ModelForum::newInstance()->checkForumSlug($string);
				echo $count;
				if($count == 0 ){
					$slug = $string;
				} else {
					$slug = increment_string($string); 
				}
					
					
					ModelForum::newInstance()->updateForum( Params::getParam("edit"), Params::getParam("f_title"), Params::getParam("f_description"));
					osc_add_flash_ok_message(__('Forum created successfully', 'forum_plugin'), 'admin');
    				header('Location:'.osc_admin_render_plugin_url(osc_plugin_path(dirname(__FILE__)) . '/forums.php'));	
							
			} else {
				osc_add_flash_error_message(__('Title missing', 'blog'), 'admin');
    			header('Location:'.osc_admin_render_plugin_url(osc_plugin_path(dirname(__FILE__)) . '/forums.php'));	
			}                        
		break;
        case("topic_add"):
			if(Params::getParam("c_title")) {
				if(Params::getParam("c_slug") !="") { $slug = Params::getParam("c_slug");} else { $slug = Params::getParam("c_title"); }
				$checkCat = ModelBlog::newInstance()->checkCatSlug($slug);
				if( count($checkCat) > 0 ) {
					osc_add_flash_error_message(__('Slug alredy exists', 'blog'), 'admin');
    				header('Location:'.osc_admin_render_plugin_url(osc_plugin_path(dirname(__FILE__)) . '/categories.php'));
					
				} else {
					ModelBlog::newInstance()->insertCategory( Params::getParam("c_title"), blogslug($slug), Params::getParam("c_description") );
					osc_add_flash_ok_message(__('Category created successfully', 'blog'), 'admin');
    				header('Location:'.osc_admin_render_plugin_url(osc_plugin_path(dirname(__FILE__)) . '/categories.php'));	
				}
			} else {
				osc_add_flash_error_message(__('Title missing', 'blog'), 'admin');
    			header('Location:'.osc_admin_render_plugin_url(osc_plugin_path(dirname(__FILE__)) . '/categories.php'));	
			}                        
		break;
		case("post_edit"):
			if(Params::getParam("b_title")) {
				ModelBlog::newInstance()->updateBlog(Params::getParam("id"), Params::getParam("b_status"), Params::getParam("b_title"), blogslug(Params::getParam("b_slug")), Params::getParam("b_category"),  stripslashes($_REQUEST['b_description']), Params::getParam("b_meta_title"), Params::getParam("b_meta_content"), Params::getParam("b_meta_keyword"));				
				osc_add_flash_ok_message(__('Post update successfully', 'blog'), 'admin');
    			header('Location:'.osc_admin_render_plugin_url(osc_plugin_path(dirname(__FILE__)) . '/blog.php'));	
				
			} else {
				osc_add_flash_error_message(__('Title  missing', 'blog'), 'admin');
    			header('Location:'.osc_admin_render_plugin_url(osc_plugin_path(dirname(__FILE__)) . '/post.php&edit='.Params::getParam("id")));	
			}
		break;
		case("category_edit"):
			if(Params::getParam("c_title")) {
				ModelBlog::newInstance()->updateCategory(Params::getParam("cId"), Params::getParam("c_title"), blogslug(Params::getParam("c_slug")), Params::getParam("c_description"));				
				osc_add_flash_ok_message(__('Category update successfully', 'blog'), 'admin');
    			header('Location:'.osc_admin_render_plugin_url(osc_plugin_path(dirname(__FILE__)) . '/categories.php'));	
			} else {
				osc_add_flash_error_message(__('Title  missing', 'blog'), 'admin');
				header('Location:'.osc_admin_render_plugin_url(osc_plugin_path(dirname(__FILE__)) . '/categories.php&edit='.Params::getParam("cId")));
    			
			}                        
		break;
		case("forum_delete"):
			if(Params::getParam("bId") != "") {
			$del = Params::getParam("bId");
			ModelBlog::newInstance()->deleteBlog($del);
			osc_add_flash_ok_message(__('Post deleted successfully', 'blog'), 'admin');
    		header('Location:'.osc_admin_render_plugin_url(osc_plugin_path(dirname(__FILE__)) . '/blog.php'));
			}
		break;
		case("topic_delete"):
			if(Params::getParam("cId") != "") {
			$del = Params::getParam("cId");
			ModelBlog::newInstance()->deleteCategory($del);
			osc_add_flash_ok_message(__('Category deleted successfully', 'blog'), 'admin');
    		header('Location:'.osc_admin_render_plugin_url(osc_plugin_path(dirname(__FILE__)) . '/categories.php'));
			}
		break;
	} ?>