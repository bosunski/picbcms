<?php
  class Files {
    public static function upload_image($data, $target_dir) {
      //$target_dir = ABSPATH."lib_content/logo/";
      $res = '';
      $fname = clean(str_replace(' ', '_', $data["name"]));
      $target_file = $target_dir . basename($fname);
      $uploadOk = 1;
      $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

      //Check if image file is an actual image or fake image
      $check = getimagesize($data["tmp_name"]);
      if($check !== false) {
          $uploadOk = 1;
      } else {
          return "ERROR: The file you are uploading is not an image.";
          $uploadOk = 0;
      }

      if(file_exists($target_file)) {
          return "ERROR: The image you are uploading already exists.";
          $uploadOk = 0;
      }

      if($data["size"] > 2000000) {
          return "ERROR: Your image is too large.";
          $uploadOk = 0;
      }

      if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
          return "ERROR: Only JPG, JPEG, PNG & GIF files are allowed.";
          $uploadOk = 0;
      }

      if($uploadOk == 0) {
          return "ERROR: Your image was not uploaded.";
      } else {
        if(move_uploaded_file($data["tmp_name"], $target_file)) {
          return array($fname);
        } else {
          return "ERROR: There was an error uploading your image.";
        }
    }
    return $res;
  }
    public static function delete_files($dir, $extentions) {
      foreach($extentions as $key => $value) {
        $p = glob($dir.'*.'.$value);
        foreach($p as $k => $v) {
          if(basename($v) != 'sample_f_image.jpg')
            unlink($v);
        }
      }
    }

    public static function delete_file($dir, $name) {
      unlink($dir.$name);
    }
  }
?>
