<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 18.01.2018
 * Time: 09:26
 */

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
define ("user", "fm");
/**
 * database password
 */
//define ("pass", "");
define ("pass", "T6n7C8r1");
/**
 * database name
 */
//define ("db", "mebli");
define ("db", "fm");
class FontSize
{
    private function getGoods()
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goods_id, goods_content FROM goods WHERE goods_contrnt!=''";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row=mysqli_fetch_assoc($res))
            {
                $goods[]=$row;
            }
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

    private function replaceSize($text)
    {
        $text=preg_replace("font-size/:\d\dpt;","font-size:12pt;",$text);
        return $text;
    }

    private function insertSize($text)
    {
        $text=str_replace("<p>","<p font-size:12pt>",$text);

        return $text;
    }

    private function checkType($text)
    {
        if (mb_strpos("font-size",$text))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

}