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
define ("user", "root");
//define ("user", "newfm");
/**
 * database password
 */
define ("pass", "");
//define ("pass", "N0r7F8g6");
/**
 * database name
 */
define ("db", "fm_new");
//define ("db", "newfm");

	function delAllVid($cont)
	{
		$cont_new=preg_replace("'<iframe[^>]*?>.*?</iframe>'si","",$cont);
		return $cont_new;
	}

	function getVidId($cont)
    {
        //echo "Whghgh<pre>";
        preg_match_all('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $cont, $videoId);
        //echo count ($videoId)."<br>";
        return $videoId;
    }
	
	function getGoodsWithVid()
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="select goods_id, goodshaslang_content from goodshaslang where lang_id=1 AND goodshaslang_content LIKE '%iframe%' AND goodshaslang_active=1";
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
		if (is_array($goods))
		{
			return $goods;
		}
		else
		{
			return null;
		}
	}
	
	function writeVidInGal($vids)
	{
		
	}
	
	function VidsFromContToGal()
	{
		$goods=getGoodsWithVid();
		if (is_array($goods))
		{
			foreach ($goods as $good)
			{
				$id=$good['goods_id'];
				$cont=$good['goodshaslang_content'];
				$cont=str_replace("?rel=0","",$cont);
				$cont=str_replace(" width=\"560\"","",$cont);
				$cont=str_replace(" width=\"420\"","",$cont);
				
				$vids=getVidId($cont);
				echo "$id:";
				echo "<pre>";
				print_r($vids);
				echo "</pre>";
				
			}
		}
		else
		{
			echo "No goods!<br>";
		}
	}
	
	VidsFromContToGal();
	
	