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

//CropEmpty('IMG_1430_23809.jpg', __DIR__ . '/IMG_1430_23809-1.jpg');
}
$test=new FixImgDDN();
$test->CropEmpty('IMG_1430_23809.jpg', __DIR__ . '/IMG_1430_23809-1.jpg');