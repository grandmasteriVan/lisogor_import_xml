<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 15.07.16
 * Time: 09:48
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

function change_seo($goods_kind=40)
{
    $db_connect=mysqli_connect(host,user,pass,db);
    $query="SELECT goods_id, goods_title, goods_desc, goods_header FROM goods WHERE goodskind_id=$goods_kind";
    if ($res=mysqli_query($db_connect,$query))
    {
        while ($row = mysqli_fetch_assoc($res))
        {
            $goods[]=$row;
        }
        foreach ($goods as $good)
        {
            $id=$good['goods_id'];
            $header=$good['goods_header'];
            $title=$good['goods_title'];
            $desc=$good['goods_desc'];
            //делаем тайтл
            //echo "strpos: ".strpos($title, UTF8toCP1251(". Купить"+1))."<br>";
			//$title_new=substr($title,strpos($title, UTF8toCP1251(". Купить")+1));
			$title_new=$header.UTF8toCP1251(". Купить Матрасы со склада в Киеве");
			//echo "$title_new<br>";
            //$title_new=$header.". ".$title_new;
            //делаем дескрипшн
			//$desc_new=substr($desc,strpos($desc, UTF8toCP1251(" в интернет")+1));
            //$desc_new=substr($desc,strpos($desc, UTF8toCP1251(" в интернет")+1));
			//echo $desc_new."<br>";
            //$desc_new=UTF8toCP1251("Купить ").$header." ".$desc_new;
            $desc_new=UTF8toCP1251("Купить ").$header.UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
            //пишем изменения в бд
            $query="UPDATE goods SET goods_title='$title_new', goods_desc='$desc_new' WHERE goods_id=$id";
            mysqli_query($db_connect,$query);
            echo "<b>Old title:</b> $title <br><b>New title:</b> $title_new<br>";
			echo "<b>Old desc:</b> $desc <br><b>New desc:</b> $desc_new<br><br>";
			//echo $query."<br>";
			//break;
        }
    }
    mysqli_close($db_connect);
}
change_seo();

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
