<?php
  class catm extends Elyon_model
  {

    function __construct()
    {
      parent::__construct();
    }

    public function getPicRows($data) {
      if(!is_array($data) || empty($data)) {
        return 'No Images Uploaded Yet';
      }
      $pic_row = '';
      foreach ($data as $key => $value) {
        list($a, $value) = explode(ABSPATH, $value);
        $type = pathinfo(basename($value), PATHINFO_EXTENSION);
        $title = str_replace('.'.$type, '', $value);
        list($c, $d) = explode('___', $title);
        $name = ($a == '') ? $title : $a;
        $description = ($b == '') ? $title : $b;
        $pic_row . = '<a class="gallery-item" href="'.get_option('home').'/'.$value.'" title="'.$name.'" data-gallery="">
            <div class="image">
                <img src="'.get_option('home').'/'.$value.'" alt="'.$name.'">
                <ul class="gallery-item-controls">
                    <li><label class="check"><div style="position: relative;" class="icheckbox_minimal-grey"><input style="position: absolute; opacity: 0;" class="icheckbox" type="checkbox"><ins style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; border: 0px none; opacity: 0;" class="iCheck-helper"></ins></div></label></li>
                    <li><span class="gallery-item-remove"><i class="fa fa-times"></i></span></li>
                </ul>
            </div>
            <div class="meta">
                <strong>'.$name.'</strong>
                <span>'.$description.'</span>
            </div>
        </a>'
      }
    }
  }
?>
