<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 08.08.16
 * Time: 12:10
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

            //переименовываем позицию
            $name=str_replace(UTF8toCP1251("Шкаф-купе "),"",$name);
            $name=str_replace(UTF8toCP1251("Шкаф "),"",$name);
            $name=str_replace(UTF8toCP1251("шкаф "),"",$name);
            $name=str_replace(UTF8toCP1251("купе "),"",$name);
            $name=str_replace(UTF8toCP1251("Купе  "),"",$name);
            $name="Шкаф-купе ".$name;
            $name=UTF8toCP1251($name);
            $query="UPDATE goods SET goods_name='$name' WHERE goods_id=$id";
            mysqli_query($db_connect,$query);
            $query="SELECT * FROM goodshasfeature WHERE goods_id=$id";
            if ($res=mysqli_query($db_connect,$query))
            {
                while ($row = mysqli_fetch_assoc($res))
                {
                    $features[] = $row;
                }
                foreach ($features as $feature)
                {
                    $feature_id=$feature['feature_id'];
                    $value=$feature['goodshasfeature_valueint'];


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
                    echo "$query <br>";
                    //современный-модный
                    $query="INSERT INTO goodshasfeature (goodshasfeature_valueint, goodshasfeature_valuefloat, ".
                        "goodshasfeature_valuetext, goods_id, feature_id) ".
                        "VALUES (10,0,'',$id,18)";
                    mysqli_query($db_connect,$query);
                    echo "$query <br>";
                    //стильный-красивый
                    $query="INSERT INTO goodshasfeature (goodshasfeature_valueint, goodshasfeature_valuefloat, ".
                        "goodshasfeature_valuetext, goods_id, feature_id) ".
                        "VALUES (11,0,'',$id,18)";
                    mysqli_query($db_connect,$query);
                    echo "$query <br>";


                    //32 - id количество дверей
                    //количество дверей
                    if ($feature_id=32)
                    {
                        //одна дверь
                        if ($value==1)
                        {
                            //удаляем старые записи
                            $query="DELETE FROM goodshasfuture WHERE fearure_id=32 AND goods_id=$id";
                            mysqli_query($db_connect,$query);
                            echo "$query <br>";
                            //записываем новый фильтр
                            $query="INSERT INTO goodshasfeature (goodshasfeature_valueint, goodshasfeature_valuefloat, ".
                                "goodshasfeature_valuetext, goods_id, feature_id) ".
                                "VALUES (13,0,'',$id,117)";
                            mysqli_query($db_connect,$query);
                            echo "$query <br>";
                        }
                        //две двери
                        if ($value==2)
                        {
                            //удаляем старые записи
                            $query="DELETE FROM goodshasfuture WHERE fearure_id=32";
                            mysqli_query($db_connect,$query);
                            echo "$query <br>";
                            //записываем новый фильтр
                            $query="INSERT INTO goodshasfeature (goodshasfeature_valueint, goodshasfeature_valuefloat, ".
                                "goodshasfeature_valuetext, goods_id, feature_id) ".
                                "VALUES (8,0,'',$id,117)";
                            mysqli_query($db_connect,$query);
                            echo "$query <br>";
                        }
                        //три двери
                        if ($value==5)
                        {
                            //удаляем старые записи
                            $query="DELETE FROM goodshasfuture WHERE fearure_id=32";
                            mysqli_query($db_connect,$query);
                            echo "$query <br>";
                            //записываем новый фильтр
                            $query="INSERT INTO goodshasfeature (goodshasfeature_valueint, goodshasfeature_valuefloat, ".
                                "goodshasfeature_valuetext, goods_id, feature_id) ".
                                "VALUES (9,0,'',$id,117)";
                            mysqli_query($db_connect,$query);
                            echo "$query <br>";
                        }
                        //четыре двери
                        if ($value==3)
                        {
                            //удаляем старые записи
                            $query="DELETE FROM goodshasfuture WHERE fearure_id=32";
                            mysqli_query($db_connect,$query);
                            echo "$query <br>";
                            //записываем новый фильтр
                            $query="INSERT INTO goodshasfeature (goodshasfeature_valueint, goodshasfeature_valuefloat, ".
                                "goodshasfeature_valuetext, goods_id, feature_id) ".
                                "VALUES (10,0,'',$id,117)";
                            mysqli_query($db_connect,$query);
                            echo "$query <br>";
                        }
                    }
                }
            }


        }
    }
    mysqli_close($db_connect);

}

?>