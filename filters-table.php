<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 19.09.16
 * Time: 10:05
 */


/**
 * database host
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


function set_filters()
{
    //выбираем все столы (товары, у которых главная категория - столы)
    $db_connect=mysqli_connect(host,user,pass,db);
    $query="SELECT goods_id FROM goods WHERE goods_maintcharter=125";
    if ($res=mysqli_query($db_connect,$query))
    {
        while ($row = mysqli_fetch_assoc($res))
        {
            $tables[] = $row;
        }
        foreach ($tables as $table)
        {
            $id=$table['goods_id'];
            //для каждого стола выбираем список его вильтров
            $query="SELECT * FROM goodshasfeature WHERE goods_id=$id";
            if ($res=mysqli_query($db_connect,$query))
            {
                while ($row = mysqli_fetch_assoc($res))
                {
                    $filters[] = $row;
                }
                foreach ($filters as $filter)
                {
                    $filter_id=$filter['goodshasfeature_valueint'];
                    $feature_id=$filter['feature_id'];
                    //проверяем, если значение фильтра равно шаблону, то записываем соответствующее нему значение нового фильтра
                    //компьюторный
                    if ($feature_id==128&&$filter_id==10)
                    {
                        $query="INSERT INTO goodshasfeature (goodshasfeature_valueint, goodshasfeature_valuefloat, ".
                            "goodshasfeature_valuetext, goods_id, feature_id) ".
                            "VALUES (10,0,'',$id,151)";
                        mysqli_query($db_connect,$query);
                        echo "компьюторный: $query <br>";
                    }
                    //стол-книжка
                    if ($feature_id==128&&$filter_id==12)
                    {
                        $query="INSERT INTO goodshasfeature (goodshasfeature_valueint, goodshasfeature_valuefloat, ".
                            "goodshasfeature_valuetext, goods_id, feature_id) ".
                            "VALUES (33,0,'',$id,151)";
                        mysqli_query($db_connect,$query);
                        echo "стол-книжка: $query <br>";
                    }
                    //письменный
                    if ($feature_id==128&&$filter_id==11)
                    {
                        $query="INSERT INTO goodshasfeature (goodshasfeature_valueint, goodshasfeature_valuefloat, ".
                            "goodshasfeature_valuetext, goods_id, feature_id) ".
                            "VALUES (11,0,'',$id,151)";
                        mysqli_query($db_connect,$query);
                        echo "письменный: $query <br>";
                    }

                }
            }

        }
    }
    mysqli_close($db_connect);
}

$runtime = new Timer();
$runtime->setStartTime();
set_filters();

$runtime->setEndTime();
echo "<br> runtime=".$runtime->getRunTime()." sec <br>";


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


