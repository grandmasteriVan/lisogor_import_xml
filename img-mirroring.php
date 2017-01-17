<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 13.01.17
 * Time: 11:35
 */

//define ("host","localhost");
define ("host","10.0.0.2");
/**
 * database username
 */
//define ("user", "root");
define ("user", "uh333660_mebli");
/**
 * database password
 */
//define ("pass", "");
define ("pass", "Z7A8JqUh");
/**
 * database name
 */
//define ("db", "mebli");
define ("db", "uh333660_mebli");

/**
 * Class Timer
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
        return $this->end_time-$this->start_time;
    }
}

/**
 * Class imgWorks
 */
class imgWorks
{
    /**
     * @param $article int код товара
     * @return null id товара
     * функция возвращает id по его коду на сайте
     */
    private function getIdByArticle($article)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goods_id FROM goods WHERE goods_article=$article";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $goods[] = $row;
            }
            if (is_array($goods))
            {
                foreach ($goods as $good)
                {
                    $id=$good['goods_id'];
                }
                mysqli_close($db_connect);
                return $id;
            }
            else
            {
                echo "нечего не нашли по коду товара:  $article<br>";
                mysqli_close($db_connect);
                return null;
            }

        }
        else
        {
            echo "ошибка в запросе<br>";
            mysqli_close($db_connect);
            return null;
        }
    }

    /**
     * @param $id int id товара
     * функция берет картинку превью у овара с определенным id и передает ее функции, которая ее отзеркалит
     */
    private function mirrorImgById($id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goods_pict FROM goods WHERE goods_id=$id";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $picts[] = $row;
            }
            foreach ($picts as $pict)
            {
                $pict_ext=$pict['goods_pict'];
            }
            $pict_file=$_SERVER['DOCUMENT_ROOT']."/content/goods/".$id."/$id"."_list.".$pict_ext;
            //вызываем функцию
            $this->makeMirrorPict($pict_file,$pict_file, $pict_ext);
        }
        mysqli_close($db_connect);
    }

    /**
     * @param $file string старый файл
     * @param $newFile string новый файл
     * @param $ext string расширение (формат) файла
     * функция зеркально отображает $file и записывает его как $newFile
     */
    private function makeMirrorPict($file, $newFile, $ext)
    {
        if ($ext=="jpg")
        {
            //загружаем картинку
            $source=imagecreatefromjpeg($file);
            //получаем ее размер
            $size=getimagesize($file);
            //создаем новое изображение
            $img=imagecreatetruecolor($size[0], $size[1]);
            //попиксельно переносим изображение в обратном порядке
            for ($x=0;$x<$size[0];$x++)
            {
                for ($y=0;$y<$size[1];$y++)
                {
                    $color=imagecolorat($source,$x,$y);
                    imagesetpixel($img,$size[0]-$x-1,$y,$color);
                }
            }
            imagejpeg($img,$newFile);
            //чистим память
            imagedestroy($img);
        }
        elseif ($ext=="png")
        {
            //загружаем картинку
            $source=imagecreatefrompng($file);
            //получаем ее размер
            $size=getimagesize($file);
            //создаем новое изображение
            $img=imagecreatetruecolor($size[0], $size[1]);
            //попиксельно переносим изображение в обратном порядке
            for ($x=0;$x<$size[0];$x++)
            {
                for ($y=0;$y<$size[1];$y++)
                {
                    $color=imagecolorat($source,$x,$y);
                    imagesetpixel($img,$size[0]-$x-1,$y,$color);
                }
            }
            imagepng($img,$newFile);
            //чистим память
            imagedestroy($img);
        }
        else
        {
            echo "unknown format $ext<br>";
        }

    }

    /**
     * @return array массив, содержащий котды товаров
     * читает из файла коды товаров и возвращает массив с ними
     */
    private function readListFromFile()
    {
        $handle=fopen("list.txt","r");
        while (!feof($handle))
        {
            $arr[]=fgets($handle);
        }
        if (!empty($arr))
        {
            $arr=array_unique($arr);
            return $arr;
        }
    }

    /**
     *отзеркаливает изображения полученные из списка товаров
     */
    public function mirrorImgByList()
    {
        $tovs=$this->readListFromFile();
        foreach ($tovs as $tov)
        {
            $imgId=$this->getIdByArticle($tov[0]);
            $this->mirrorImgById($imgId);
        }
    }
}

$runtime = new Timer();
$runtime->setStartTime();
$test=new imgWorks();
$test->mirrorImgByList();
$runtime->setEndTime();
echo "<br> runtime=".$runtime->getRunTime()." sec <br>";