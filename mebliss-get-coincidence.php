<?php
header('Content-Type: text/html; charset=utf-8');
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

define ("host_meb","localhost");
define ("user_meb", "root");
define ("pass_meb", "");
define ("db_meb", "meblis");


class SearhcCoincidence
{
    private function getMeblissGoods()
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="select product_id,product from cscart_product_descriptions WHERE lang_code='ru'";
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
        if (is_array ($goods))
        {
            return $goods;
        }
        else
        {
            return null;
        }
    }

    private function getFMGoods()
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="select goods_id,goodshaslang_name from goodshaslang WHERE lang_id=1";
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
        if (is_array ($goods))
        {
            return $goods;
        }
        else
        {
            return null;
        }
    }

    private function stripName($name)
    {
        $name_clean=str_replace("\"","",$name);
        $name_clean=str_replace("Угловой ","",$name_clean);
        $name_clean=str_replace("диван  ","",$name_clean);
        $name_clean=str_replace("Диван "  ,"",$name_clean);

    }

    public 

}