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
class imgWorks
{
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
            $pict_file=$_SERVER['DOCUMENT_ROOT']."/content/goods/.".$id."/$id"."_list.".$pict_ext;
            //вызываем функцию
            $this->makeMirrorPict($pict_file,$pict_file);
        }
        mysqli_close($db_connect);
    }
    private function makeMirrorPict($file, $newFile)
    {
        $source=imagecreatefromjpeg($file);
        $size=getimagesize($file);
        $img=imagecreatetruecolor($size[0], $size[1]);
        for ($x=0;$x<$size[0];$x++)
        {
            for ($y=0;$y<$size[1];$y++)
            {
                $color=imagecolorat($source,$x,$y);
                imagesetpixel($img,$size[0]-$x,$y,$color);
            }
        }
        imagejpeg($img,$newFile);
        imagedestroy($img);
    }

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