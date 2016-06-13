<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 01.06.16
 * Time: 10:22
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
/**
 * возвращает список всех матрасов, которые не являются модификацией (т.е. они - родительский товар)
 * @return array
 */
function parrent_matr()
{
    $db_connect=mysqli_connect(host,user,pass,db);
    $query="SELECT goods_id, goods_parent, goods_width FROM goods WHERE goodskind_id=40 and goods_parent=0 AND factory_id=35";
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
 * возврвщает список всех матрасов, и родителей и модификаций
 * @return array
 */
function all_matr()
{
    $db_connect=mysqli_connect(host,user,pass,db);
    $query="SELECT goods_id, goods_parent, goods_width FROM goods WHERE goodskinfd_id=40 AND factory_id=35";
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
/**
 * возвращает список в котором есть только модификации матрасов
 * @return array
 */
function mod_matr()
{
    $db_connect=mysqli_connect(host,user,pass,db);
    $query="SELECT goods_id, goods_parent, goods_width FROM goods WHERE goodskind_id=40 AND goods_parent<>0 AND factory_id=35";
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
/**
 *
 */
function copy_filters()
{
    $db_connect=mysqli_connect(host,user,pass,db);
    $parent_list=parrent_matr();
    $mod_list=mod_matr();
    foreach ($parent_list as $parent)
    {
        //выбираем список фич для родительского матраса
        $parrent_id=$parent['goods_id'];
        $query="SELECT * FROM goodshasfeature WHERE goods_id=$parrent_id";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row=mysqli_fetch_assoc($res))
            {
                $features[]=$row;
            }
			print_r($features);
			/*print_r($features);
			$features=array_unique($features,SORT_REGULAR);
			echo "<br><b>uniq</b><br><b>";
			print_r($features);
			echo "</b>";*/
        }
        foreach($mod_list as $mod)
        {
            if ($parent['goods_id']==$mod['goods_parent'])
            {
                $mod_id=$mod['goods_id'];
				$mod_size=$mod['goods_width'];
				echo "<br><b>$mod_size</b><br>";
                //дропаем старые записи
                $query="DELETE FROM goodshasfeature WHERE goods_id=$mod_id";
                //mysqli_query($db_connect,$query);
				echo $query."<br>";
                //для каждой фичи записываем ее в БД
                foreach ($features as $feat)
                {
                    $goodshasfeature_valueint=$feat['goodshasfeature_valueint'];
                    $goodshasfeature_valuefloat=$feat['goodshasfeature_valuefloat'];
                    $goodshasfeature_valuetext=$feat['goodshasfeature_valuetext'];
                    $feature_id=$feat['feature_id'];
					//пишем размерность (одно/полтора/двуспальные)
					if ($feature_id==131)
					{
						if ($mod_size<=900)
						{
							$goodshasfeature_valueint=1;
						}
						if ($mod_size>900&&$mod_size<=1500)
						{
							$goodshasfeature_valueint=2;
						}
						if ($mod_size>1500)
						{
							$goodshasfeature_valueint=3;
						}
					}
					//не пишем ненужные значния
					if ($feature_id==131||$feature_id==127||$feature_id==128||$feature_id==33||$feature_id==52||$feature_id==53||$feature_id==54||$feature_id==55||$feature_id==56||$feature_id==130)
					{
						$query="INSERT INTO goodshasfeature (goodshasfeature_valueint, goodshasfeature_valuefloat, ".
							"goodshasfeature_valuetext, goods_id, feature_id) ".
							"VALUES ($goodshasfeature_valueint, $goodshasfeature_valuefloat, ".
							"$goodshasfeature_valuetext, $mod_id, $feature_id)";
						//mysqli_query($db_connect,$query);
						echo $query."<br>";
					}
                    
                }
            }
        }
    }
}

copy_filters();

?>
