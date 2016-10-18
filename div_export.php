<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 21.07.16
 * Time: 11:11
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
define ("db", "divani_new");
//define ("db", "uh333660_mebli");
/**
 * парсит фильтры со старого сайта и записывает их в соответствующие места на новом
 */
function export_filters()
{
    $db_connect=mysqli_connect(host,user,pass,db);
    $query="SELECT goods_id, goods_price, goods_exfeature FROM goods";
    if ($res=mysqli_query($db_connect,$query))
    {
        while ($row = mysqli_fetch_assoc($res))
        {
            $goods[]=$row;
        }
        foreach ($goods as $good)
        {
            $id=$good['goods_id'];
			echo "ID:".$id."<br>";
            $feat=$good['goods_exfeature'];
			//$feat="fff ggg";
            $arr=explode("\n",$feat);
			//echo gettype ($arr);
            //echo $feat."<br>";
			echo "<pre>";
            print_r($arr);
            echo  "</pre>";

            //+++
            //размеры!
            $query="SELECT * FROM size WHERE goods_id=$id";
            if ($res=mysqli_query($db_connect,$query))
            {
                unset($arr);
                while ($row = mysqli_fetch_assoc($res))
                {
                    $arr[] = $row;
                }
                if ($arr['size_length']>2000||$arr['size_width']>2000||$arr['size_height']>2000)
                {
                    $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (108,$id,11)";
                    mysqli_query($db_connect,$query);
                    echo $query."<br>";
                }
                //спальное место
                //односпальные
                if ($arr['size_width_sl']<=1200)
                {
                    $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (114,$id,10)";
                    mysqli_query($db_connect,$query);
                    echo $query."<br>";
                }
                //двуспальные
                if ($arr['size_width_sl']>1200&&$arr['size_width_sl']<1800)
                {
                    $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (71,$id,10)";
                    mysqli_query($db_connect,$query);
                    echo $query."<br>";
                }
                //трехспальные
                if ($arr['size_width_sl']>=1800)
                {
                    $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (71,$id,10)";
                    mysqli_query($db_connect,$query);
                    echo $query."<br>";
                }
            }
            //цена
            $price=$good['goods_price'];
            //эконом
            if ($price<=3500)
            {
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (47,$id,4)";
                mysqli_query($db_connect,$query);
                echo $query."<br>";
            }
            //недорого
            if ($price>3500&&$price<=9000)
            {
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (48,$id,4)";
                mysqli_query($db_connect,$query);
                echo $query."<br>";
            }
            //элит
            if ($price>9000)
            {
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (49,$id,4)";
                mysqli_query($db_connect,$query);
                echo $query."<br>";
            }

            //модульные диваны
            //если в имени или в тексте есть модульный
            $query="SELECT * FROM goodshaslang WHERE goods_id=$id";
            if ($res=mysqli_query($db_connect,$query))
            {
                unset($arr);
                while ($row = mysqli_fetch_assoc($res))
                {
                    $arr[] = $row;
                }
                $name=$arr['goodshaslang_name'];
                $name=" ".$name;
                $content=$arr['goodshaslang_content'];
                if (mb_stripos("модуль",$name)||(mb_stripos("модуль",$content)))
                {
                    $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (57,$id,6)";
                    mysqli_query($db_connect,$query);
                    echo $query."<br>";
                }
            }
            //+++

			//разбор параметров
			//ниша в подлокотнике
            $armrest=$arr[11];
            $armrest=strip_tags($armrest);
            $armrest=str_replace("Ниша в подлокотнике: "," ",$armrest);
			
            if (mb_strpos ($armrest,"Есть"))
            {
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (53,$id,5)";
                mysqli_query($db_connect,$query);
				echo $query."<br>";
            }
			
            //бар
            $bar=$arr[10];
            $bar=strip_tags($bar);
            $bar=str_replace("Бар: "," ",$bar);
			
            if (mb_strpos ($bar,"Есть"))
            {
                //аксесуары
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (52,$id,5)";
                mysqli_query($db_connect,$query);
				echo $query."<br>";
                //диваны с баром
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (112,$id,11)";
                mysqli_query($db_connect,$query);
                echo $query."<br>";
            }
            //на кухню
            $kitchen=$arr[9];
            $kitchen=strip_tags($kitchen);
            $kitchen=str_replace("Подушки: "," ",$kitchen);
			
            if (mb_strpos ($kitchen,"Есть"))
            {
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (65,$id,9)";
                mysqli_query($db_connect,$query);
				echo $query."<br>";
            }
            //ниша для белья
            $niche=$arr[8];
            $niche=strip_tags($niche);
            $niche=str_replace("Ниша для белья: "," ",$niche);
            if (mb_strpos ($niche,"Есть"))
            {
                //аксессуар
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (51,$id,5)";
                mysqli_query($db_connect,$query);
				echo $query."<br>";
                //диваны с ящиками
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (113,$id,11)";
                mysqli_query($db_connect,$query);
                echo $query."<br>";
            }
            //подушки
            $pillow=$arr[7];
            $pillow=strip_tags($pillow);
            $pillow=str_replace("Подушки: "," ",$pillow);
            if (mb_strpos ($pillow,"Есть"))
            {
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (50,$id,5)";
                mysqli_query($db_connect,$query);
				echo $query."<br>";
            }
            //транформация
            $trans=$arr[2];
            $trans=strip_tags($trans);
            $trans=str_replace("Разложение: "," ",$trans);
            if (mb_strpos ($trans,"Аккордеон"))
            {
                //механизм
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (7,$id,1)";
                mysqli_query($db_connect,$query);
				echo $query."<br>";
                //трансвормация
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (58,$id,7)";
                mysqli_query($db_connect,$query);
				echo $query."<br>";
            }
            if (mb_strpos ($trans,"Алеко"))
            {
                //механизм
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (8,$id,1)";
                mysqli_query($db_connect,$query);
				echo $query."<br>";
                //трансвормация
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (58,$id,7)";
                mysqli_query($db_connect,$query);
				echo $query."<br>";
            }
            if (mb_strpos ($trans,"Верона"))
            {
                //механизм
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (11,$id,1)";
                mysqli_query($db_connect,$query);
				echo $query."<br>";
                //трансвормация
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (58,$id,7)";
                mysqli_query($db_connect,$query);
				echo $query."<br>";
            }
            if (mb_strpos ($trans,"Выкатной"))
            {
                //механизм
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (3,$id,1)";
                mysqli_query($db_connect,$query);
				echo $query."<br>";
                //трансвормация
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (58,$id,7)";
                mysqli_query($db_connect,$query);
				echo $query."<br>";
            }
            if (mb_strpos ($trans,"Дельфин"))
            {
                //механизм
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (5,$id,1)";
                mysqli_query($db_connect,$query);
				echo $query."<br>";
                //трансвормация
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (58,$id,7)";
                mysqli_query($db_connect,$query);
				echo $query."<br>";
            }
            if (mb_strpos ($trans,"Еврокнижка"))
            {
                //механизм
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (4,$id,1)";
                mysqli_query($db_connect,$query);
				echo $query."<br>";
                //трансвормация
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (58,$id,7)";
                mysqli_query($db_connect,$query);
				echo $query."<br>";
            }
            if (mb_strpos ($trans,"клик-кляк"))
            {
                //механизм
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (6,$id,1)";
                mysqli_query($db_connect,$query);
				echo $query."<br>";
                //трансвормация
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (58,$id,7)";
                mysqli_query($db_connect,$query);
				echo $query."<br>";
            }
            if (mb_strpos ($trans,"Мералат"))
            {
                //механизм
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (12,$id,1)";
                mysqli_query($db_connect,$query);
				echo $query."<br>";
                //трансвормация
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (58,$id,7)";
                mysqli_query($db_connect,$query);
				echo $query."<br>";
            }
            if (mb_strpos ($trans,"Поворотный"))
            {
                //механизм
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (107,$id,1)";
                mysqli_query($db_connect,$query);
				echo $query."<br>";
                //трансвормация
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (58,$id,7)";
                mysqli_query($db_connect,$query);
				echo $query."<br>";
            }
            if (mb_strpos ($trans,"Пума"))
            {
                //механизм
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (13,$id,1)";
                mysqli_query($db_connect,$query);
				echo $query."<br>";
                //трансвормация
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (58,$id,7)";
                mysqli_query($db_connect,$query);
				echo $query."<br>";
            }
            if (mb_strpos ($trans,"Сабля"))
            {
                //механизм
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (20,$id,1)";
                mysqli_query($db_connect,$query);
				echo $query."<br>";
                //трансвормация
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (58,$id,7)";
                mysqli_query($db_connect,$query);
				echo $query."<br>";
            }
            if (mb_strpos ($trans,"Седафлекс"))
            {
                //механизм
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (10,$id,1)";
                mysqli_query($db_connect,$query);
				echo $query."<br>";
                //трансвормация
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (58,$id,7)";
                mysqli_query($db_connect,$query);
				echo $query."<br>";
            }
            if (mb_strpos ($trans,"Софа"))
            {
                //механизм
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (127,$id,1)";
                mysqli_query($db_connect,$query);
				echo $query."<br>";
                //трансвормация
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (58,$id,7)";
                mysqli_query($db_connect,$query);
				echo $query."<br>";
            }
            if (mb_strpos ($trans,"Телескоп"))
            {
                //механизм
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (18,$id,1)";
                mysqli_query($db_connect,$query);
				echo $query."<br>";
                //трансвормация
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (58,$id,7)";
                mysqli_query($db_connect,$query);
				echo $query."<br>";
            }
            if (mb_strpos ($trans,"Французская"))
            {
                //механизм
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (14,$id,1)";
                mysqli_query($db_connect,$query);
				echo $query."<br>";
                //трансвормация
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (58,$id,7)";
                mysqli_query($db_connect,$query);
				echo $query."<br>";
            }
            if (mb_strpos ($trans,"Шагающая"))
            {
                //механизм
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (9,$id,1)";
                mysqli_query($db_connect,$query);
				echo $query."<br>";
                //трансвормация
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (58,$id,7)";
                mysqli_query($db_connect,$query);
				echo $query."<br>";
            }
            if (mb_strpos ($trans,"Не раскладывается"))
            {
                //трансвормация
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (59,$id,7)";
                mysqli_query($db_connect,$query);
				echo $query."<br>";
            }
            //тип дивана
            $type=$arr[1];
            $type=strip_tags($type);
            $type=str_replace("Тип дивана: "," ",$type);
            if (mb_strpos ($type,"Диван"))
            {
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (120,$id,15)";
                mysqli_query($db_connect,$query);
				echo $query."<br>";
            }
            if (mb_strpos ($type,"Кресло"))
            {
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (99,$id,15)";
                mysqli_query($db_connect,$query);
				echo $query."<br>";
            }
            if (mb_strpos ($type,"Кровать"))
            {
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (100,$id,15)";
                mysqli_query($db_connect,$query);
				echo $query."<br>";
            }
            if (mb_strpos ($type,"Мини диван"))
            {
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (101,$id,15)";
                mysqli_query($db_connect,$query);
				echo $query."<br>";
            }
            if (mb_strpos ($type,"Пуфы"))
            {
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (102,$id,15)";
                mysqli_query($db_connect,$query);
				echo $query."<br>";
            }
            if (mb_strpos ($type,"Софа"))
            {
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (103,$id,15)";
                mysqli_query($db_connect,$query);
				echo $query."<br>";
            }
            //наполнение
            $lining=$arr[5];
            $lining=strip_tags($lining);
            $lining=str_replace("Наполнение "," ",$lining);
            if (mb_strpos ($lining,"без наполнителя"))
            {
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (33,$id,3)";
                mysqli_query($db_connect,$query);
				echo $query."<br>";
            }
            if (mb_strpos ($lining,"гранулы"))
            {
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (34,$id,3)";
                mysqli_query($db_connect,$query);
				echo $query."<br>";
            }
            if (mb_strpos ($lining,"змейка+прожинный блок"))
            {
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (35,$id,3)";
                mysqli_query($db_connect,$query);
				echo $query."<br>";
            }
            if (mb_strpos ($lining,"ламелевый блок"))
            {
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (36,$id,3)";
                mysqli_query($db_connect,$query);
				echo $query."<br>";
            }
            if (mb_strpos ($lining,"ламели+пенополиуретан"))
            {
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (37,$id,3)";
                mysqli_query($db_connect,$query);
				echo $query."<br>";
            }
            if (mb_strpos ($lining,"независимый пружинный блок"))
            {
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (39,$id,3)";
                mysqli_query($db_connect,$query);
				echo $query."<br>";
            }
            if (mb_strpos ($lining,"понополистерольные гранулы"))
            {
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (40,$id,3)";
                mysqli_query($db_connect,$query);
				echo $query."<br>";
            }
            if (mb_strpos ($lining,"пенополиуретан"))
            {
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (41,$id,3)";
                mysqli_query($db_connect,$query);
				echo $query."<br>";
            }
            if (mb_strpos ($lining,"пружинная змейка"))
            {
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (42,$id,3)";
                mysqli_query($db_connect,$query);
				echo $query."<br>";
            }
            if (mb_strpos ($lining,"пружинный блок"))
            {
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (43,$id,3)";
                mysqli_query($db_connect,$query);
				echo $query."<br>";
            }
            if (mb_strpos ($lining,"пружинная блок \"Bonelle\" "))
            {
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (44,$id,3)";
                mysqli_query($db_connect,$query);
				echo $query."<br>";
            }
            if (mb_strpos ($lining,"синтепон"))
            {
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (45,$id,3)";
                mysqli_query($db_connect,$query);
				echo $query."<br>";
            }
            if (mb_strpos ($lining,"фанера"))
            {
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (46,$id,3)";
                mysqli_query($db_connect,$query);
				echo $query."<br>";
            }
			
			//вид дивана 
			$kindof=$arr[0];
			$kindof=strip_tags($kindof);
			$kindof=str_replace("Виды дивана: "," ",$kindof);
			//echo "kindof =".$kindof."<br>";
			//echo "Тест прямые ".mb_strpos ($kindof,"Прямые диваны")."<br>";
			/*if (mb_strpos($kindof,"Прямые диваны"))
			{
				echo "!!!!!<br>";
			}
			else
			{
				echo "?????";
				echo gettype(mb_strpos ($kindof,"Прямые диваны"));
				echo "<br>";
			}*/
			
			
			if (mb_strpos ($kindof,"Прямые диваны")!=false)
			{
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (55,$id,6)";
                mysqli_query($db_connect,$query);
				echo $query."<br>";
			}
            if (false!=mb_strpos ($kindof,"Угловые диваны"))
            {
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (56,$id,6)";
                mysqli_query($db_connect,$query);
				echo $query."<br>";
            }
            if (mb_strpos ($kindof,"Модульные диваны"))
            {
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (57,$id,6)";
                mysqli_query($db_connect,$query);
				echo $query."<br>";
            }
            if (mb_strpos ($kindof,"Детские диваны"))
            {
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (63,$id,8)";
                mysqli_query($db_connect,$query);
				echo $query."<br>";
            }
            if (mb_strpos ($kindof,"Диваны для молодежи"))
            {
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (62,$id,8)";
                mysqli_query($db_connect,$query);
				echo $query."<br>";
            }
            if (mb_strpos ($kindof,"Для ежедневного сна"))
            {
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (60,$id,8)";
                mysqli_query($db_connect,$query);
				echo $query."<br>";
            }
            if (mb_strpos ($kindof,"Ортопедические диваны"))
            {
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (61,$id,6)";
                mysqli_query($db_connect,$query);
				echo $query."<br>";
            }
            if (mb_strpos ($kindof,"Диваны для гостинной"))
            {
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (67,$id,9)";
                mysqli_query($db_connect,$query);
				echo $query."<br>";
            }
            if (mb_strpos ($kindof,"Диваны для прихожей"))
            {
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (69,$id,9)";
                mysqli_query($db_connect,$query);
				echo $query."<br>";
            }
            if (mb_strpos ($kindof,"Диваны для кафе"))
            {
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (66,$id,9)";
                mysqli_query($db_connect,$query);
				echo $query."<br>";
            }
            if (mb_strpos ($kindof,"Диваны для офиса"))
            {
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (64,$id,9)";
                mysqli_query($db_connect,$query);
				echo $query."<br>";
            }
            if (mb_strpos ($kindof,"Диваны для дачи"))
            {
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (70,$id,9)";
                mysqli_query($db_connect,$query);
				echo $query."<br>";
            }
            if (mb_strpos ($kindof,"Диваны на кухню"))
            {
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (65,$id,9)";
                mysqli_query($db_connect,$query);
				echo $query."<br>";
            }
            if (mb_strpos ($kindof,"Малогабаритные диваны"))
            {
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (74,$id,11)";
                mysqli_query($db_connect,$query);
				echo $query."<br>";
            }
            if (mb_strpos ($kindof,"Бескаркасные диваны"))
            {
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (77,$id,12)";
                mysqli_query($db_connect,$query);
				echo $query."<br>";
            }
            if (mb_strpos ($kindof,"Диваны на металлокаркасе"))
            {
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (76,$id,12)";
                mysqli_query($db_connect,$query);
				echo $query."<br>";
            }
            //если не металокаркасс - то он деревянный. Исключая бескаркасные!!!
            else
            {
                if (mb_strpos ($kindof,"Бескаркасные диваны")===false)
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (78,$id,12)";
                mysqli_query($db_connect,$query);
                echo $query."<br>";
            }
            if (mb_strpos ($kindof,"Кожаные диваны"))
            {
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (79,$id,13)";
                mysqli_query($db_connect,$query);
				echo $query."<br>";
            }
            if (mb_strpos ($kindof,"Круглые диваны"))
            {
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (136,$id,11)";
                mysqli_query($db_connect,$query);
                echo $query."<br>";
            }
            if (mb_strpos ($kindof,"Для домашних животных"))
            {
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (138,$id,11)";
                mysqli_query($db_connect,$query);
                echo $query."<br>";
            }
            if (mb_strpos ($kindof,"Для домашнего кинотеатра"))
            {
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (137,$id,11)";
                mysqli_query($db_connect,$query);
                echo $query."<br>";
            }
            if (mb_strpos ($kindof,"Диваны для богатырей"))
            {
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (108,$id,11)";
                mysqli_query($db_connect,$query);
                echo $query."<br>";
            }
            if (mb_strpos ($kindof,"Ортопедические диваны"))
            {
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (61,$id,8)";
                mysqli_query($db_connect,$query);
                echo $query."<br>";
            }
            if (mb_strpos ($kindof,"Полукруглые диваны"))
            {
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (75,$id,11)";
                mysqli_query($db_connect,$query);
                echo $query."<br>";
            }
            if (mb_strpos ($kindof,"Диваны с деревянными элементами"))
            {
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (73,$id,11)";
                mysqli_query($db_connect,$query);
                echo $query."<br>";
            }

            //оббивка - ставим всем ткань по умолчанию
            $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (121,$id,13)";
            mysqli_query($db_connect,$query);
            echo $query."<br>";


			
			//фабрика feature_id=14
			$factory=$arr[3];
			echo $factory."<br>";
			$factory=strip_tags($factory);
			echo $factory."<br>";
			$factory=str_replace("Фабрика: "," ",$factory);
			echo $factory."<br>";
			switch ($factory)
			{
				case "Фабрика Рата":
					$query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (90,$id,14)";
					mysqli_query($db_connect,$query);
					echo $query."<br>";
					break;
				case "Фабрика Ливс":
					$query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (82,$id,14)";
					mysqli_query($db_connect,$query);
					echo $query."<br>";
					break;
				case "Фабрика СидиМ":
					$query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (83,$id,14)";
					mysqli_query($db_connect,$query);
					echo $query."<br>";
					break;
				case "Фабрика Лисогор":
					$query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (84,$id,14)";
					mysqli_query($db_connect,$query);
					echo $query."<br>";
					break;
				case "Мебель Софиевки":
					$query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (85,$id,14)";
					mysqli_query($db_connect,$query);
					echo $query."<br>";
					break;
				case "УкрИзраМебель":
					$query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (86,$id,14)";
					mysqli_query($db_connect,$query);
					echo $query."<br>";
					break;
				case "Фабрика Daniro":
					$query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (87,$id,14)";
					mysqli_query($db_connect,$query);
					echo $query."<br>";
					break;
				case "Фабрика Уют":
					$query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (88,$id,14)";
					mysqli_query($db_connect,$query);
					echo $query."<br>";
					break;
				case "Фабрика Катунь":
					$query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (89,$id,14)";
					mysqli_query($db_connect,$query);
					echo $query."<br>";
					break;
				case "Фабрика Бис-М":
					$query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (91,$id,14)";
					mysqli_query($db_connect,$query);
					echo $query."<br>";
					break;
				case "Фабрика AFCI":
					$query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (92,$id,14)";
					mysqli_query($db_connect,$query);
					echo $query."<br>";
					break;
				case "Фабрика Софа":
					$query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (93,$id,14)";
					mysqli_query($db_connect,$query);
					echo $query."<br>";
					break;
				case "Фабрика Старски":
					$query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (94,$id,14)";
					mysqli_query($db_connect,$query);
					echo $query."<br>";
					break;
				case "Фабрика КМ":
					$query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (95,$id,14)";
					mysqli_query($db_connect,$query);
					echo $query."<br>";
					break;
				case "Фабрика Вика":
					$query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (96,$id,14)";
					mysqli_query($db_connect,$query);
					echo $query."<br>";
					break;
				case "Фабрика Сокме":
					$query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (97,$id,14)";
					mysqli_query($db_connect,$query);
					echo $query."<br>";
					break;
				case "Фабрика Агат-М":
					$query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (98,$id,14)";
					mysqli_query($db_connect,$query);
					echo $query."<br>";
					break;
				case "Распродажа":
					$query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (122,$id,14)";
					mysqli_query($db_connect,$query);
					echo $query."<br>";
					break;
				case "Арман мебель":
					$query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (123,$id,14)";
					mysqli_query($db_connect,$query);
					echo $query."<br>";
					break;
				case "Фабрика Алекс-Мебель":
					$query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (124,$id,14)";
					mysqli_query($db_connect,$query);
					echo $query."<br>";
					break;
				case "Мебель Сервис":
					$query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (125,$id,14)";
					mysqli_query($db_connect,$query);
					echo $query."<br>";
					break;
				case "Фабрика Маген":
					$query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (123,$id,26)";
					mysqli_query($db_connect,$query);
					echo $query."<br>";
					break;
			}
			//break;
        }
    }
    mysqli_close($db_connect);
}
function del_filters()
{
    $db_connect=mysqli_connect(host,user,pass,db);
    $query="DELETE FROM goodshasfeature WHERE feature_id<>2 AND feature_id<>10 AND feature_id<>14";
	mysqli_query($db_connect,$query);
	mysqli_close($db_connect);
}
//////////////////////////////////////////
$runtime = new Timer();
$runtime->setStartTime();
echo "Deleteing old features... ";
set_time_limit(2000);
del_filters();
echo "Done!<br>";
export_filters();
$runtime->setEndTime();
echo "<br> runtime=".$runtime->getRunTime()." sec <br>";
//////////////////////////////////////////
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

?>
