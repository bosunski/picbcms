<?php
  class Tagm extends Elyon_model {
    public function __construct() {
      parent::__construct();
    }

    public function getTag($filter_array, $column = null) {
            $column = ($column == null) ? '*' : $column;
						//$col = ($type == 'pid') ? 'ID' : 'post_name';
            $query_append = (empty($filter_array)) ? '' : ' WHERE ';
      			//$query_append_last = ' LIMIT ' . $posts . ', ' . get_option('post_per_page');
      			$counter = 0;
      			if(!empty($filter_array)) {
      				foreach($filter_array as $c => $value) {
      					$query_append .= $c .'"'. $value.'"' . ' ';
      					$counter++;
      					$query_append .= ($counter != count($filter_array)) ? 'AND ' : '';
      				}
      			}
            $sql = 'SELECT ' .$column. ' FROM '.PREFIX.'posts ' . $query_append;
            $res = $this->shareCon()->get_single_result($sql);
            if($res != null) {
                return $res;
            }
            return false;
		}

    /* Gets all tags and shuffles */
		public function getRandPostTagHtml($limit) {
						$html = ' ';
            $sql = 'SELECT post_tag FROM '.PREFIX.'posts WHERE post_type="post" AND post_status="publish" AND post_tag != ""';
            $res = $this->shareCon()->get_result($sql);
            if(!$res)
              return 'No tags available.';
            $cnt = 1;
            $n = array();
            $tags = ' ';

          //Joining all tags with comma(,)
            foreach ($res as $key => $value) {
              $tags .= $value['post_tag'];
              if($cnt != count($res))
                $tags .= ',';
              $cnt++;
            }

            $all = explode(',', $tags);
            shuffle($all);
            $nos_of_tag = 0;
            foreach($all as $key => $tag) {
              $n[$tag] = ' ';
              if($nos_of_tag == $limit)
                break;
              $nos_of_tag++;
            }

            foreach ($n as $k => $value) {
              $tag_model = $this->theme->get_theme_model('blog_tags');
              if($k == '') {
                $html .= '';
              } else {
                $tag_model = str_replace('[@tag_link]', get_option('home').'/tag/'.$k, $tag_model);
                $tag_model = str_replace('[@tag_name]', $k, $tag_model);
                $html .= $tag_model;
              }
            }
						return $html;
		}

  }
?>
