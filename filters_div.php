<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 04.10.16
 * Time: 10:55
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
function set_filters()
{
    $db_connect=mysqli_connect(host,user,pass,db);
    //выбираем все диваны
    $query="SELECT * FROM goods WHERE goods_maintcharter=1";
    if ($res=mysqli_query($db_connect,$query))
    {
        while ($row = mysqli_fetch_assoc($res))
        {
            $divs[] = $row;
        }
        foreach ($divs as $div)
        {
            $id=$div['id'];
            $kind=$div['goodskind_id'];
            $name=$div['goods_name'];
            $cont=$div['goods_content'];
            //тип дивана
            //сначала ужаляем все записи из фильтра, кроме кушеток и тахты
            $query="DELETE FROM goodshasfeature WHERE goods_id=$id AND future_id=2 AND (goodshasfeature_valueint<>14 OR goodshasfeature_valueint<>3)";
            mysqli_query($db_connect,$query);
            echo "$query<br>";
            //прямой
            if ($kind==23)
            {
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueint, goodshasfeature_valuefloat, ".
                    "goodshasfeature_valuetext, goods_id, feature_id) ".
                    "VALUES (11,0,'',$id,2)";
                mysqli_query($db_connect,$query);
                echo "$query<br>";
            }
            //угловой
            if ($kind==26)
            {
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueint, goodshasfeature_valuefloat, ".
                    "goodshasfeature_valuetext, goods_id, feature_id) ".
                    "VALUES (13,0,'',$id,2)";
                mysqli_query($db_connect,$query);
                echo "$query<br>";
            }
            //модульный
            if (mb_strpos($name ,UTF8toCP1251("модульный"))||(mb_stripos($cont,UTF8toCP1251("модул"))))
            {
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueint, goodshasfeature_valuefloat, ".
                    "goodshasfeature_valuetext, goods_id, feature_id) ".
                    "VALUES (12,0,'',$id,2)";
                mysqli_query($db_connect,$query);
                echo "$query<br>";
            }
            //размер
            $width=$div['goods_width'];
            $length=$div['goods_length'];
            //большие
            if ($length>=2000||$width>=2000)
            {
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueint, goodshasfeature_valuefloat, ".
                    "goodshasfeature_valuetext, goods_id, feature_id) ".
                    "VALUES (10,0,'',$id,155)";
                mysqli_query($db_connect,$query);
                echo "$query<br>";
            }
            //маленькие
            if ($length<=800)
            {
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueint, goodshasfeature_valuefloat, ".
                    "goodshasfeature_valuetext, goods_id, feature_id) ".
                    "VALUES (11,0,'',$id,155)";
                mysqli_query($db_connect,$query);
                echo "$query<br>";
            }
            //По назначению
            $factory_id=$div['factory_id'];
            //изначально считаем диван не ортопедическим и не для сна
            $sleep=true;
            $ortop=false;
            //пружинный блок+ламели фича=4 айди=6
            $query="SELECT * FROM goodshasfeature WHERE feature_id=4 AND goods_id=$id AND goodshasfeature_valueint=6";
            if ($res=mysqli_query($db_connect,$query))
            {
                unset($arr);
                while ($row=mysqli_fetch_assoc($res))
                {
                    $arr[]=$row;
                }
                if (is_array($arr))
                {
                    $ortop=true;
                }
            }
            //если фабрика == укризра или у нас есть запись ламели+пружинный блок - диван ортопедический
            if ($factory_id==52||$ortop)
            {
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueint, goodshasfeature_valuefloat, ".
                    "goodshasfeature_valuetext, goods_id, feature_id) ".
                    "VALUES (3,0,'',$id,147)";
                mysqli_query($db_connect,$query);
                echo "ортопедический: $query<br>";
            }
            //для ежедневного сна
            $query="SELECT * FROM goodshasfeature WHERE feature_id=3 AND goods_id=$id AND goodshasfeature_valueint=7";
            if ($res=mysqli_query($db_connect,$query))
            {
                unset($arr);
                while ($row = mysqli_fetch_assoc($res))
                {
                    $arr[] = $row;
                }
                if (is_array($arr))
                {
                    $sleep = false;
                }
            }
            if ($sleep)
            {
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueint, goodshasfeature_valuefloat, ".
                    "goodshasfeature_valuetext, goods_id, feature_id) ".
                    "VALUES (34,0,'',$id,147)";
                mysqli_query($db_connect,$query);
                echo "для ежедневнгого сна: $query<br>";
            }

            //трансформация
            //выбираем диваны, у которых вид трансформации - не раскладывется
            $query="SELECT * FROM goodshasfeature WHERE goods_id=$id AND feature_id=3 AND goodshasfeature_valueint=9";
            if ($res=mysqli_query($db_connect,$query))
            {
                unset($arr);
                while ($row = mysqli_fetch_assoc($res))
                {
                    $arr[] = $row;
                }
                //массив не пуст - значит диван не раскладывается
                if (is_array($arr))
                {
                    $query = "INSERT INTO goodshasfeature (goodshasfeature_valueint, goodshasfeature_valuefloat, " .
                        "goodshasfeature_valuetext, goods_id, feature_id) " .
                        "VALUES (13,0,'',$id,157)";
                    mysqli_query($db_connect, $query);
                    echo "Не раскладные: $query<br>";
                    //удаляем запись в механизмах
                    $query = "DELETE FROM goodshasfeature WHERE goods_id=$id AND feature_id=3 AND goodshasfeature_valueint=9";
                    mysqli_query($db_connect, $query);
                } //массив пуст - значит раскладывется
                else
                {
                    $query = "INSERT INTO goodshasfeature (goodshasfeature_valueint, goodshasfeature_valuefloat, " .
                        "goodshasfeature_valuetext, goods_id, feature_id) " .
                        "VALUES (12,0,'',$id,157)";
                    mysqli_query($db_connect, $query);
                    echo "Раскладные: $query<br>";
                }
            }
            //материал
            //если фабрика ливс - тогда кожа
            if ($factory_id==7)
            {
                $query = "INSERT INTO goodshasfeature (goodshasfeature_valueint, goodshasfeature_valuefloat, " .
                    "goodshasfeature_valuetext, goods_id, feature_id) " .
                    "VALUES (13,0,'',$id,149)";
                mysqli_query($db_connect, $query);
                echo "кожа: $query<br>";
            }

        }
    }


    mysqli_close($db_connect);
}
//////////////////////////
$runtime = new Timer();
$runtime->setStartTime();
//echo "test";
set_filters();
$runtime->setEndTime();
echo "<br> runtime=".$runtime->getRunTime()." sec <br>";
//////////////////////////
/**
 * Class Timer замеряет время выполнения скрипта
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
 * функция преобразовывает строку в кодировке  UTF-8 в строку в кодировке CP1251
 * @param $str string входящяя строка в кодировке UTF-8
 * @return string строка перобразованная в кодировку CP1251
 */
