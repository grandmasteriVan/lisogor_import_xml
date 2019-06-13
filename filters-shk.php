<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 08.08.16
 * Time: 12:10
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
/**
 *
 */
define ("user", "uh333660_mebli");
/**
 * database password
 */
//define ("pass", "");
/**
 *
 */
define ("pass", "Z7A8JqUh");
/**
 * database name
 */
//define ("db", "mebli");
/**
 *
 */
define ("db", "uh333660_mebli");
/**
 *устанавлиает нужные фильтры в разделе шкафы-купе
 */
function set_filters()
{
    $db_connect=mysqli_connect(host,user,pass,db);
    $query="SELECT * FROM goods WHERE goodskind_id=35";
    if ($res=mysqli_query($db_connect,$query))
    {
        while ($row = mysqli_fetch_assoc($res))
        {
            $arr[] = $row;
        }
        foreach ($arr as $tov)
        {
            
			$id=$tov['goods_id'];
            $name=$tov['goods_name'];
            $factory=$tov['factory_id'];
			
			//удаляем всякое (кроме ниши для тв)
			$query="DELETE FROM goodshasfeature WHERE goods_id=$id AND feature_id=125 AND goodshasfeature_valueint<>3";
			mysqli_query($db_connect,$query);
            echo "Удаляем : $query <br>";
			//зеркало
			$query="INSERT INTO goodshasfeature (goodshasfeature_valueint, goodshasfeature_valuefloat, ".
                    "goodshasfeature_valuetext, goods_id, feature_id) ".
                    "VALUES (4,0,'',$id,125)";
            mysqli_query($db_connect,$query);
            echo "зеркало: $query <br>";
			//фотопечать-рисунок
			$query="INSERT INTO goodshasfeature (goodshasfeature_valueint, goodshasfeature_valuefloat, ".
                    "goodshasfeature_valuetext, goods_id, feature_id) ".
                    "VALUES (5,0,'',$id,125)";
                mysqli_query($db_connect,$query);
                echo "фотопечать-рисунок: $query <br>";
			//пескоструй
			$query="INSERT INTO goodshasfeature (goodshasfeature_valueint, goodshasfeature_valuefloat, ".
                    "goodshasfeature_valuetext, goods_id, feature_id) ".
                    "VALUES (6,0,'',$id,125)";
            mysqli_query($db_connect,$query);
            echo "пескоструй: $query <br>";
            //лакобель
            if ($factory==115)
            {
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueint, goodshasfeature_valuefloat, ".
                    "goodshasfeature_valuetext, goods_id, feature_id) ".
                    "VALUES (7,0,'',$id,125)";
                mysqli_query($db_connect,$query);
                echo "Лакобель: $query <br>";
            }
            if ($factory==20)
            {
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueint, goodshasfeature_valuefloat, ".
                    "goodshasfeature_valuetext, goods_id, feature_id) ".
                    "VALUES (7,0,'',$id,125)";
                mysqli_query($db_connect,$query);
                echo "Лакобель: $query <br>";
            }
            if ($factory==106)
            {
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueint, goodshasfeature_valuefloat, ".
                    "goodshasfeature_valuetext, goods_id, feature_id) ".
                    "VALUES (7,0,'',$id,125)";
                mysqli_query($db_connect,$query);
                echo "Лакобель: $query <br>";
            }
            if ($factory==118)
            {
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueint, goodshasfeature_valuefloat, ".
                    "goodshasfeature_valuetext, goods_id, feature_id) ".
                    "VALUES (7,0,'',$id,125)";
                mysqli_query($db_connect,$query);
                echo "Лакобель: $query <br>";
            }
			
            //стиль
            //18 - id стиль
            //сначала удаляем записи о стилях
            $query="DELETE FROM goodshasfuture WHERE fearure_id=18 AND goods_id=$id";
            mysqli_query($db_connect,$query);
            echo "$query <br>";
            //потом записываем всем шкафам все стили
            //классика
            $query="INSERT INTO goodshasfeature (goodshasfeature_valueint, goodshasfeature_valuefloat, ".
                "goodshasfeature_valuetext, goods_id, feature_id) ".
                "VALUES (1,0,'',$id,18)";
            mysqli_query($db_connect,$query);
            echo "классика: $query <br>";
            //современный-модный
            $query="INSERT INTO goodshasfeature (goodshasfeature_valueint, goodshasfeature_valuefloat, ".
                "goodshasfeature_valuetext, goods_id, feature_id) ".
                "VALUES (10,0,'',$id,18)";
            mysqli_query($db_connect,$query);
            echo "современный-модный: $query <br>";
            //стильный-красивый
            $query="INSERT INTO goodshasfeature (goodshasfeature_valueint, goodshasfeature_valuefloat, ".
                "goodshasfeature_valuetext, goods_id, feature_id) ".
                "VALUES (11,0,'',$id,18)";
            mysqli_query($db_connect,$query);
            echo "стильный-красивый: $query <br>";
            //переименовываем позицию
            $name=str_replace(UTF8toCP1251("Шкаф-купе "),"",$name);
            $name=str_replace(UTF8toCP1251("Шкаф "),"",$name);
            $name=str_replace(UTF8toCP1251("шкаф "),"",$name);
            $name=str_replace(UTF8toCP1251("купе "),"",$name);
            $name=str_replace(UTF8toCP1251("Купе  "),"",$name);
			$name=str_replace(UTF8toCP1251("-"),"",$name);
            $name="Шкаф-купе ".$name;
            $name=UTF8toCP1251($name);
            $query="UPDATE goods SET goods_name='$name' WHERE goods_id=$id";
            mysqli_query($db_connect,$query);
			/* вот этот кусок кода не нужен!!!!
            //начинаем добавлять нужные фильтры основываясь на старых
            $query="SELECT * FROM goodshasfeature WHERE goods_id=$id";
            if ($res=mysqli_query($db_connect,$query))
            {
                while ($row = mysqli_fetch_assoc($res))
                {
                    $features[] = $row;
                }
                //чтоб не повторятся
				$stop=false;
				foreach ($features as $feature)
                {
					$feature_id=$feature['feature_id'];
                    $value=$feature['goodshasfeature_valueint'];
                    //32 - id количество дверей
                    //количество дверей
					
                    if (($feature_id==117)&&($stop==false))
                    {
                        //одна дверь
                        if ($value==1)
                        {
                            //удаляем старые записи
                            $query="DELETE FROM goodshasfuture WHERE fearure_id=117 AND goods_id=$id AND goodshasfeature_valueint<>1 AND goodshasfeature_valueint<>12";
                            mysqli_query($db_connect,$query);
                            echo "$query <br>";
                            //записываем новый фильтр
                            $query="INSERT INTO goodshasfeature (goodshasfeature_valueint, goodshasfeature_valuefloat, ".
                                "goodshasfeature_valuetext, goods_id, feature_id) ".
                                "VALUES (13,0,'',$id,117)";
                            mysqli_query($db_connect,$query);
                            echo "$query <br>";
							$stop=true;
                        }
                        //две двери
                        if ($value==2)
                        {
                            //удаляем старые записи
                            $query="DELETE FROM goodshasfuture WHERE fearure_id=117 AND goods_id=$id AND goodshasfeature_valueint<>1 AND goodshasfeature_valueint<>12";
                            mysqli_query($db_connect,$query);
                            echo "$query <br>";
                            //записываем новый фильтр
                            $query="INSERT INTO goodshasfeature (goodshasfeature_valueint, goodshasfeature_valuefloat, ".
                                "goodshasfeature_valuetext, goods_id, feature_id) ".
                                "VALUES (8,0,'',$id,117)";
                            mysqli_query($db_connect,$query);
                            echo "$query <br>";
							$stop=true;
                        }
                        //три двери
                        if ($value==5)
                        {
                            //удаляем старые записи
                            $query="DELETE FROM goodshasfuture WHERE fearure_id=117 AND goods_id=$id AND goodshasfeature_valueint<>1 AND goodshasfeature_valueint<>12";
                            mysqli_query($db_connect,$query);
                            echo "$query <br>";
                            //записываем новый фильтр
                            $query="INSERT INTO goodshasfeature (т, goodshasfeature_valuefloat, ".
                                "goodshasfeature_valuetext, goods_id, feature_id) ".
                                "VALUES (9,0,'',$id,117)";
                            mysqli_query($db_connect,$query);
                            echo "$query <br>";
							$stop=true;
                        }
                        //четыре двери
                        if ($value==3)
                        {
                            //удаляем старые записи
                            $query="DELETE FROM goodshasfuture WHERE fearure_id=117 AND goods_id=$id AND goodshasfeature_valueint<>1 AND goodshasfeature_valueint<>12";
                            mysqli_query($db_connect,$query);
                            echo "$query <br>";
                            //записываем новый фильтр
                            $query="INSERT INTO goodshasfeature (goodshasfeature_valueint, goodshasfeature_valuefloat, ".
                                "goodshasfeature_valuetext, goods_id, feature_id) ".
                                "VALUES (10,0,'',$id,117)";
                            mysqli_query($db_connect,$query);
                            echo "$query <br>";
							$stop=true;
                        }
                    }
                }
            }*/
        }
    }
	else
	{
		echo "Error in SQL";
	}
    mysqli_close($db_connect);
}
set_time_limit(4000);
set_filters();

/**
 * @param $str
 * @return mixed
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
