<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 22.12.17
 * Time: 09:20
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
function set_info($f_id)
{
    $query="SELECT goods_id, goods_content FROM goods WHERE factory_id=$f_id";
    $db_connect=mysqli_connect(host,user,pass,db);
    if ($res=mysqli_query($db_connect,$query))
    {
        while ($row=mysqli_fetch_assoc($res))
        {
            $arr[]=$row;
        }
        foreach ($arr as $row)
        {
            //$row['goods_content']=iconv("Windows-1251","UTF-8",$row['goods_content']);
            //$row['goods_hkeyw']=iconv("Windows-1251","UTF-8",$row['goods_hkeyw']);
            //$row['goods_fkeyw']=iconv("Windows-1251","UTF-8",$row['goods_fkeyw']);
            $id=$row['goods_id'];
            $desc="<p><b>Цены могут измениться, уточняйте у менеджеров!</b></p><p></p>".$row['goods_content'];
            $query="UPDATE goods SET goods_content='$desc' WHERE goods_id=$id";
            mysqli_query($db_connect,$query);
            //echo $query."<br>";
            echo "$id is changed<br>";
            //break;
        }
    }
}

function rem_info($f_id)
{
    $query="SELECT goods_id, goods_content FROM goods WHERE factory_id=$f_id";
    $db_connect=mysqli_connect(host,user,pass,db);
    if ($res=mysqli_query($db_connect,$query))
    {
        while ($row=mysqli_fetch_assoc($res))
        {
            $arr[]=$row;
        }
        foreach ($arr as $row)
        {
            $id=$row['goods_id'];
            $desc=$row['goods_content'];
            $desc=str_replace("<p><b>Цены могут измениться, уточняйте у менеджеров!</b></p><p></p>","",$desc)
            $query="UPDATE goods SET goods_content='$desc' WHERE goods_id=$id";
            mysqli_query($db_connect,$query);
            //echo $query."<br>";
            echo "$id is changed<br>";
            //break;
        }
    }
}


//set_info(115);
//set_info(118);
//set_info(20);

rem_info(115);
rem_info(118);
rem_info(20);


?>
