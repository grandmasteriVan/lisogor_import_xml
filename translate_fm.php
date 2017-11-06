<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 06.11.2017
 * Time: 10:21
 */

/**
 * Class Timer
 * подсчет времени выполнения скрипта
 */

/**
 * database host
 */
//define ("host","localhost");
/**
 *
 */
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
 * Class BaseTranslate
 */
class BaseTranslate
{
    /**
     * переводим текст с помощью Яндекс.переводчик
     * @param $txt string - текст, который нам надо перевести
     * @return string - результат перевода
     */
    public function translateText($txt)
    {
        $api_key="trnsl.1.1.20170706T112229Z.752766fa973319f4.6dcbe2932c5e110da20ee3ce61c5986e7e492e7f";
        $lang="ru-uk";
        $txt=str_replace(" ","%20",$txt);
        $link="https://translate.yandex.net/api/v1.5/tr.json/translate?key=".$api_key."&text=".$txt."&lang=".$lang;
        //echo $link."<br>";
        $result=file_get_contents($link);
        $result=json_decode($result,true);
        $ukr_txt=$result['text'][0];
        //var_dump($result);
        return $ukr_txt;
    }
    /**
     * Удаляем лишние символы перед тем, как скормить строку яндексу
     * @param $txt string контент, полученный из базы данных
     * @return mixed|string - строка, которую будем скармливать яндексу
     */
    public function strip($txt)
    {
        $txt=strip_tags($txt);

        $txt=str_replace("&laquo;","",$txt);
        $txt=str_replace("&raquo;","",$txt);
        $txt=str_replace("&amp;","",$txt);
        $txt=str_replace("&nbsp;","",$txt);
        $txt=str_replace("&quot","",$txt);
        $txt=str_replace("&","",$txt);
        $txt=str_replace(";","",$txt);
        $txt=str_replace("/","",$txt);
        //$txt=nl2br($txt);
        $txt=str_replace(array('«', '»'),'',$txt);
        $txt=trim($txt);
        //$txt=addslashes($txt);

        return $txt;
    }
}

/**
 * Class GoodsTranslate
 */
class GoodsTranslate extends BaseTranslate
{
    /**
     * @return array|null
     */
    private function selectGoods()
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goods_id, goods_name, goods_url, goods_content FROM goods WHERE goods_active=1";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $goods[] = $row;
            }
        }
        else
        {
            echo "Error in SQL: $query<br>";
        }
        mysqli_close($db_connect);
        if (is_array($goods))
        {
            return $goods;
        }
        else
        {
            return null;
        }
    }

    /**
     *
     */
    public function translate()
    {
        $goods=$this->selectGoods();
        if (!is_null($goods))
        {
            foreach ($goods as $good)
            {
                $name=$good['goods_name'];
                $text=$good['goods_content'];
                $text=$this->strip($text);
                $name_ukr=$this->translateText($name);
                $text_ukr=$this->translateText($text);
                $url="http://fayni-mebli.com/".$good['goods_url'].".html";
                $file_string=$url.PHP_EOL."[goods_name_ukr]".$name_ukr."[/goods_name_ukr]".PHP_EOL.
                    "[goods_text_ukr]".$text_ukr."[/goods_text_ukr]".PHP_EOL.PHP_EOL;
                file_put_contents("goods.txt",$file_string,FILE_APPEND);
                break;
            }
        }
    }
}

$test=new GoodsTranslate();
$test->translate();