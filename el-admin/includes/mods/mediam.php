<?php
  class Mediam extends Elyon_model
  {

    function __construct() {
      parent::__construct();
    }

    public function getPicRows($data) {
      if(!is_array($data) || empty($data)) {
        return '<h1>No Images Uploaded Yet.</h1>';
      }
      $pic_row = '';
      foreach ($data as $key => $value) {
        list($a, $value) = explode(ABSPATH, $value);
        $type = pathinfo(basename($value), PATHINFO_EXTENSION);
        $title = basename(str_replace('.'.$type, '', $value));
        //list($c, $d) = explode('___', $title);
        $name = $title;
        $description = $title;
        $pic_row  .= '<a class="gallery-item" href="'.get_option('home').'/'.$value.'" title="'.$name.'" data-gallery="">
            <div class="image">
                <img src="'.get_option('home').'/'.$value.'" alt="'.$name.'">
                <ul class="gallery-item-controls">
                    <li><label class="check"><div style="position: relative;" class="icheckbox_minimal-grey">
                    <input style="position: absolute; opacity: 0;" name="images[]" value="'.$value.'" class="icheckbox" type="checkbox"></div></label></li>
                    <li><span id="'.$value.'" class="gallery-item-remove"><i  class="fa fa-times"></i></span></li>
                </ul>
            </div>
            <div class="meta">
                <strong>'.$name.'</strong>
                <span>'.$description.'</span>
            </div>
        </a>';
      }
      return $pic_row;
    }
  }
?>
