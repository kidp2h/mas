<?php

namespace Util;

use Core\SingletonBase;


class Image extends SingletonBase {

  public function upload($image, $folder = null) {
    $validSize = 5000000;
    $_result = (object)[];
    $pattern = "/(.*)\.(jpg|png|jpeg)/i";
    $match = preg_match($pattern, $image["name"], $matches);
    //var_dump($_FILES);
    if ($match) {
      $name = str_replace(' ', '-', $matches[1]) . time();
      $ext = $matches[2];

      $validExt = ["jpg", "jpeg", "png"];

      if (in_array($ext, $validExt) && $_FILES["image"]["size"] < $validSize && !$_FILES["image"]["error"]) {
        if ($folder) {
          $path = "app/public/resources/uploads/" . $folder . "/" . $name . ".$ext";
        } else {
          $path = "app/public/resources/uploads/" . $name . ".$ext";
        }

        $flag = move_uploaded_file($_FILES["image"]["tmp_name"], $path);

        if ($flag) {
          if ($folder) {
            $_result->image = $_ENV['BASE_URL'] . "/resources/uploads/$folder/$name.$ext";
          } else {
            $_result->image = $_ENV['BASE_URL'] . "/resources/uploads/$name.$ext";
          }
          $_result->size = number_format($_FILES["image"]["size"] / 1024 / 1024, 2) . " MB";
          $_result->name = "$name.$ext";
          $_result->status = true;
          return ($_result);
        }
      } else if ($_FILES["image"]["size"] > $validSize) {
        $_result->status = false;
        $_result->error = "File size too large !!";
        return ($_result);
      } else if ($_FILES["image"]["error"]) {
        $_result->status = false;
        $_result->error = "Invalid  file";
        return ($_result);
      } else {
        $_result->status = false;
        $_result->error = "Invalid extension file";
        return ($_result);
      }
    } else {
      $_result->status = false;
      $_result->error = "Invalid  file";
      return ($_result);
    }
  }
}
