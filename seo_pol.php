<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 20.07.16
 * Time: 10:10
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

function seo_kupe()
{
    $db_connect=mysqli_connect(host,user,pass,db);
    $query="SELECT * FROM goods WHERE goodskind_id=35 AND factory_id=47";
    if ($res=mysqli_query($db_connect,$query))
    {
        while ($row = mysqli_fetch_assoc($res))
        {
            $goods[]=$row;
        }
        foreach ($goods as $good)
        {
            $id=$good['goods_id'];
            $name=$good['goods_name'];
            
            $header=$good['goods_name'];
            $name_trunc=str_replace(UTF8toCP1251("Шкаф-купе "),"",$name);
			$title=$name_trunc.UTF8toCP1251(" шкаф-купе. Купить шкафы-купе со склада в Киеве");
			$keywords=UTF8toCP1251("шкафы-купе, ").$name.UTF8toCP1251(", склад мебели, купить шкаф-купе, интернет магазин мебели, недорогие шкафы-купе, цены, фото, отзывы.");
			$key_h=UTF8toCP1251("Фабрика ДОМ. ").$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
			$key_f=UTF8toCP1251("Фабрика ДОМ. ").$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
			$desc=UTF8toCP1251("Купить ").$name.UTF8toCP1251(" в интернет магазине «Файні-меблі», Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
            
			$query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
			mysqli_query($db_connect,$query);
			echo $query."<br>";
			//$header=$good['goods_header'];
			/*$title=$good['goods_title'];
            $keywords=$good['goods_keyw'];
            $key_h=$good['goods_hkeyw'];
            $key_f=&$good['goods_fkeyw'];
            $desc=$good['goods_desc'];*/
			//break;
        }
    }
    mysqli_close($db_connect);
}
function seo_mks()
{
    $db_connect=mysqli_connect(host,user,pass,db);
    $query="SELECT * FROM goods WHERE factory_id=134";
    if ($res=mysqli_query($db_connect,$query))
    {
        while ($row = mysqli_fetch_assoc($res))
        {
            $goods[]=$row;
        }
        foreach ($goods as $good)
        {
            $id=$good['goods_id'];
            $name=$good['goods_name'];
            $header=$good['goods_name'];
            $name_trunc=str_replace(UTF8toCP1251("Диван "),"",$name);
            $title=$name_trunc.UTF8toCP1251(" диван. Купить диван со склада в Киеве");
            $keywords=UTF8toCP1251("диваны, ").$name.UTF8toCP1251(", склад мебели, купить диван, интернет магазин мебели, недорогие диваны, цены, фото, отзывы.");
            $key_h=UTF8toCP1251("Фабрика МКС. ").$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
            $key_f=UTF8toCP1251("Фабрика МКС. ").$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
            $desc=UTF8toCP1251("Купить ").$name.UTF8toCP1251(" в интернет магазине «Файні-меблі», Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
            $query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
            mysqli_query($db_connect,$query);
            echo $query."<br>";
            //$header=$good['goods_header'];
            /*$title=$good['goods_title'];
            $keywords=$good['goods_keyw'];
            $key_h=$good['goods_hkeyw'];
            $key_f=&$good['goods_fkeyw'];
            $desc=$good['goods_desc'];*/
			//break;
        }
    }
    mysqli_close($db_connect);
}
seo_kupe();
seo_mks();
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
