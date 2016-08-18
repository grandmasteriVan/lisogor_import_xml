<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 18.08.16
 * Time: 09:35
 */
/**
 * database host
 */
//define ("host","localhost");
define ("host","10.0.0.2");
/**
 * database username
 */
//define ("user", "root");
define ("user", "uh333660_mebli");
/**
 * database password
 */
//define ("pass", "");
define ("pass", "Z7A8JqUh");
/**
 * database name
 */
//define ("db", "mebli");
define ("db", "uh333660_mebli");
function get_product_list()
{
    $db_connect=mysqli_connect(host,user,pass,db);
    $query="SELECT goods_article, goods_name FROM goods WHERE goods_content='' AND goods_noactual=0 AND goods_active=1";
    if ($res=mysqli_query($db_connect,$query))
    {
        while ($row=mysqli_fetch_assoc($res))
        {
            $arr[]=$row;
        }
        $len=count($arr);
        for ($i=0;$i<$len;$i++)
        {
            $str=$arr[$i]['goods_article'].", ".$arr[$i]['goods_name'].PHP_EOL;
			echo $str."<br>";
            file_put_contents('no_desc.txt',$str,FILE_APPEND);
        }
    }
    mysqli_close($db_connect);
	echo "Done!";
}
get_product_list()
?>
