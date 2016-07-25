<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 25.07.16
 * Time: 14:39
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
 * @param $goods_kind integer айди типа товара
 * в зависимоти от типа товара меняет его категорию
 */
function repair_tov ($goods_kind)
{
    $db_connect=mysqli_connect(host,user,pass,db);
    $query="SELECT goods_id, goods_maintcharter FROM goods WHERE goodskind_id=$goods_kind";
    $i=1;
    if ($res=mysqli_query($db_connect,$query))
    {
        //формируем список позиций
        while ($row = mysqli_fetch_assoc($res))
        {
            $tovars[] = $row;
        }
        //проверяем есть ли название типа мебели в названии товара
        foreach ($tovars as $tovar)
        {
            $id=$tovar['goods_id'];
            //кровати
            if ($goods_kind==39||$goods_kind==74)
            {
                $query="DELETE FROM goodshastcharter WHERE goods_id=$id";
                mysqli_query($db_connect,$query);
                $query="INSERT INTO goodshastcharter (goods_id, tcharter_id) VALUES ($id,13)";
                mysqli_query($db_connect,$query);

                $query="UPDATE goods SET goods_maintcharter=13 WHERE goods_id=$id";
                mysqli_query($db_connect,$query);
                echo $i.". ".$query."<br>";
                //return;
            }
            //детские кровати
            if ($goods_kind==50)
            {
                $query="DELETE FROM goodshastcharter WHERE goods_id=$id";
                mysqli_query($db_connect,$query);
                $query="INSERT INTO goodshastcharter (goods_id, tcharter_id) VALUES ($id,16)";
                mysqli_query($db_connect,$query);

                $query="UPDATE goods SET goods_maintcharter=16 WHERE goods_id=$id";
                mysqli_query($db_connect,$query);
                echo $i.". ".$query."<br>";
                //return;
            }
            //прихожие
            if ($goods_kind==30)
            {
                $query="DELETE FROM goodshastcharter WHERE goods_id=$id";
                mysqli_query($db_connect,$query);
                $query="INSERT INTO goodshastcharter (goods_id, tcharter_id) VALUES ($id,4)";
                mysqli_query($db_connect,$query);

                $query="UPDATE goods SET goods_maintcharter=4 WHERE goods_id=$id";
                mysqli_query($db_connect,$query);
                echo $i.". ".$query."<br>";
                //return;
            }
            //спальни
            if ($goods_kind==29)
            {
                $query="DELETE FROM goodshastcharter WHERE goods_id=$id";
                mysqli_query($db_connect,$query);
                $query="INSERT INTO goodshastcharter (goods_id, tcharter_id) VALUES ($id,3)";
                mysqli_query($db_connect,$query);

                $query="UPDATE goods SET goods_maintcharter=3 WHERE goods_id=$id";
                mysqli_query($db_connect,$query);
                echo $i.". ".$query."<br>";
                //return;
            }
            //дверь входная
            if ($goods_kind==108)
            {
                $query="DELETE FROM goodshastcharter WHERE goods_id=$id";
                mysqli_query($db_connect,$query);
                $query="INSERT INTO goodshastcharter (goods_id, tcharter_id) VALUES ($id,77)";
                mysqli_query($db_connect,$query);

                $query="UPDATE goods SET goods_maintcharter=77 WHERE goods_id=$id";
                mysqli_query($db_connect,$query);
                echo $i.". ".$query."<br>";
                //return;
            }
            //дверь межкомнатная
            if ($goods_kind==81)
            {
                $query="DELETE FROM goodshastcharter WHERE goods_id=$id";
                mysqli_query($db_connect,$query);
                $query="INSERT INTO goodshastcharter (goods_id, tcharter_id) VALUES ($id,76)";
                mysqli_query($db_connect,$query);

                $query="UPDATE goods SET goods_maintcharter=76 WHERE goods_id=$id";
                mysqli_query($db_connect,$query);
                echo $i.". ".$query."<br>";
                //return;
            }
            //матрас
            if ($goods_kind==40)
            {
                $query="DELETE FROM goodshastcharter WHERE goods_id=$id";
                mysqli_query($db_connect,$query);
                $query="INSERT INTO goodshastcharter (goods_id, tcharter_id) VALUES ($id,14)";
                mysqli_query($db_connect,$query);

                $query="UPDATE goods SET goods_maintcharter=14 WHERE goods_id=$id";
                mysqli_query($db_connect,$query);
                echo $i.". ".$query."<br>";
                //return;
            }
            //комоды
            if ($goods_kind==38)
            {
                $query="DELETE FROM goodshastcharter WHERE goods_id=$id";
                mysqli_query($db_connect,$query);
                $query="INSERT INTO goodshastcharter (goods_id, tcharter_id) VALUES ($id,12)";
                mysqli_query($db_connect,$query);

                $query="UPDATE goods SET goods_maintcharter=12 WHERE goods_id=$id";
                mysqli_query($db_connect,$query);
                echo $i.". ".$query."<br>";
                //return;
            }
            //столы компьюторные
            if ($goods_kind==32)
            {
                $query="DELETE FROM goodshastcharter WHERE goods_id=$id";
                mysqli_query($db_connect,$query);
                $query="INSERT INTO goodshastcharter (goods_id, tcharter_id) VALUES ($id,125)";
                mysqli_query($db_connect,$query);

                $query="UPDATE goods SET goods_maintcharter=125 WHERE goods_id=$id";
                mysqli_query($db_connect,$query);
                echo $i.". ".$query."<br>";
                //return;
            }
            //столы журнальные
            if ($goods_kind==33||$goods_kind==71)
            {
                $query="DELETE FROM goodshastcharter WHERE goods_id=$id";
                mysqli_query($db_connect,$query);
                $query="INSERT INTO goodshastcharter (goods_id, tcharter_id) VALUES ($id,125)";
                mysqli_query($db_connect,$query);

                $query="UPDATE goods SET goods_maintcharter=125 WHERE goods_id=$id";
                mysqli_query($db_connect,$query);
                echo $i.". ".$query."<br>";
                //return;
            }
            //столы письменные
            if ($goods_kind==34)
            {
                $query="DELETE FROM goodshastcharter WHERE goods_id=$id";
                mysqli_query($db_connect,$query);
                $query="INSERT INTO goodshastcharter (goods_id, tcharter_id) VALUES ($id,125)";
                mysqli_query($db_connect,$query);

                $query="UPDATE goods SET goods_maintcharter=125 WHERE goods_id=$id";
                mysqli_query($db_connect,$query);
                echo $i.". ".$query."<br>";
                //return;
            }
            //столы обеденные
            if ($goods_kind==109)
            {
                $query="DELETE FROM goodshastcharter WHERE goods_id=$id";
                mysqli_query($db_connect,$query);
                $query="INSERT INTO goodshastcharter (goods_id, tcharter_id) VALUES ($id,19)";
                mysqli_query($db_connect,$query);

                $query="UPDATE goods SET goods_maintcharter=19 WHERE goods_id=$id";
                mysqli_query($db_connect,$query);
                echo $i.". ".$query."<br>";
                //return;
            }
            //тумбы для обуви
            if ($goods_kind==43)
            {
                $query="DELETE FROM goodshastcharter WHERE goods_id=$id";
                mysqli_query($db_connect,$query);
                $query="INSERT INTO goodshastcharter (goods_id, tcharter_id) VALUES ($id,124)";
                mysqli_query($db_connect,$query);

                $query="UPDATE goods SET goods_maintcharter=124 WHERE goods_id=$id";
                mysqli_query($db_connect,$query);
                echo $i.". ".$query."<br>";
                //return;
            }
            //тумбы прикроватные
            if ($goods_kind==64)
            {
                $query="DELETE FROM goodshastcharter WHERE goods_id=$id";
                mysqli_query($db_connect,$query);
                $query="INSERT INTO goodshastcharter (goods_id, tcharter_id) VALUES ($id,124)";
                mysqli_query($db_connect,$query);

                $query="UPDATE goods SET goods_maintcharter=124 WHERE goods_id=$id";
                mysqli_query($db_connect,$query);
                echo $i.". ".$query."<br>";
                //return;
            }
            //тумбы под тв
            if ($goods_kind==41)
            {
                $query="DELETE FROM goodshastcharter WHERE goods_id=$id";
                mysqli_query($db_connect,$query);
                $query="INSERT INTO goodshastcharter (goods_id, tcharter_id) VALUES ($id,124)";
                mysqli_query($db_connect,$query);

                $query="UPDATE goods SET goods_maintcharter=124 WHERE goods_id=$id";
                mysqli_query($db_connect,$query);
                echo $i.". ".$query."<br>";
                //return;
            }
            //туалетные столики
            if ($goods_kind==80)
            {
                $query="DELETE FROM goodshastcharter WHERE goods_id=$id";
                mysqli_query($db_connect,$query);
                $query="INSERT INTO goodshastcharter (goods_id, tcharter_id) VALUES ($id,125)";
                mysqli_query($db_connect,$query);

                $query="UPDATE goods SET goods_maintcharter=125 WHERE goods_id=$id";
                mysqli_query($db_connect,$query);
                echo $i.". ".$query."<br>";
				//return;
			}
            $i++;
        }
    }
    mysqli_close($db_connect);
}
/**
 * @param $goods_kind integer айди товара
 * печатает список всех товаров, которые имеют определенный тип
 */
function print_names ($goods_kind)
{
    $db_connect=mysqli_connect(host,user,pass,db);
    $query="SELECT goods_id, goods_name FROM goods WHERE goodskind_id=$goods_kind";
    if ($res=mysqli_query($db_connect,$query))
    {
        //формируем список имен позиций
        while ($row = mysqli_fetch_assoc($res))
        {
            echo $row['goods_name']."<br>";
        }
    }
    mysqli_close($db_connect);
}
repair_tov(39);//кровати
repair_tov(50);//детские кровати
repair_tov(74);//еще кровати
repair_tov(108);//входная дверь
repair_tov(81);//межклмнатная дверь
repair_tov(40);//матрас
repair_tov(30);//прихожая
repair_tov(29);//спальня
repair_tov(38);//комоды
repair_tov(32);//столы компьюторные
repair_tov(33);//столы журнальные
repair_tov(71);//столы журнальные
repair_tov(41);//тумбы под ТВ
repair_tov(34);//столы письменные
repair_tov(109);//столы обеденные
repair_tov(43);//тумбы для обуви
repair_tov(64);//тумбы для обуви
repair_tov(80);//туалетные столики



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