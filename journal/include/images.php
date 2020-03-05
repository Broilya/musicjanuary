<?php
/*****************************************************************************\
+-----------------------------------------------------------------------------+
| SchoolReg                                                                   |
| Copyright (c) 2010 <www.journal.schoole.ru>                      |
| All rights reserved.                                                      |
+-----------------------------------------------------------------------------+
\*****************************************************************************/

 function CreatePhotoThumbnail($imgfile, $imgthumb, $newwidth) {
    if (function_exists('imagecreate'))
    {
        $imginfo = getimagesize( $imgfile );
        
        switch( $imginfo[2] ) {
            case 1:
                $type = IMG_GIF;
                break;
            case 2:
                $type = IMG_JPG;
                break;
            case 3:
                $type = IMG_PNG;
                break;
            case 4:
                $type = IMG_WBMP;
                break;
            default:
                return $imgfile;
        }
        
        switch( $type ) {
            case IMG_GIF:
                if (!function_exists("imagecreatefromgif")) return $imgfile;
                    $srcImage = imagecreatefromgif( $imgfile );
                break;
            case IMG_JPG:
                if (!function_exists("imagecreatefromjpeg")) return $imgfile;
                    $srcImage = imagecreatefromjpeg( $imgfile );
                break;
            case IMG_PNG:
                if(!function_exists("imagecreatefrompng")) return $imgfile;
                    $srcImage = imagecreatefrompng( $imgfile );
                break;
            case IMG_WBMP:
                if (!function_exists("imagecreatefromwbmp")) return $imgfile;
                    $srcImage = imagecreatefromwbmp( $imgfile );
                break;
            default:
                return $imgfile;
        }
        
        if ( $srcImage )
        {
            $srcWidth = $imginfo[0];
            $srcHeight = $imginfo[1];
            $ratioWidth = $srcWidth / $newwidth;
            $destWidth = $newwidth;
            $destHeight = $srcHeight / $ratioWidth;
            $destImage = imagecreatetruecolor( $destWidth, $destHeight );
            
            imagealphablending($destImage, true);
            imagealphablending($srcImage, false);
            imagecopyresized($destImage, $srcImage, 0, 0, 0, 0, $destWidth, $destHeight, $srcWidth, $srcHeight);
            
            switch( $type )
            {
                case IMG_GIF:
                    imagegif( $destImage, $imgthumb);
                    break;
                case IMG_JPG:
                    imagejpeg( $destImage, $imgthumb);
                    break;
                case IMG_PNG:
                    imagepng( $destImage, $imgthumb);
                    break;
                case IMG_WBMP:
                    imagewbmp( $destImage, $imgthumb);
                    break;
            }
            
            imagedestroy($srcImage);
            imagedestroy($destImage);
            return $imgthumb;
        } else {
            return $imgfile;
        }
    } else {
        return $imgfile;
    }
  }
  
  function CreatePhotoResize($src, $dest, $width, $height, $rgb=0xFFFFFF, $quality=75) {
   
      if (!file_exists($src)) return false;
      
      $size = getimagesize($src);
      
      if ($size === false) return false;
      
      $format = strtolower(substr($size['mime'], strpos($size['mime'], '/')+1));
      $icfunc = "imagecreatefrom" . $format;
  
      if (!function_exists($icfunc)) return false;

        $x_ratio = $width / $size[0];
        $y_ratio = $height / $size[1];

        $ratio = min($x_ratio, $y_ratio);
        $use_x_ratio = ($x_ratio == $ratio);

        $new_width = $use_x_ratio  ? $width  : floor($size[0] * $ratio);
        $new_height = !$use_x_ratio ? $height : floor($size[1] * $ratio);
        $new_left = $use_x_ratio  ? 0 : floor(($width - $new_width) / 2);
        $new_top = !$use_x_ratio ? 0 : floor(($height - $new_height) / 2);

        $isrc = $icfunc($src);
        $idest = imagecreatetruecolor($width, $height);
    
        imagefill($idest, 0, 0, $rgb);
        imagecopyresampled($idest, $isrc, $new_left, $new_top, 0, 0, 
        $new_width, $new_height, $size[0], $size[1]);
        
        imagejpeg($idest, $dest, $quality);
  
        imagedestroy($isrc);
        imagedestroy($idest);
        
        return true;
   }

   function UploadedPhotoFile($path){
      $max_width = 4000;
      $max_height = 3000;
      $max_size = 1 * 1024*1024;
      $valid_types = array("gif", "jpg", "png", "jpeg");
      
      if (isset($_FILES["uploadfile"])){
      
      if (is_uploaded_file($_FILES['uploadfile']['tmp_name'])) {
        $filename = $_FILES['uploadfile']['tmp_name'];
        $ext = substr($_FILES['uploadfile']['name'],1 + strrpos($_FILES['uploadfile']['name'], "."));
        $name = substr($_FILES['uploadfile']['name'], 0,strrpos($_FILES['uploadfile']['name'], "."));
        $name = date('ymdHsi').rand(0,999);
        
        $uploadfilename = $name.".jpg";
        $uploadfile = $path.$uploadfilename;
        $smuploadfile = $path."sm/".$uploadfilename;
        $size = GetImageSize($filename);
        
        if (filesize($filename) < $max_size) {
        if (in_array(strtolower($ext), $valid_types) && ($size) && ($size[0] < $max_width) && ($size[1] < $max_height)){
		    if (move_uploaded_file($filename, $uploadfile)){
              if (($size) && ($size[0] > 640) && ($size[1] > 480)){ 
              CreatePhotoResize($uploadfile, $uploadfile, 640, 480);
              } else {
              CreatePhotoResize($uploadfile, $uploadfile, $size[0], $size[1]);
              }
              CreatePhotoThumbnail($uploadfile, $smuploadfile, 160); 
            }
            return $uploadfilename;
          }
        }
      }
     }
   }
?>