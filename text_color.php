<?php
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

function text_color($factory_id)
{
	//echo "Y!";
	$db_connect=mysqli_connect(host,user,pass,db);
    $query="SELECT goods_id, goods_content FROM goods WHERE factory_id=$factory_id";
	if ($res=mysqli_query($db_connect,$query))
    {
        
		while ($row = mysqli_fetch_assoc($res))
        {
            $arr[] = $row;
        }
		//print_r($arr);
		foreach ($arr as $matr)
		{
			$id=$matr['goods_id'];
			$cont=$matr['goods_content'];
			$new_cont=str_replace("rgb(51, 51, 51)","rgb(0, 0, 0)",$cont);
			$new_cont=str_replace("rgb(136, 136, 136)","rgb(0, 0, 0)",$new_cont);
			
			echo "NEW: $new_cont<br>";
			$query="UPDATE goods SET goods_content='$new_cont' WHERE goods_id=$id";
			mysqli_query($db_connect,$query);
			echo "$query<br>";

		}
    }
    mysqli_close($db_connect);
}
text_color(139);
?>