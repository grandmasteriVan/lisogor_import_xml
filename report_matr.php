<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 27.09.16
 * Time: 09:17
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
 * @param $factory_id integer - айди фабрики
 * @param $goodskind integer - вид товара
 * @return array - массив, содержащий список всех родительских позиций
 * возвращает список всех родительских товаров, которые принадлежат к оной фабрике и типу товара
 */
function parrent_matr($factory_id)
{
    $db_connect=mysqli_connect(host,user,pass,db);
    $query="SELECT goods_article, goods_name FROM goods WHERE goods_parent=0 AND factory_id=$factory_id";
    if ($res=mysqli_query($db_connect,$query))
    {
        while ($row = mysqli_fetch_assoc($res))
        {
            $arr[] = $row;
        }
    }
    mysqli_close($db_connect);
    /*echo "<pre>";
	print_r ($arr);
	echo "</pre>";*/
    return $arr;
}
/**
 * @param $factory_id integer - айди фабрики
 * @param $goodskind integer - вид товара
 * @return array - массив, содержащий список дочерних позиций
 * возвращает список всех дочерних товаров, которые принадлежат к оной фабрике и типу товара
 */
function mod_matr($factory_id)
{
    $db_connect=mysqli_connect(host,user,pass,db);
    $query="SELECT goods_article, goods_name FROM goods WHERE goods_parent<>0 AND factory_id=$factory_id";
    if ($res=mysqli_query($db_connect,$query))
    {
        while ($row = mysqli_fetch_assoc($res))
        {
            $arr[] = $row;
        }
    }
    mysqli_close($db_connect);
    return $arr;
}
function res_img($factory_id)
{
	//echo "Y!";
	$db_connect=mysqli_connect(host,user,pass,db);
    $query="SELECT goods_id, goods_content FROM goods WHERE AND factory_id=$factory_id";
	if ($res=mysqli_query($db_connect,$query))
    {
        
		while ($row = mysqli_fetch_assoc($res))
        {
            $arr[] = $row;
        }
		//print_r($arr);
		foreach ($arr as $matr)
		{
			$id=$matr['goods_id'];
			$cont=$matr['goods_content'];
			$new_cont=str_replace("800px","700px",$cont);
			echo "NEW: $new_cont<br>";
			$query="UPDATE goods SET goods_content='$new_cont' WHERE goods_id=$id";
			mysqli_query($db_connect,$query);
			//echo "$query<br>";

		}
    }
    mysqli_close($db_connect);
}

function count_matr($factory_id)
{
    $parrent_matr=parrent_matr($factory_id);
    $mod_matr=mod_matr($factory_id);
    $i=1;
    echo "Основные товары:<br>";
    foreach ($parrent_matr as $parrent)
    {
        $name=$parrent['goods_name'];
        $article=$parrent['goods_article'];
        if (mb_strpos ($name,UTF8toCP1251("Копия"))==false)
        {
            echo "$i. $article $name<br>";
            $i++;
        }
    }
    $i=1;
    echo "<br>Модификации:<br>";
    foreach ($mod_matr as $mod)
    {
        $name=$mod['goods_name'];
        $article=$mod['goods_article'];
        if (mb_strpos ($name,UTF8toCP1251("Копия"))==false)
        {
            echo "$i. $article $name<br>";
            $i++;
        }
	}
}
count_matr(137);
res_img(137);
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
