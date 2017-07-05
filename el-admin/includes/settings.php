<?php
  class Settings extends Elyon_core_controller {
    function __construct() {
      parent::__construct();
    }

    public function defView() {
      $this->settings();
    }

    public function settings() {
      $msg = ' ';
      if($_SERVER['REQUEST_METHOD'] == 'POST') {
        /* I have written this part with very little security in consideration */
        foreach ($_POST as $key => $value) {
          if(!$this->save_settings($key, $value)) {
            $msg .= getBlockquotedMsg('red', 'Setting '.$key.' cannot be ssaved, please check what your input');
            break;
          }
        }
        $msg .= getBlockquotedMsg('green', 'Settings saved Successfully!');
      }
      $props['msg'] = $msg;
      $static_vars = array('blog_email', 'blog_phone', 'blogname', 'blogdescription', 'theme', 'blog_address',
                          'home', 'twitter_link', 'facebook_link', 'rss_link', 'gplus_link', 'about_page', 'blog_address',
                          'comment_per_page', 'admin_post_per_page', 'post_per_page', 'admin-theme', 'admin_email');

			foreach ($static_vars as $key => $value) {
				$props[str_replace('-', '_', $value)] = get_option($value);
			}

      $this->theme->set_prop($props);
			$this->theme->create('/settings');
		}

    private function save_settings($option_name, $option_value) {
      if($this->cm->set_option($option_name, $option_value))
        return true;
      return false;
    }
  }
?>
