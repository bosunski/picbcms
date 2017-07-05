<?php
  /**
   *
   */
  class catm extends Elyon_model
  {

    function __construct()
    {
      parent::__construct();
    }

    //Gets all the Categories that exists
    public function get_all_categories($col = null, $limit = null) {
      $field = ($col == null) ? '*' : $col;
      $qryAppend = ($limit == null) ? '' : 'LIMIT ' . $limit;
      $sql = 'SELECT '.$field.' FROM ' . PREFIX . 'category ' . $qryAppend;
      $res = $this->shareCon()->get_result($sql, array());
      if($res != null)
        return $res;

      return false;
    }

    public function get_all_categories_link($limit = null) {
      $categories = $this->get_all_categories($limit);
      $links = '';
      if(is_array($categories)) {
        foreach ($categories as $key => $value) {
          $cat_model = $this->theme->get_theme_model('top_category');
          $cat_model = str_replace('[@cat_name]', $value['cat_name'], $cat_model);
          $cat_model = str_replace('[@permalink]', get_option('home').'/category/'.strtolower(str_replace(' ', '-', $value['cat_name'])), $cat_model);
          $cat_posts = $this->count_cat_post($value['id']);
          $cat_posts = ($cat_posts == 0 || $cat_posts == 1) ? $cat_posts . '' : $cat_posts . '';
          $cat_model = str_replace('[@post_count]', $cat_posts, $cat_model);

          $links .= $cat_model;
        }
      }
      return ($links == '') ? 'No category available.' : $links;
    }

    public function get_category($cid, $field = null) {
      $field = ($field != null) ? $field : '*';
      $sql = 'SELECT ' . $field  . ' FROM ' . PREFIX . 'category WHERE id = ?';
      $res = $this->shareCon()->get_single_result($sql, array($cid));
      if($res != null)
        return $res;

      return false;
    }

    /* counts the nos of posts in a category */
    public function count_cat_post($cat_id) {
      $sql = 'SELECT COUNT(*) AS cat_posts FROM ' . PREFIX . 'posts WHERE post_parent= ? AND post_status= ? AND post_type= ?';
      $res = $this->shareCon()->get_single_result($sql, array($cat_id, 'publish', 'post'));
      if($res != null)
        return $res['cat_posts'];

      return false;
    }

    public function get_category_with_name($cat_name, $field = null) {
      $field = ($field != null) ? $field : '*';
      $sql = 'SELECT ' . $field  . ' FROM ' . PREFIX . 'category WHERE cat_name = ?';
      $res = $this->shareCon()->get_single_result($sql, array(str_replace('-', ' ', $cat_name)));
      if($res != null)
        return ($field == null) ? $res : $res[$field];

      return false;
    }
  }

?>
