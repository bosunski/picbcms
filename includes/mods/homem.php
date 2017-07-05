<?php
	class Homem extends Elyon_Model {
		function __construct() {
			parent::__construct();
		}


		public function getSlides() {
			$dir = ABSPATH . 'el-contents/uploads/slides/';
			$extentions = array('jpg', 'jpeg', 'png', 'gif');
			$pics = array();
			foreach ($extentions as $key => $value) {
				$p = glob($dir.'*.'.$value);
					foreach($p as $k => $v) {
						list($a, $b) = explode(ABSPATH, $v);
						$pics[] = $b;
					}
			}
			$pics_html = ' ';
			usort($pics, create_function('$a, $b', 'return filemtime($b) - filemtime($a);'));
			if(!empty($pics)) {
				$c = 0;
				foreach ($pics as $key => $value) {
					$slide_model = $this->theme->get_theme_model('each_slide');
					$slide_model = str_replace('[@image]', get_option('home').'/'.$value, $slide_model);
					if($c == 0) {
						$slide_model = str_replace('[@class]', 'active', $slide_model);
					} else {
						$slide_model = str_replace('[@class]', '', $slide_model);
					}
					$pics_html .= $slide_model;
					$c++;
				}
			} else {
				$slide_model = $this->theme->get_theme_model('each_slide');
				$slide_model = str_replace('[@image]', get_option('home').'/el-contents/empty.png', $slide_model);
				$slide_model = str_replace('[@class]', 'active', $slide_model);
				$pics_html .= $slide_model;
			}
			return $pics_html;
		}

		public function get_the_most_recent_post() {
			$sql = 'SELECT * FROM '.PREFIX.'posts WHERE post_type="post" AND post_status="publish" ORDER BY post_date DESC LIMIT 1';
			$res = $this->shareCon()->get_single_result($sql, array());
			if($res != null) {
					$latest_post = $this->theme->get_theme_model('that_latest_post');
					$c = new Catm;
					$cats = $c->get_category($res['post_parent'], 'cat_name');
					$permalink = makePermalink($res['post_date'], $res['post_name'], $res['post_type']);
					//$res['cat_name'] = $cats['cat_name'];
					$latest_post = str_replace('[@post_title]', $res['post_title'], $latest_post);
					$latest_post = str_replace('[@cat_link]', get_option('home').'/category/'.str_replace(' ', '-', strtolower($cats['cat_name'])), $latest_post);
					$latest_post = str_replace('[@cat_name]', $cats['cat_name'], $latest_post);
					$latest_post = str_replace('[@summary]', substr(strip_tags(reverse_simple_clean($res['post_content'])).'...', 0, 200), $latest_post);
					$latest_post = str_replace('[@permalink]', $permalink, $latest_post);
					$latest_post = str_replace('[@post_date]', date('F d, Y', strtotime($res['post_date'])), $latest_post);
					return $latest_post;
			}
			return false;
		}

		//Get the recent posts and populates based on the selected theme model
		public static function getRecentPost($filter = null, $limit = 4) {
			$filter_array = ($filter == null) ? array('post_type=' => 'post', 'post_status=' => 'publish') : $filter;
			$p = new Postm;
			$c = new Catm;
			$posts = $p->get_all_post_unpaged($filter_array, $limit);
			$theme = Atheme::gI();

			$post = '';
			if(!empty($posts)) {
				$count = 1;
				foreach($posts as $key => $value) {
					if($count !== 1) {
						$cats = $c->get_category($value['post_parent'], 'cat_name');
						$cat = $cats['cat_name'];
						$post_data_model = $theme->get_theme_model('home_page_latest_post2');
						$permalink = makePermalink($value['post_date'], $value['post_name'], $value['post_type']);
						$post_data_model = str_replace('[@post_title]', $value['post_title'], $post_data_model);
						$post_data_model = str_replace('[@permalink]', $permalink, $post_data_model);
						$post_data_model = str_replace('[@cat_name]', $cat, $post_data_model);
						$post_data_model = str_replace('[@cat_link]', get_option('home').'/category/'.str_replace(' ', '-', strtolower($cat)), $post_data_model);
						$post_data_model = str_replace('[@post_date]', date('F d, Y', strtotime($value['post_date'])), $post_data_model);
						/* Work around for showning featured image on Home
						if($value['f_image'] == '') {
							$t = Postm::create_thumb('el-contents/empty.png', 300, 156);
						} else {
							$t = Postm::create_thumb('el-contents/uploads/f_image/'.$value['f_image'], 300, 156);
						}
						$thumb = (!$t || $t == '') ? 'el-contents/img_errror.png' : $t;
						$post_data_model = str_replace('[@f_image]', $thumb, $post_data_model);
						*/
						$post .= $post_data_model;
					}
					$count++;
				}
				$post .= '';
			} else { $post = '<h4>No recent post at the moment.</h4>';}
			return $post;
		}

		//Get the recent Audios and populates based on the selected theme model
		public static function get_recent_audios($filter = null, $limit = 4) {
			$filter_array = ($filter == null) ? array('post_type=' => 'audio', 'post_status=' => 'publish') : $filter;
			$p = new Postm;
			$c = new Catm;
			$posts = $p->get_all_post_unpaged($filter_array, $limit);
			$theme = Atheme::gI();

			$post = '';
			if(!empty($posts)) {
				$count = 1;
				foreach($posts as $key => $value) {
						$cats = $c->get_category($value['post_parent'], 'cat_name');
						$cat = $cats['cat_name'];
						$post_data_model = $theme->get_theme_model('latest_audio');
						$download_link = strip_tags(reverse_simple_clean($value['post_content']));
						$post_data_model = str_replace('[@post_title]', $value['post_title'], $post_data_model);
						$post_data_model = str_replace('[@download_link]', $download_link, $post_data_model);
						$post_data_model = str_replace('[@post_date]', date('F d, Y', strtotime($value['post_date'])), $post_data_model);
						$post .= $post_data_model;
					$count++;
				}
				$post .= '';
			} else { $post = '<h4>No recent Audio at the moment.</h4>';}
			return $post;
		}

		//Get the recent videos and populates based on the selected theme model
		public static function get_recent_videos($filter = null, $limit = 4) {
			$filter_array = ($filter == null) ? array('post_type=' => 'video', 'post_status=' => 'publish') : $filter;
			$p = new Postm;
			$c = new Catm;
			$posts = $p->get_all_post_unpaged($filter_array, $limit);
			$theme = Atheme::gI();

			$post = '';
			if(!empty($posts)) {
				$count = 1;
				foreach($posts as $key => $value) {
						//$cats = $c->get_category($value['post_parent'], 'cat_name');
						//$cat = $cats['cat_name'];
						$post_data_model = $theme->get_theme_model('latest_audio');
						$view_link = strip_tags(reverse_simple_clean($value['post_content']));
						$post_data_model = str_replace('[@post_title]', $value['post_title'], $post_data_model);
						$post_data_model = str_replace('[@download_link]', $view_link, $post_data_model);
						$post_data_model = str_replace('[@post_date]', date('F d, Y', strtotime($value['post_date'])), $post_data_model);
						$post .= $post_data_model;
					$count++;
				}
				$post .= '';
			} else { $post = '<h4>No recent Video at the moment.</h4>';}
			return $post;
		}



	}
?>
