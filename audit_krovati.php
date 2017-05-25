<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 10.04.17
 * Time: 15:58
 *
 * во первых - меняет размеры у слишком больших картинок
 * во вторых - удаляет лишние фильтры
 * в третих - копирует фильтры родительского товара всем его дочерним товарам
 * (при этом ставить фильтр Тип кровати в соответствии с размером спального места)
 */


class SimpleImage {
    /**
     * @var
     */
    var $image;
    /**
     * @var
     */
    var $image_type;
    /**
     * @param $filename
     */
    function load($filename) {
        $image_info = getimagesize($filename);
        $this->image_type = $image_info[2];
        if( $this->image_type == IMAGETYPE_JPEG ) {
            $this->image = imagecreatefromjpeg($filename);
        } elseif( $this->image_type == IMAGETYPE_GIF ) {
            $this->image = imagecreatefromgif($filename);
        } elseif( $this->image_type == IMAGETYPE_PNG ) {
            $this->image = imagecreatefrompng($filename);
        }
    }
    /**
     * @param $filename
     * @param int $image_type
     * @param int $compression
     * @param null $permissions
     */
    function save($filename, $image_type=IMAGETYPE_JPEG, $compression=75, $permissions=null) {
        if( $image_type == IMAGETYPE_JPEG ) {
            imagejpeg($this->image,$filename,$compression);
        } elseif( $image_type == IMAGETYPE_GIF ) {
            imagegif($this->image,$filename);
        } elseif( $image_type == IMAGETYPE_PNG ) {
            imagepng($this->image,$filename);
        }
        if( $permissions != null) {
            chmod($filename,$permissions);
        }
    }
    /**
     * @param int $image_type
     */
    function output($image_type=IMAGETYPE_JPEG) {
        if( $image_type == IMAGETYPE_JPEG ) {
            imagejpeg($this->image);
        } elseif( $image_type == IMAGETYPE_GIF ) {
            imagegif($this->image);
        } elseif( $image_type == IMAGETYPE_PNG ) {
            imagepng($this->image);
        }
    }
    /**
     * @return int
     */
    function getWidth() {
        return imagesx($this->image);
    }
    /**
     * @return int
     */
    function getHeight() {
        return imagesy($this->image);
    }
    /**
     * @param $height
     */
    function resizeToHeight($height) {
        $ratio = $height / $this->getHeight();
        $width = $this->getWidth() * $ratio;
        $this->resize($width,$height);
    }
    /**
     * @param $width
     */
    function resizeToWidth($width) {
        $ratio = $width / $this->getWidth();
        $height = $this->getheight() * $ratio;
        $this->resize($width,$height);
    }
    /**
     * @param $scale
     */
    function scale($scale) {
        $width = $this->getWidth() * $scale/100;
        $height = $this->getheight() * $scale/100;
        $this->resize($width,$height);
    }
    /**
     * @param $width
     * @param $height
     */
    function resize($width, $height) {
        $new_image = imagecreatetruecolor($width, $height);
        imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
        $this->image = $new_image;
    }
}

/**
 * Class Image
 */
class Image
{
    /**
     * @param $tcharter int id каталога, где меняем размер картинок
     * @param $height_max int максимальный размер картинки? свыше которого будем уменьшать картинку
     * пробегает по всем товарам заданной фабрики и проверяет размер картинок. Если высота картинки больше $height_old пикселей -
     * меняет размер картинки на $height_old пикселей по высоте и пропорционально $height_old пикселям по ширине
     */
    function resiz($tcharter, $height_max=600)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goods_id, goods_pict FROM goods WHERE goods_maintcharter=$tcharter";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $goods[] = $row;
            }
            foreach ($goods as $good){
                $id=$good['goods_id'];
                $pict_ext=$good['goods_pict'];
                $old=$_SERVER['DOCUMENT_ROOT']."/content/goods/".$id."/$id"."_pict.".$pict_ext;
                $arr=getimagesize($old);
                /*echo "<pre>";
                print_r($arr);
                echo "</pre>";*/

                $height=$arr[1];
                //echo $height;
                if ($height>$height_max)
                {
                    echo "Resizing $id<br>";
                    $image = new SimpleImage();
                    $image->load($old);
                    $image->resizeToHeight($height_max);
                    $image->save($old);
                    //return;
                }
                else
                {
                    echo "product $id has normal picture<br>";
                }
                //return;
            }
        }
        else
        {
            echo "Error in sql: $query<br>";
        }
    }
}

class Filters
{

}