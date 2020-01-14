<?php
header('Content-Type: text/html; charset=utf-8');
ini_set('display_errors', 1);
/**
 * database host
 */
//define ("host","localhost");
define ("host","localhost");
/**
 * database username
 */
//define ("user", "root");
define ("user", "newfm");
/**
 * database password
 */
//define ("pass", "");
define ("pass", "N0r7F8g6");
/**
 * database name
 */
//define ("db", "new_fm");
define ("db", "newfm");


define ("host_old","localhost");
define ("user_old", "fm");
define ("pass_old", "T6n7C8r1");
define ("db_old", "fm");
//правка фильтров по ШК гарант

	function delFeature($goods_id, $feature_id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="DELETE FROM goodshasfeature WHERE goods_id=$goods_id AND feature_id=$feature_id";
        echo "$query<br>";
        mysqli_query($db_connect,$query);
        mysqli_close($db_connect);
    }

   function insFilter($goods_id, $feature_id, $value_id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="INSERT INTO goodshasfeature (goods_id, feature_id, goodshasfeature_valueid) VALUES ($goods_id, $feature_id, $value_id)";
        echo "$query<br>";
        mysqli_query($db_connect,$query);
        mysqli_close($db_connect);
    }
    
	function getGoodsByFactory ($f_id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goods_id FROM goodshasfeature WHERE feature_id=232 AND goodshasfeature_valueid=$f_id";
        if ($res=mysqli_query($db_connect,$query))
        {
                while ($row = mysqli_fetch_assoc($res))
                {
                    $goods[] = $row;
                }
        }
        else
        {
            echo "Error in SQL: $query<br>";		
		}
		//var_dump($goods);
		mysqli_close($db_connect);
		//var_dump ($goods);
        if (is_array($goods))
        {
            return $goods;
        }
        else
        {
            return null;
        }
        
	}

	function getName($id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goodshaslang_name FROM goodshaslang WHERE goods_id=$id AND lang_id=1";
        if ($res=mysqli_query($db_connect,$query))
        {
                while ($row = mysqli_fetch_assoc($res))
                {
                    $names[] = $row;
                }
        }
        else
        {
             echo "Error in SQL: $query<br>";		
        }
        mysqli_close($db_connect);
        if (is_array($names))
        {
            return $names[0]['goodshaslang_name'];
        }
        else
        {
            return null;
        }
	}
	
    $goods=getGoodsByFactory(93);
    //var_dump ($goods);
	foreach ($goods as $good)
	{
		$id=$good['goods_id'];
		$name=getName($id);
		//echo "$name";
        //if (strripos($name,"четырехдверный ")!=false)
        //{
        //    echo "yay!<br>";
        //    delFeature($id,291);
        //    insFilter($id,291,3516);
        //    //break;
        //}
        //break;
        delFeature($id,295);
        insFilter($id,295,3343);
        insFilter($id,295,3344);
        insFilter($id,295,3345);
        insFilter($id,295,3346);
        insFilter($id,295,3347);
        insFilter($id,295,3348);
        insFilter($id,295,3349);

	}