<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 01.02.16
 * Time: 10:18
 */
header('Content-Type: text/html; charset=utf-8');
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


$selectedFactory=$_POST["factory"];
$runtime = new Timer();
$runtime->setStartTime();
switch ($selectedFactory)
{
    case "AMF":
        set_time_limit(200);
        include_once "/factory/amf.php";
        $test = new AMF($_FILES['file']['tmp_name']);
        $test->parse_price_amf();
        $test->test_data();
        $test->add_db_afm();
        break;
    case "Poparada":
        include_once "/factory/poparada.php";
        break;
    case "BRW":
        set_time_limit(200);
		include_once "/factory/brw-gerbor.php";
        parse_price_brw();
        //test_data_arr();
        //print_r($data);
        add_db_brw_gerbor($data);
        break;
    case "Gerbor":
        set_time_limit(200);
		include_once "/factory/brw-gerbor.php";
        parse_price_gerbor();
        //test_data_arr();
        add_db_brw_gerbor($data);
        break;
    case "Lisogor":
        include_once "/factory/lisogor.php";
        $test = new Lisogor($_FILES['file']['tmp_name']);
        $test->parce_price_lisogor();
        $test->test_data();
        $test->add_db_lisogor();
        //parse_price_lisogor();
        //test_data($data);
        //add_db_lisogor($data);
        break;
    case "Vika":
        include_once "/factory/vika.php";
        //parse_price_vika();
        //test_data_arr();
        //add_db_vika($data);
        $test = new Vika($_FILES['file']['tmp_name']);
        $test->parse_price_vika();
        $test->test_data();
        //$test->add_db_vika();
        break;
    case "Domini":
        //final!!!
        include_once "/factory/domini.php";
        $test = new Domini($_FILES['file']['tmp_name']);
        $test->parce_price_domini();
        $test->test_data();
        $test->add_db_domini();
        break;
    case "SidiM":
        echo "In progress";
        include_once "/factory/sidim.php";
        break;
    case "Come-for":
        //new untested!!!
        include_once "/factory/come-for.php";
        $test= new ComeFor($_FILES['file']['tmp_name']);
        $test->parce_price_comefor();
        $test->test_data();
        $test->add_db_comefor();
        break;
    case "Livs":
        //working unit!!!
        include_once "/factory/livs_divani.php";
        $test= new Livs($_FILES['file']['tmp_name']);
        $test->parse_price_livs();
        $test->test_data();
        $test->add_db_livs();
        break;
    case "Nova":
        //new untested!!!
        include_once "/factory/nova.php";
        $test= new Nova($_FILES['file']['tmp_name']);
        $test->parce_price_nova();
        $test->test_data();
        $test->add_db_nova();
        break;
    case "FunDesk":
        //new untested!!!
        include_once "/factory/fundesk.php";
        $test= new FunDesk($_FILES['file']['tmp_name']);
        $test->parce_price_fundesk();
        $test->test_data();
        $test->add_db_fundesk();
        break;

    case "Agat-M":
        break;


    default:
        echo "Выберите фабрику и повторите";
        break;

}
$runtime->setEndTime();
echo "<br> runtime=".$runtime->getRunTime()." sec <br>";

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