function UTF8toCP1251($str)
{ // by SiMM, $table from http://ru.wikipedia.org/wiki/CP1251
    static $table = array("\xD0\x81" => "\xA8", // Ё
        "\xD1\x91" => "\xB8", // ё
        // украинские символы
        "\xD0\x8E" => "\xA1", // Ў (У)
        "\xD1\x9E" => "\xA2", // ў (у)
        "\xD0\x84" => "\xAA", // Є (Э)
        "\xD0\x87" => "\xAF", // Ї (I..)
        "\xD0\x86" => "\xB2", // I (I)
        "\xD1\x96" => "\xB3", // i (i)
        "\xD1\x94" => "\xBA", // є (э)
        "\xD1\x97" => "\xBF", // ї (i..)
        // чувашские символы
        "\xD3\x90" => "\x8C", // &#1232; (А)
        "\xD3\x96" => "\x8D", // &#1238; (Е)
        "\xD2\xAA" => "\x8E", // &#1194; (С)
        "\xD3\xB2" => "\x8F", // &#1266; (У)
        "\xD3\x91" => "\x9C", // &#1233; (а)
        "\xD3\x97" => "\x9D", // &#1239; (е)
        "\xD2\xAB" => "\x9E", // &#1195; (с)
        "\xD3\xB3" => "\x9F", // &#1267; (у)
    );
    //цифровая магия
    $str = preg_replace('#([\xD0-\xD1])([\x80-\xBF])#se',
        'isset($table["$0"]) ? $table["$0"] :
                         chr(ord("$2")+("$1" == "\xD0" ? 0x30 : 0x70))
                        ',
        $str
    );
    $str = str_replace("i", "і", $str);
    $str = str_replace("I", "І", $str);
    return $str;
}
?>