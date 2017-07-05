<?php
	class Post extends Elyon_model {
		private $_draftData = null;
		private $_draftTpl;

		function __construct(array $draftData = null) {
			parent::__construct();
			$this->_draftData = $draftData;
			if($draftData != null) {
				$guid = $this->_getGuid();
				$this->_draftTpl = 'INSERT INTO '.PREFIX.'posts VALUES (
					null, :author, NOW(), :now_zero, :post_content, 
					:post_title, :post_excerpt, :pstatus, 
					:comment_status, :ping_status, :post_password, 
					:post_name, :to_ping, :pinged, NOW(), NOW(), :post_content_filtered, :post_parent,
					:guid, :menu_order, :post_type, :post_mime_type, :comment_count)';
				$this->_defParam = array(
					':author' => '', ':now_zero' => '0000-00-00 00:00:00', ':post_content' => '', 
					':post_title' => '', ':post_excerpt' => '', ':pstatus' => '', 
					':comment_status' => '', ':ping_status' => '' , ':post_password' => '' , 
					':post_name' => '' , ':to_ping' => '' , ':pinged' => '' , ':post_content_filtered' => '' , ':post_parent' => 0,
					':guid' => $guid , ':menu_order' => '' , ':post_type' => '' , ':post_mime_type' => '' , ':comment_count' => '' );
				$this->_draftData = array_merge($this->_defParam, $draftData);
				$this->_createDraft();
			}
			
		}

		private function _createDraft() {
			$d = $this->shareCon()->prepare($this->_draftTpl, $this->_draftData);
			if($d) {
				_e('done');
			}
		}

		private function _getLastPostID() {
			$sql = 'SELECT ID FROM '.PREFIX.'posts ORDER by post_date DESC LIMIT 1';
			$res = $this->shareCon()->get_single_result($sql);
			return $res['ID'];
		}

		private function _getGuid() {
			$last_id = $this->_getLastPostID();
			$last_id++;
			$guid = get_option('home').'/?p='.$last_id;
			return $guid;
		}
	}
?>