<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 23.11.16
 * Time: 16:06
 */
define ("host","localhost");
//define ("host","10.0.0.2");
/**
 * database username
 */
define ("user", "root");
//define ("user", "uh333660_mebli");
/**
 * database password
 */
define ("pass", "");
//define ("pass", "Z7A8JqUh");
/**
 * database name
 */
define ("db", "mebli");
//define ("db", "uh333660_mebli");
/**
 * @param int $factory_id id фабрики по которой изменяем размер картинок (по умолчанию это Флеш)
 * пробегает по всем товарам заданной фабрики и проверяет размер картинок. Если высота картинки больше 700 пикселей -
 * меняет размер картинки на 700 пикселей по высоте и пропорционально 700 пикселям по ширине
 */
function resiz($factory_id=64)
{
    $db_connect=mysqli_connect(host,user,pass,db);
    $query="SELECT goods_id, goods_pict FROM goods WHERE factory_id=$factory_id";
    if ($res=mysqli_query($db_connect,$query)) {
        while ($row = mysqli_fetch_assoc($res)) {
            $goods[] = $row;
        }
        foreach ($goods as $good){
            $id=$good['goods_id'];
            $pict_ext=$good['goods_pict'];
            $old=$_SERVER['DOCUMENT_ROOT']."/content/goods/".$id."/$id"."_pict.".$pict_ext;
            $arr=getimagesize($old);
            echo "<pre>";
            print_r($arr);
            echo "</pre>";
            
			$height=$arr[1];
			echo $height;
			if ($height>=700){
				echo "Resizing<br>";
				$image = new SimpleImage();
				$image->load($old);
				$image->resizeToHeight(700);
				$image->save($old);
            //return;
			}
			else{
				echo "product $id has normal picture<br>";
			}
            //return;
        }
    }
}
$time_start = microtime(true);
resiz();
$time_end = microtime(true);
$time = $time_end - $time_start;
echo "Runtime: $time sec\n";
/**
 * Class Timer
 * замеряем время выполнения скрипта
 */
class Timer
{
    /**
     * @var время начала выпонения
     */
    private $start_time;
    /**
     * @var время конца выполнения
     */
    private $end_time;
    /**
     * встанавливаем время начала выполнения скрипта
     */
    public function setStartTime()
    {
        $this->start_time = microtime(true);
    }
    /**
     * устанавливаем время конца выполнения скрипта
     */
    public function setEndTime()
    {
        $this->end_time = microtime(true);
    }
    /**
     * @return mixed время выполения
     * возвращаем время выполнения скрипта в секундах
     */
    public function getRunTime()
    {
        return $this->start_time-$this->end_time;
    }
}
//
/**
 * Class SimpleImage
 * класс для работы с изображениями
 * from http://sanchiz.net/blog/resizing-images-with-php
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
?>
