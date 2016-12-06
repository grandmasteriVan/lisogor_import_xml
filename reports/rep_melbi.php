<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 06.12.16
 * Time: 12:26
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
 * Class FlashReport
 */
class MelbiReport
{
    /**
     *заполняем СЕО поля и включаем созданные позиции
     */
    public function report()
    {
        //находим позицию на сайте которая соответствует артиклу в отчете
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT * FROM goods WHERE factory_id=144";
        $counter=0;
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $site_pos = $row;
            }
            //print_r($site_pos);
            $goods_charter=$site_pos['goods_maintcharter'];
            echo "<br>charter= $goods_charter<br>";
            $id=$site_pos['goods_id'];
            $name=$site_pos['goods_name'];
            $header=$site_pos['goods_name'];
            //прописываем нужные сео поля в зависимости от категории товара
            switch ($goods_charter)
            {
                case 13:
                    //кровати
                    $name_trunc=str_replace($this->UTF8toCP1251("кровать "),"",$name);
                    $name_trunc=str_replace($this->UTF8toCP1251("Кровать "),"",$name_trunc);
                    $title=$name_trunc.$this->UTF8toCP1251(" кровать. Купить кровати со склада в Киеве");
                    $keywords=$this->UTF8toCP1251("кровати, ").$name.$this->UTF8toCP1251(", склад мебели, купить кровать, интернет магазин мебели, недорогие кровати, цены, фото, отзывы.");
                    $key_h=$this->UTF8toCP1251("Фабрика Мелби. ").$name.$this->UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
                    $key_f=$this->UTF8toCP1251("Фабрика Мелби. ").$name.$this->UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
                    $desc=$this->UTF8toCP1251("Купить ").$name.$this->UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
                    $query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
                    mysqli_query($db_connect,$query);
                    echo $query."<br>";
                    break;
                case 124:
                    //тумбы
                    $name_trunc=str_replace($this->UTF8toCP1251("Тумба "),"",$name);
                    $name_trunc=str_replace($this->UTF8toCP1251("тумба "),"",$name_trunc);
                    $title=$name_trunc.$this->UTF8toCP1251(" тумба. Купить тумбы со склада в Киеве");
                    $keywords=$this->UTF8toCP1251("тумбы, ").$name.$this->UTF8toCP1251(", склад мебели, купить тумбу, интернет магазин мебели, недорогие тумбы, цены, фото, отзывы.");
                    $key_h=$this->UTF8toCP1251("Фабрика Мелби. ").$name.$this->UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
                    $key_f=$this->UTF8toCP1251("Фабрика Мелби. ").$name.$this->UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
                    $desc=$this->UTF8toCP1251("Купить ").$name.$this->UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
                    $query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
                    mysqli_query($db_connect,$query);
                    echo $query."<br>";
                    break;
            }
            //а теперь включаем товар
            $query="UPDATE goods SET goods_active=1 WHERE goods_id=$id";
            mysqli_query($db_connect,$query);
            echo $query."<br>";
            $counter++;
        }
        echo "<br>Total: $counter";
        mysqli_close($db_connect);
    }
    /**
     * @param $str
     * @return mixed
     */
    private function UTF8toCP1251($str)
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
}
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
        return $this->start_time-$this->end_time;
    }
}
set_time_limit(2000);
$runtime = new Timer();
$runtime->setStartTime();
$report=new MelbiReport();
$report->report();
$runtime->setEndTime();
echo "<br> runtime=".$runtime->getRunTime()." sec <br>";
?>