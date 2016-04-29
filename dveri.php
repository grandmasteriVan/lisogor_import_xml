<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 29.04.16
 * Time: 09:36
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

/**
 * @param $factoryId int - id фабрики
 * выбираем цены по фабрике и записываем их в файл price.csv
 */
function getPrice($factoryId)
{
    $db_connect=mysqli_connect(host,user,pass,db);
    $query="SELECT goods_id, goods_price FROM goods WHERE factory_id=$factoryId";
    if ($res=mysqli_query($db_connect,$query))
    {
        print_r ($res);
		echo "Hi!";
		while ($row=mysqli_fetch_assoc($res))
        {
            $arr[]=$row;
			echo "ni!";
        }
        echo "<pre>";
		print_r($arr);
		echo "</pre>";
		$len=count($arr);
		for ($i=0; $i<$len; $i++)
        {
            //echo $i;
			$tmp=$arr[$i]['goods_id'].";".$arr[$i]['goods_price'].PHP_EOL;
            echo $tmp.PHP_EOL;
			file_put_contents('price.csv',$tmp,FILE_APPEND);
        }
    }
}

function setPrice()
{
    $db_connect=mysqli_connect(host,user,pass,db);
    $arr=fgetcsv("price.csv");
    echo "<pre>";
    print_r($arr);
    echo "</pre>";

}



//getPrice(79);
setPrice();

?>
