<?php
class ModelForum extends DAO
    {
        private static $instance ;
		public static function newInstance()
        {
            if( !self::$instance instanceof self ) {
                self::$instance = new self ;
            }
            return self::$instance ;
        }

        /**
         * Construct
         */
        function __construct()
        {
            parent::__construct();
        }
        
        
        public function getTable_Forums()
        {
            return DB_TABLE_PREFIX.'t_ddforums';
        }
        
		public function getTable_Topics()
        {
            return DB_TABLE_PREFIX.'t_ddtopics';
        }
		
		public function getTable_Replies()
        {
            return DB_TABLE_PREFIX.'t_ddreplies';
        }
        
       
        public function import($file)
        {
            $path = osc_plugin_resource($file) ;
            $sql = file_get_contents($path);

            if(! $this->dao->importSQL($sql) ){
                throw new Exception( "Error importSQL::ModelForum<br>".$file ) ;
            }
        }
                
        /**
         * Remove data and tables related to the plugin.
         */
        public function uninstall()
        {
            $this->dao->query(sprintf('DROP TABLE %s', $this->getTable_Forums()) );
			$this->dao->query(sprintf('DROP TABLE %s', $this->getTable_Topics()) );
			$this->dao->query(sprintf('DROP TABLE %s', $this->getTable_Replies()) );
       
      
        }
        
      	public function getForums()
		{
			$this->dao->select();
			$this->dao->from($this->getTable_Forums());
			$this->dao->orderBy('ddf_id');
			
			$results = $this->dao->get();
			if( !$results ) {
				return array();
			}
			
			return $results->result();
		
		}
		
		public function checkForumSlug($slug)
		{
		
			$this->dao->select('count(*) as forum');
			$this->dao->from($this->getTable_Forums()); 
			$this->dao->where('ddf_slug', $slug);
			
			$result = $this->dao->get();
            if($result == false) {
                return 0;
            }
            $checkSlug = $result->row();
            return $checkSlug['forum'];
		}
		
		public function getlastTopic()
		{
		
			$this->dao->select();
			$this->dao->from($this->getTable_Topics());
			
			$result = $this->dao->insertedId();
			return $result;
		}
		
		public function countTopics($forum)
		{
		
			$this->dao->select('count(*) as topic');
			$this->dao->from($this->getTable_Topics()); 
			$this->dao->where('ddf_fkid', $forum);
			
			$result = $this->dao->get();
            if($result == false) {
                return 0;
            }
            $total_topics = $result->row();
            return $total_topics['topic'];
		}
		
		public function topicPaginate($id){
			$this->dao->select('count(*) as count');
			$this->dao->from($this->getTable_Topics());
			$this->dao->where('ddf_fkid', $id );
			$result = $this->dao->get()->row();
			$total_records = $result['count'];
			$total_pages = ceil($total_records / TOTALITEMS);
			return $total_pages;
			
		}
		
		public function countReplies($topic)
		{
		$this->dao->select('count(*) as reply');
		$this->dao->from($this->getTable_Replies());
		$this->dao->where('ddt_fkid', $topic);
		
		$result = $this->dao->get();
		if($result == false) {
			return 0;
		}
		$total_posts = $result->row();
		return $total_posts['reply'];
		
		}
		
		public function getTopicById($id)
		{
			$this->dao->select();
			$this->dao->from($this->getTable_Topics());
			 $this->dao->where('ddt_id', $id );
			$this->dao->orderBy('ddt_id');
			 $result = $this->dao->get();
            if($result == false) {
                return array();
            }

            return $result->row();
		}
		public function getTopicByName($title)
		{
			$this->dao->select();
			$this->dao->from($this->getTable_Topics());
			 $this->dao->where('ddt_title', $title );
			$this->dao->orderBy('ddt_id');
			 $result = $this->dao->get();
            if($result == false) {
                return array();
            }

            return $result->row();
		}
		public function getForumById($id)
		{
			$this->dao->select();
			$this->dao->from($this->getTable_Forums());
			 $this->dao->where('ddf_id', $id );
			
			 $result = $this->dao->get();
            if($result == false) {
                return array();
            }

            return $result->row();
		
		}
		public function getForumByName($name)
		{
			$this->dao->select();
			$this->dao->from($this->getTable_Forums());
			 $this->dao->where('ddf_title', $name );
			
			 $result = $this->dao->get();
            if($result == false) {
                return array();
            }

            return $result->row();
		
		}
		
		public function getReplies($id, $page)
		{
			$replies_per_page = 5;
			$offset = ($page - 1) * $replies_per_page;
			
			$this->dao->select();
			$this->dao->from($this->getTable_Replies());
			$this->dao->limit($offset, $replies_per_page);
			$this->dao->where('ddt_fkid', $id );
			$this->dao->orderBy('ddr_id');
			
			$results = $this->dao->get();
			if( !$results ) {
				return array();
			}
			
			return $results->result();
		
		}
		
	
		
		public function getForumBySlug($slug)
		{
			$this->dao->select();
			$this->dao->from($this->getTable_Forums());
			$this->dao->where('ddf_slug', $slug );
			$results = $this->dao->get();
			if( !$results ) {
				return false;
			}
			
			return $results->row();
		
		}
		
		 public function getTopics($id="", $page="")
		{
			$topics_per_page = TOTALITEMS;
			$offset = ($page - 1) * $topics_per_page;
			
			$this->dao->select();
			$this->dao->from($this->getTable_Topics());
			$this->dao->limit($offset, $topics_per_page);
			$this->dao->where('ddf_fkid', $id );
			$this->dao->orderBy('ddt_last_update', 'DESC') ;
		
			$results = $this->dao->get();
			if( !$results ) {
				return array();
			}
			
			return $results->result();
		
		}
		
		public function getReplyById($id)
		{
			$this->dao->select();
			$this->dao->from($this->getTable_Replies());
			 $this->dao->where('ddr_id', $id );
			$this->dao->orderBy('ddr_id');
			
			$results = $this->dao->get();
			if( !$results ) {
				return array();
			}
			
			return $results->row();
		
		}
		
		public function lastPostByTopic($topic)
		{
			$this->dao->select();
			$this->dao->from($this->getTable_Replies());
			$this->dao->where('ddt_fkid', $topic );
			$this->dao->orderBy('ddr_date', 'DESC');
			
			$results = $this->dao->get();
			if( !$results ) {
				return array();
			}
			
			return $results->row();
		
		}
		
		public function lastTopic($forum)
		{
			$this->dao->select();
			$this->dao->from($this->getTable_Topics());
			$this->dao->where('ddf_fkid', $forum );
			$this->dao->orderBy('ddt_last_update', 'DESC');
			
			$results = $this->dao->get();
			if( !$results ) {
				return array();
			}
			
			return $results->row();
		
		}
		
		
		
		/**
         * Insert a Blog
         *
         * @param string $name 
         */
     
        public function insertForum( $title, $description, $slug)
		{
			return $this->dao->insert($this->getTable_Forums(), array('ddf_title' => $title, 'ddf_description' => $description, 'ddf_slug' => $slug, 'ddf_date' => date("Y-m-d")));
		
		}
		
		public function insertTopic( $forumid, $title, $description)
		{
			return $this->dao->insert($this->getTable_Topics(), array('ddf_fkid' => $forumid, 'ddt_title' => $title, 'ddt_description' => $description, 'ddt_slug' => slugify($title), 'ddt_views' => '0', 'ddt_locked' => '0', 'ddt_stick' => '0', 'ddt_user' => dt_forum_user(), 'ddt_date' => date("Y-m-d h:i:sa"), 'ddt_last_update' => date("Y-m-d h:i:sa")));
		
		}
		
		public function insertReply( $forumid, $topicid, $title, $description, $user)
		{
			return $this->dao->insert($this->getTable_Replies(), array('ddf_fkid' => $forumid, 'ddt_fkid' => $topicid, 'ddr_title' => $title, 'ddr_description' => $description, 'ddr_slug' => $title, 'ddr_user' => $user, 'ddr_date' => date("Y-m-d h:i:sa")));
		
		}
		
		public function updateReply( $replyId, $title, $slug, $description ) {
			$aSet = array('ddr_title' => $title, 'ddr_slug' => $slug, 'ddr_description' => $description);
			$aWhere = array('ddr_id' => $replyId);
		
			return $this->_update($this->getTable_Replies(), $aSet, $aWhere);
		 }
		 
		 public function updateForum( $id, $title, $description ) {
			$aSet = array('ddf_title' => $title, 'ddf_description' => $description);
			$aWhere = array('ddf_id' => $id);
		
			return $this->_update($this->getTable_Forums(), $aSet, $aWhere);
		 }
		 
		 public function updateTopic( $topicId, $title, $slug, $description ) {
			$aSet = array('ddt_title' => $title, 'ddt_slug' => $slug, 'ddt_description' => $description);
			$aWhere = array('ddt_id' => $topicId);
		
			return $this->_update($this->getTable_Topics(), $aSet, $aWhere);
		 }
       
       	public function updateTopicdate($topic)
	   	{
			$aSet = array('ddt_last_update' => date("Y-m-d h:i:sa"));
			$aWhere = array('ddt_id' => $topic);
			
			return $this->_update($this->getTable_topics(), $aSet, $aWhere);	
        }
		
		public function updateTopicViews($topic, $views)
	   	{
			$aSet = array('ddt_views' => $views);
			$aWhere = array('ddt_id' => $topic);
			
			return $this->_update($this->getTable_topics(), $aSet, $aWhere);	
        }
        
	
		/**
         * Delete 
         * 
         */
		  public function deleteForum( $id )
        {
            return $this->dao->delete( $this->getTable_Forums(), array('ddf_id' => $id) ) ;
        }
		
        public function deleteReply( $replyId )
        {
            return $this->dao->delete( $this->getTable_Replies(), array('ddr_id' => $replyId) ) ;
        }
		
		public function deleteTopic( $topicId )
        {
			$this->dao->delete( $this->getTable_Replies(), array('ddt_fkid' => $topicId) ) ;
            return $this->dao->delete( $this->getTable_Topics(), array('ddt_id' => $topicId) ) ;
			
        }
		
        
       
        // update
        function _update($table, $values, $where)
        {
            $this->dao->from($table) ;
            $this->dao->set($values) ;
            $this->dao->where($where) ;
            return $this->dao->update() ;
        }
		
		
    }

?>