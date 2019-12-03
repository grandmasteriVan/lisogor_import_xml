<?php
class FixImgDDN
{
    function CropEmpty($src, $dst) 
    {
        $image = imagecreatefromstring(file_get_contents($src));
        imagealphablending($image, false);
        imagesavealpha($image, true);

        $width = imagesx($image);
        $height = imagesy($image);

        //Находим верхнюю крайнюю точку
        for ($top = 0; $top < $height; $top++) {
            for ($x = 0; $x < $width; $x++) {
                if (imagecolorat($image, $x, $top)) {
                    break 2;
                }
            }
        }

        //Находим нижнюю крайнюю точку
        for ($bottom = 0; $bottom < $height; $bottom++) {
            for ($x = 0; $x < $width; $x++) {
                if (imagecolorat($image, $x, $height - $bottom - 1)) {
                    break 2;
                }
            }
        }

        //Находим крайнюю левую точку
        for ($left = 0; $left < $width; $left++) {
            for ($y = 0; $y < $height; $y++) {
                if (imagecolorat($image, $left, $y)) {
                    break 2;
                }
            }
        }

        //Находим крайнюю правую точку
        for ($right = 0; $right < $width; $right++) {
            for ($y = 0; $y < $height; $y++) {
                if (imagecolorat($image, $width - $right - 1, $y)) {
                    break 2;
                }
            }
        }

        #region newImage

        $newWidth = $width - ($left + $right);
        $newHeight = $height - ($top + $bottom);
        $newImage = imagecreatetruecolor($newWidth, $newHeight);
        imagealphablending($newImage, false);
        imagesavealpha($newImage, true);
        imagefilledrectangle($newImage, 0, 0, $newWidth, $newHeight, imagecolorallocatealpha($newImage, 255, 255, 255, 127));
        imagecopy($newImage, $image, 0, 0, $left, $top, $newWidth, $newHeight);
        imagepng($newImage, $dst);
        imagedestroy($newImage);

        #endregion

        imagedestroy($image);
    }

    function img_resize_real($src, $dest, $width, $height, $rgb=0xFFFFFF, $quality=100)
    {
        if (!file_exists($src)) return false;
 
        $size = getimagesize($src);
 
        if ($size === false) return false;
 
        // Определяем исходный формат по MIME-информации, предоставленной
        // функцией getimagesize, и выбираем соответствующую формату
        // imagecreatefrom-функцию.
        $format = strtolower(substr($size['mime'], strpos($size['mime'], '/')+1));
        $icfunc = "imagecreatefrom" . $format;
        if (!function_exists($icfunc)) return false;
 
        /* alg */
        $src_w = intval($size[0]);
        $src_h = intval($size[1]);
        $set_w = abs(intval($width));
        $set_h = abs(intval($height));
        $src_x = $src_y = 0;
 
        if ($set_w == 0 && $set_h == 0) { $set_w = $src_w; $set_h = $src_h; }
        if ($set_w > 0 && $set_h == 0)  { $set_h = ceil($src_h*$set_w/$src_w); }
        if ($set_h > 0 && $set_w == 0)  { $set_w = ceil($src_w*$set_h/$src_h); }
        $prc_w = ceil($src_w*$set_h/$src_h);
        $prc_h = ceil($src_h*$set_w/$src_w);
        if ($prc_h >= $set_h)
        {
            $out_w = $set_w; $out_h = $prc_h;
        }
        else
        {
            $out_w = $prc_w; $out_h = $set_h;
        }
        if ($out_w > $set_w)
        {
            $xw = ceil($set_w*$src_h/$set_h);
            $src_x = ceil(($src_w-$xw)/2);
        }
        if ($out_h > $set_h)
        {
            $xh = ceil($set_h*$src_w/$set_w);
            $src_y = ceil(($src_h-$xh)/2);
        }
 
        if ($out_w > $set_w || $out_h > $set_h)
        {
            if ($out_w > $set_w)
            {
                $h = ceil($out_h*$set_w/$out_w); $w = $set_w;
            }
            if ($out_h > $set_h)
            {
                $w = ceil($out_w*$set_h/$out_h); $h = $set_h;
            }
        }
        else
        {
            $w = $out_w; $h = $out_h;
        }
        $src_x = $src_y = 0;
        $set_w = $out_w = $w;
        $set_h = $out_h = $h;
        /* alg */
 
 
 
        // Создаем новое изображение
        $idest = imagecreatetruecolor($set_w, $set_h);
        $isrc = $icfunc($src);
 
        // Копируем существующее изображение в новое с изменением размера:
        imagecopyresampled(
        $idest,  // Идентификатор нового изображения
        $isrc,  // Идентификатор исходного изображения
        0,0,      // Координаты (x,y) верхнего левого угла
        // в новом изображении
        $src_x,$src_y, // Координаты (x,y) верхнего левого угла копируемого
        // блока существующего изображения
        $out_w,     // Новая ширина копируемого блока
        $out_h,     // Новая высота копируемого блока
        $size[0], // Ширина исходного копируемого блока
        $size[1]  // Высота исходного копируемого блока
        );
 
        imagejpeg($idest, $dest, $quality);
 
        imagedestroy($isrc);
        imagedestroy($idest);
 
        return array('width' => $out_w, 'height'=> $out_h);
 
    }

//CropEmpty('IMG_1430_23809.jpg', __DIR__ . '/IMG_1430_23809-1.jpg');
}
$test=new FixImgDDN();
$test->CropEmpty('IMG_1430_23809.jpg', __DIR__ . '/IMG_1430_23809-1.jpg');