<?php
	class Settingsm extends Elyon_model {

		function __construct(array $draftData = null) {
			parent::__construct();
    }

    public function set_option($option_name, $option_value) {
      $sql = 'UPDATE ' .PREFIX.'options SET option_value=? WHERE option_name=?';
      $res = $this->shareCon()->prepare($sql, array($option_value, $option_name));
      if($res) {
        return true;
      }
      return false;
    }
}
?>
