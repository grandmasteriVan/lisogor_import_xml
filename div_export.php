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
function export()
{
    $db_connect=mysqli_connect(host,user,pass,db);
    $query="SELECT goods_id, goods_exfeature FROM goods";
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
            echo $feat."<br>";
			echo "<pre>";
            print_r($arr);
            echo  "</pre>";
			
			//вид дивана 
			$kindof=$arr[0];
			$kindof=strip_tags(kindof);
			$kindof=str_replace("Виды дивана: ","",$kindof);
			
			//фабрика feature_id=14
			$factory=$arr[3];
			echo $factory."<br>";
			$factory=strip_tags($factory);
			echo $factory."<br>";
			$factory=str_replace("Фабрика: ","",$factory);
			echo $factory."<br>";
			switch ($factory)
			{
				"Фабрика Рата":
					$query="INSERT INTO (goodshasfeature_valueid, goods_id, feature_id) VALUES (90,$id,14)";
					mysqli_query($db_connect,$query);
					echo $query."<br>";
					break;
				"Фабрика Ливс":
					$query="INSERT INTO (goodshasfeature_valueid, goods_id, feature_id) VALUES (82,$id,14)";
					mysqli_query($db_connect,$query);
					echo $query."<br>";
					break;
				"Фабрика СидиМ":
					$query="INSERT INTO (goodshasfeature_valueid, goods_id, feature_id) VALUES (83,$id,14)";
					mysqli_query($db_connect,$query);
					echo $query."<br>";
					break;
				"Фабрика Лисогор":
					$query="INSERT INTO (goodshasfeature_valueid, goods_id, feature_id) VALUES (84,$id,14)";
					mysqli_query($db_connect,$query);
					echo $query."<br>";
					break;
				"Мебель Софиевки":
					$query="INSERT INTO (goodshasfeature_valueid, goods_id, feature_id) VALUES (85,$id,14)";
					mysqli_query($db_connect,$query);
					echo $query."<br>";
					break;
				"УкрИзраМебель":
					$query="INSERT INTO (goodshasfeature_valueid, goods_id, feature_id) VALUES (86,$id,14)";
					mysqli_query($db_connect,$query);
					echo $query."<br>";
					break;
				"Фабрика Daniro":
					$query="INSERT INTO (goodshasfeature_valueid, goods_id, feature_id) VALUES (87,$id,14)";
					mysqli_query($db_connect,$query);
					echo $query."<br>";
					break;
				"Фабрика Уют":
					$query="INSERT INTO (goodshasfeature_valueid, goods_id, feature_id) VALUES (88,$id,14)";
					mysqli_query($db_connect,$query);
					echo $query."<br>";
					break;
				"Фабрика Катунь":
					$query="INSERT INTO (goodshasfeature_valueid, goods_id, feature_id) VALUES (89,$id,14)";
					mysqli_query($db_connect,$query);
					echo $query."<br>";
					break;
				"Фабрика Бис-М":
					$query="INSERT INTO (goodshasfeature_valueid, goods_id, feature_id) VALUES (91,$id,14)";
					mysqli_query($db_connect,$query);
					echo $query."<br>";
					break;
				"Фабрика AFCI":
					$query="INSERT INTO (goodshasfeature_valueid, goods_id, feature_id) VALUES (92,$id,14)";
					mysqli_query($db_connect,$query);
					echo $query."<br>";
					break;
				"Фабрика Софа":
					$query="INSERT INTO (goodshasfeature_valueid, goods_id, feature_id) VALUES (93,$id,14)";
					mysqli_query($db_connect,$query);
					echo $query."<br>";
					break;
				"Фабрика Старски":
					$query="INSERT INTO (goodshasfeature_valueid, goods_id, feature_id) VALUES (94,$id,14)";
					mysqli_query($db_connect,$query);
					echo $query."<br>";
					break;
				"Фабрика КМ":
					$query="INSERT INTO (goodshasfeature_valueid, goods_id, feature_id) VALUES (95,$id,14)";
					mysqli_query($db_connect,$query);
					echo $query."<br>";
					break;
				"Фабрика Вика":
					$query="INSERT INTO (goodshasfeature_valueid, goods_id, feature_id) VALUES (96,$id,14)";
					mysqli_query($db_connect,$query);
					echo $query."<br>";
					break;
				"Фабрика Сокме":
					$query="INSERT INTO (goodshasfeature_valueid, goods_id, feature_id) VALUES (97,$id,14)";
					mysqli_query($db_connect,$query);
					echo $query."<br>";
					break;
				"Фабрика Агат-М":
					$query="INSERT INTO (goodshasfeature_valueid, goods_id, feature_id) VALUES (98,$id,14)";
					mysqli_query($db_connect,$query);
					echo $query."<br>";
					break;
				"Распродажа":
					$query="INSERT INTO (goodshasfeature_valueid, goods_id, feature_id) VALUES (122,$id,14)";
					mysqli_query($db_connect,$query);
					echo $query."<br>";
					break;
				"Арман мебель":
					$query="INSERT INTO (goodshasfeature_valueid, goods_id, feature_id) VALUES (123,$id,14)";
					mysqli_query($db_connect,$query);
					echo $query."<br>";
					break;
				"Фабрика Алекс-Мебель":
					$query="INSERT INTO (goodshasfeature_valueid, goods_id, feature_id) VALUES (124,$id,14)";
					mysqli_query($db_connect,$query);
					echo $query."<br>";
					break;
				"Мебель Сервис":
					$query="INSERT INTO (goodshasfeature_valueid, goods_id, feature_id) VALUES (125,$id,14)";
					mysqli_query($db_connect,$query);
					echo $query."<br>";
					break;
				"Фабрика Маген":
					$query="INSERT INTO (goodshasfeature_valueid, goods_id, feature_id) VALUES (123,$id,26)";
					mysqli_query($db_connect,$query);
					echo $query."<br>";
					break;
			}
			break;
        }
    }
    mysqli_close($db_connect);
}
//////////////////////////////////////////
export();

?>
