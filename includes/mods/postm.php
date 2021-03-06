<?php
	class PostM extends Elyon_model {
		private $_draftData = null;
		private $_draftTpl;

		function __construct(array $draftData = null) {
			parent::__construct();
			return false;
		}




		private function _getLastPostID() {
			$sql = 'SELECT ID FROM '.PREFIX.'posts ORDER by post_date DESC LIMIT 1';
			$res = $this->shareCon()->get_single_result($sql);
			return $res['ID'];
		}


		private function _loadPost($type = 'post', $length = '0') {
			$length = $length == 0 ? '' : ' LIMIT ' . $length;
			$sql = 'SELECT * FROM '.PREFIX.'posts WHERE post_status = ? ORDER BY post_date DESC ';
			$res = $this->shareCon()->get_result($sql, array($type));
			return $res;
		}


		public function getPost($pid, $column = null, $type = 'pid') {
            $column = ($column == null) ? '*' : $column;
						$col = ($type == 'pid') ? 'ID' : 'post_name';
            $sql = 'SELECT ' .$column. ' FROM '.PREFIX.'posts WHERE post_type="post"  AND post_status="publish" AND ' . $col . ' = ? ';
						$res = isset($pid) ? $this->shareCon()->get_single_result($sql, array($pid)) : null;
            if($res != null) {
								$c = new Catm;
								$cats = $c->get_category($res['post_parent'], 'cat_name');
								$res['cat_name'] = $cats['cat_name'];
                return $res;
            }
            return false;
		}

		public function getResource($pid, $column = null, $type = 'pid') {
            $column = ($column == null) ? '*' : $column;
						$col = ($type == 'pid') ? 'ID' : 'post_name';
            $sql = 'SELECT ' .$column. ' FROM '.PREFIX.'posts WHERE post_type="post" AND post_status="publish" AND ' . $col . ' = ? ';
						//_x($sql);
						$res = isset($pid) ? $this->shareCon()->get_single_result($sql, array($pid)) : null;
            if($res != null) {
								$c = new Catm;
								$cats = $c->get_category($res['post_parent'], 'cat_name');
								$res['cat_name'] = $cats['cat_name'];
								var_dump($res);
								exit;
                return $res;
            }
            return false;
		}

		public function get_all_post($col = null, $filter_array = null, $page = null) {
			if($page == 1 || $page == null) {
				$posts = 0;
			} else {
				$posts = ($page * get_option('post_per_page')) - get_option('post_per_page');
			}
			$query_append = (empty($filter_array)) ? ' WHERE post_type="post" ' : ' WHERE ';
			$query_append_last = ' LIMIT ' . $posts . ', ' . get_option('post_per_page');
			$counter = 0;
			if(!empty($filter_array)) {
				foreach($filter_array as $c => $value) {
					$query_append .= $c .'"'. $value.'"' . ' ';
					$counter++;
					$query_append .= ($counter != count($filter_array)) ? 'AND ' : '';
				}
			}
			$sql = 'SELECT * FROM ' . PREFIX . 'posts ' . $query_append . ' ORDER BY post_date DESC' . $query_append_last;
			$res = $this->shareCon()->get_result($sql);
			if($res != null) {
				return $res;
			} else {
				return false;
			}
		}

		/* Gets recent post based on a filter and limit */
		public function get_all_post_unpaged($filter_array = array(), $limit = null) {

			$counter = 0;
			$query_append = (empty($filter_array)) ? ' WHERE post_type="post" ' : ' WHERE ';
			$query_append_last = ($limit == null) ? '' : ' LIMIT ' . $limit;
			if(!empty($filter_array)) {
				foreach($filter_array as $col => $value) {
					$query_append .= $col .'"'. $value.'"' . ' ';
					$counter++;
					$query_append .= ($counter != count($filter_array)) ? 'AND ' : '';
				}
			}
			$sql = 'SELECT * FROM ' . PREFIX . 'posts ' . $query_append . ' ORDER BY post_date DESC' . $query_append_last;
			$res = $this->shareCon()->get_result($sql);
			if($res != null) {
				return $res;
			} else {
				return false;
			}
		}

		/* Get only links of recent posts */
		public function get_recent_post_links($filter_array = array(), $limit = null) {
			$posts = $this->get_all_post_unpaged($filter_array, $limit);
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
		}
			return ($links == '') ? 'No recent post.' : $links;
		}

		public function get_author_info($uid) {	}

		public function getPostRows($col = null, $filter = null, $page = null) {
			$posts = $this->get_all_post($col, $filter, $page);
			$post_row = '';
			if(is_array($posts) && $posts != false) {
				foreach ($posts as $key => $value) {
					$post_model = $this->theme->get_theme_model('each_post');
					$post_model = str_replace('[@post_title]', $value['post_title'], $post_model);
					$permalink = makePermalink($value['post_date'], $value['post_name'], $value['post_type']);
					$post_model = str_replace('[@permalink]', $permalink, $post_model);
					$n = new Userm;$c = new Catm;
					$cat = $c->get_category($value['post_parent'], 'cat_name');
					$post_cat = '<a href="'.get_option('home').'/category/'.str_replace(' ', '-', $cat['cat_name']).'">'.$cat['cat_name'].'</a>';
					$author = $n->get_author_details($value['post_author']);
					$post_model = str_replace('[@author]', $author['link'], $post_model);
					$post_model = str_replace('[@post_cat]', $post_cat, $post_model);
					$post_model = str_replace('[@summary]', substr(strip_tags(reverse_simple_clean($value['post_content'])), 0, 800), $post_model);
					$post_model = str_replace('[@post_date]', date("F d, Y", strtotime($value['post_date'])), $post_model);
					$cmm = new Commentm;
					$comments = $cmm->count_comments($value['ID']);
					$comment_link = get_option('home') . '/'.$value['post_name'].'/#disqus_thread';
					$comments = '<a href="'.$comment_link.'"> comments</a>';
				//	$comments = ($comments == 1 || $comments == 0) ? $comments .' Comment' : $comments . ' Comments';
					$post_model = str_replace('[@comments]', $comments, $post_model);
					$thumb = Postm::create_thumb('el-contents/uploads/f_image/'.$value['f_image'], 285, 140);
					$f_image = ($value['f_image'] == '') ? '' : $thumb;
					$post_model = str_replace('[@f_image]', $f_image, $post_model);

					$post_row .= $post_model;
				}
			} else {
				$post_row = '<h1>No post found.</h1>';
			}
			return $post_row;
		}

		// I Must study this
		public static function create_thumb($img, $x, $y) {
			$imgtype = pathinfo($img, PATHINFO_EXTENSION);
			if($imgtype == 'jpg') {
				$image = imagecreatefromjpeg(ABSPATH . $img);
			} elseif($imgtype == 'png') {
				//exit($img);
				$image = imagecreatefrompng(ABSPATH . $img);
			} else {
				return false;
			}
			$name_of_image = basename($img);
			$names = explode('.', $name_of_image);
			$filename = 'el-contents/uploads/f_image/thumbs/thum-'.$x.'x'.$y.'_'.$names[0].'.png';

			$thumb_width = $x;
			$thumb_height = $y;

			$width = imagesx($image);
			$height = imagesy($image);

			$original_aspect = $width / $height;
			$thumb_aspect = $thumb_width / $thumb_height;

			if ($original_aspect >= $thumb_aspect)
			{
			   // If image is wider than thumbnail (in aspect ratio sense)
			   $new_height = $thumb_height;
			   $new_width = $width / ($height / $thumb_height);
			}
			else
			{
			   // If the thumbnail is wider than the image
			   $new_width = $thumb_width;
			   $new_height = $height / ($width / $thumb_width);
			}

			$thumb = imagecreatetruecolor( $thumb_width, $thumb_height );
			// Resize and crop
			imagecopyresampled($thumb,
			                   $image,
			                   0 - ($new_width - $thumb_width) / 2, // Center the image horizontally
			                   0 - ($new_height - $thumb_height) / 2, // Center the image vertically
			                   0, 0,
			                   $new_width, $new_height,
			                   $width, $height);
		 if($imgtype == 'jpg') {
 				imagejpeg($thumb, $filename);
 			} elseif($imgtype == 'png') {
 				imagepng($thumb, $filename);
 			}

			imagedestroy($thumb);
			return get_option('home') . '/' . $filename;
		}

		public function get_pagers($data_length, $per_page, $curr_page) {
			$each_page = ceil($data_length / $per_page);
			if($curr_page > $each_page) {

			}
			$curr_uri = explode('&', $_SERVER['REQUEST_URI']);
			$prev_page = ($curr_page <= 1) ? 0 :  $curr_page - 1;
			$prev_page = $prev_page == 0 ? '<li class="disabled"><a>&laquo;</a></li>' :
																		'<li class=""><a href="'.$curr_uri[0].'&page='. $prev_page.'">&laquo;</a></li>';
			$next_page = ($curr_page > $each_page) ? $each_page : $curr_page + 1;
			$next_page = $next_page > $each_page ? '<li class="disabled"><a>&raquo;</a></li>' :
																		'<li class=""><a href="'.$curr_uri[0].'&page='. $next_page.'">&raquo;</a></li>';

			$pagers = $prev_page;
			for($i = 1; $i <= $each_page; $i++) {
				if($i == $curr_page) {
					$pagers .= '<li class="active"><a>'.$i.'</a></li>';
				} else {
					$pagers .= '<li><a href="'.$curr_uri[0].'&page='.$i.'">'.$i.'</a></li>';
				}
			}
			$pagers .= $next_page;
			return $pagers;
		}

		/* Gets all tags based on the ID of the post */
		public function getPostTagHtml($id) {
            $html = '';
            $tags = $this->getPostTag($id);
            if($tags[0] != '') {
            	foreach($tags as $key => $tag) {
								$tag_model = $this->theme->get_theme_model('blog_tags');
								if($tag == '') {
									$html .= '';
								} else {
									$tag_model = str_replace('[@tag_link]', get_option('home').'/post/tag/'.$tag, $tag_model);
									$tag_model = str_replace('[@tag_name]', $tag, $tag_model);
									$html .= $tag_model;
								}
            	}
            }
            //var_dump($tags);
            return $html;
		}


		public function getPostTag($id) {
        $post = $this->getPost($id, 'post_tag');
        $tags = explode(',', $post['post_tag']);
        return $tags;
		}

		public function getAllPo($id) {
        $post = $this->getPost($id, 'post_tag');
        $tags = explode(',', $post['post_tag']);
        return $tags;
		}

		//This Function Handles Minimal SEO Stuffs
		public function create_seo_stuffs($type ='website', $data) {
			$seo = '';
			$home = get_option('home');
			$blogname = get_option('blogname');
			$title = $data['og_title'];
			$description = $data['og_description'];
			$url = $data['og_url'];
			if($type === 'blog') {
				$category = $data['category'];
				$date = $data['og_date'];
				$image = $data['og_image'];

$seo = <<<EOF

<meta property="og:locale" content="en_US" />
<meta property="og:type" content="article" />
<meta property="og:title" content="$title" />
<meta property="og:description" content="$description" />
<meta property="og:url" content="$url" />
<meta property="og:site_name" content="$blogname" />
<meta property="article:section" content="$category" />
<meta property="og:image" content="$image" />
<meta property="og:image:width" content="700" />
<meta property="og:image:height" content="484" />
<meta property="fb:app_id" content="635595733273356" />

<meta name="twitter:card" content="summary" />
<meta name="twitter:title" content="$title" />
<meta name="twitter:description" content="$description" />
<meta name="twitter:url" content="$url" />
<meta name="twitter:image" content="$image" />
EOF;
			} else {
$seo = <<<EOF
<meta name="description" content="$description" />
<meta name="robots" content="noodp" />
<link rel="canonical" href="$home" />
<meta property="og:locale" content="en_US" />
<meta property="og:type" content="article" />
<meta property="og:title" content="$title" />
<meta property="og:description" content="$description" />
<meta property="og:url" content="$url" />
<meta property="og:site_name" content="$blogname" />
<meta property="fb:app_id" content="635595733273356" />

<meta name="twitter:card" content="summary" />
<meta name="twitter:title" content="$title" />
<meta name="twitter:description" content="$description"/>
<meta name="twitter:url" content="$url" />
<meta name="twitter:image" content="$image" />
EOF;
			}

			return $seo;
		}

	}
?>
