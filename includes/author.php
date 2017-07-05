<?php
  class Author extends User {
    function __construct() {
      parent::__construct();
    }

    public function get_other_author_post_links($pid, $uid, $limit = '*') {
      $pm = new Postm;
      $filter_array = array('post_type=' => 'post','post_author=' => $uid, 'post_status=' => 'publish', 'ID!=' => $pid);
      $posts = $pm->get_all_post_unpaged($filter_array, $limit);
      $links = '';
      if(is_array($posts)) {
      foreach ($posts as $key => $value) {
				$recent_model = $this->theme->get_theme_model('side_bar_recent_post');
				$t = Postm::create_thumb('el-contents/uploads/f_image/'.$value['f_image'], 64, 54);
				$post_thumb = (!$t || $t == '') ? get_option('home').'/el-contents/nfi.png' : $t;
				$permalink = makePermalink($value['post_date'], $value['post_name'], $value['post_type']);
				$recent_model = str_replace('[@post_title]', $value['post_title'], $recent_model);
				$recent_model = str_replace('[@post_title]', $value['post_title'], $recent_model);
				$recent_model = str_replace('[@permalink]', $permalink, $recent_model);
				$recent_model = str_replace('[@post_thumb]', $post_thumb, $recent_model);
				$recent_model = str_replace('[@post_date]', date("F d, Y", strtotime($value['post_date'])), $recent_model);

				$links .= $recent_model;
			}
      return ($links == '') ? 'No other post by this author.' : $links;
    }
    }
  }
?>
