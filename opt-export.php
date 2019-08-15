<?php
header('Content-Type: text/html; charset=utf-8');
/**
 * database host
 */
//define ("host","localhost");
/**
 *
 */
define ("host","localhost");
/**
 * database username
 */
//define ("user", "root");
define ("user", "optmebli");
/**
 * database password
 */
//define ("pass", "");
define ("pass", "VRYA1Q0R");
/**
 * database name
 */
//define ("db", "opt");
define ("db", "optmebli");

class ExportSHK
{
    private function getGoods($catId)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goods_id from goods WHERE category_id=$catId";
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
        mysqli_close($db_connect);
        if (is_array($goods))
        {
            return $goods;
        }
        else
        {
            return null;
        }
    }

    private function getName ($id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goodshaslang_name from goodshaslang WHERE goods_id=$id AND lang_id=1";
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
        mysqli_close($db_connect);
        if (is_array($goods))
        {
            return $goods[0]['goodshaslang_name'];
        }
        else
        {
            return null;
        }
    }

    private function getSizes($id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        
        mysqli_close($db_connect);
    }
}