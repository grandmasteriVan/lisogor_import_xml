<?php
//header('Content-Type: text/html; charset=utf-8');
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
//define ("db", "fm_new");
define ("db", "newfm");

function getGoods()
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="select goods_id, goodshaslang_content from goodshaslang where lang_id=1 AND goodshaslang_active=1 AND goodshaslang_content LIKE '%img%'";
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
	
	function writeCont($id,$cont)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="UPDATE goodshaslang SET goodshaslang_content='$cont' WHERE goods_id=$id AND lang_id=1";
		mysqli_query($db_connect,$query);
		//echo $query;
		mysqli_close($db_connect);
	}
	
	function cleanImg($cont)
	{
		/*$doc = new DOMDocument(); 
		$doc->loadHTML($cont);
		//var_dump($doc);
		// Измените селектор на тот, что вам нужен
		$elements = $doc->getElementsByTagName('img');
		foreach ($elements as $element)
		{
			$attributes = $element->attributes;
			var_dump ($attributes);
			while ($attributes->length) 
			{
				// Удаляем атрибуты по одному, пока не будут удалены все из них
				$element->removeAttributeNode($attributes->item(0));
			}
			
		}	
		echo $doc->saveHTML();
		//var_dump($doc);*/
		//$text = '<p style="padding:0px;"><strong style="padding:0;margin:0;">hello</strong></p>';

		//echo preg_replace("/<([a-z][a-z0-9]*)[^>]*?(\/?)>/i",'<$1$2>', $cont);
		
		
		preg_match_all("/<img.+\/>/", $cont, $match);
		//var_dump ($match);
		$images=$match[0];
		//var_dump ($images);
		foreach ($images as $img)
		{
			$old_img=$img;
			//$img=str_replace(">","/>",$img);
			$img=preg_replace("/\w+(?<!align|title|alt|src)=\".+?\//","",$img);
			//echo $img."<br>";
			$img=str_replace(">","></p>",$img);
			$img=str_replace("<img","<p class=\"responsive_img\"><img",$img);
			echo $img."<br>";
			//break;
			$cont=str_replace($old_img,$img,$cont);
			//break;
			
			
			
		}
		echo $cont;
		return $cont;
		//
	}
	
	
	function cleanTegs()
	{
		$goods=getGoods();
		if (is_array($goods))
		{
			foreach ($goods as $good)
			{
				$id=$good['goods_id'];
				$cont=$good['goodshaslang_content'];
				$cont=cleanImg($cont);
				writeCont($id,$cont);
				echo "$id";
				//if ($id==18582)
				//{
					//echo "Im in!<br>";
					//var_dump($cont);
					//$cont=cleanImg($cont);
					//writeCont($id,$cont);
					//break;
				//}
				
				
			}
		}
		else
		{
			echo "No goods!";
		}
	}
	
	cleanTegs();