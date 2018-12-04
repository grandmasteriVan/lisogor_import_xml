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
//define ("db", "fm_new");
define ("db", "newfm");

class imgCopy
{
	//достаем список товаров, являющихся модификацией родителя
	private function getModGoods($parrent_id)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="select goods_id from goods WHERE goods_parent=$parrent_id";
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
	
	private function getPicExt($id)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="select goods_pict from goods WHERE goods_id=$id";
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
			return $goods[0]['goods_pict'];
		}
		else
		{
			return null;
		}
	}
	
	private function copyPictures($sourse_id, $dest_id)
	{
		$pict_ext=$this->getPicExt($sourse_id);
		$sourse=$_SERVER['DOCUMENT_ROOT']."/content/goods/".$sourse_id."/picture-$sourse_id.".$pict_ext;
		$dest=$_SERVER['DOCUMENT_ROOT']."/content/goods/".$dest_id."/picture-$dest_id.".$pict_ext;
		echo "sourse=$sourse<br>dest=$dest<br>";
		copy ($sourse,$dest);
		$pict_ext=$this->getPicExt($sourse_id);
		$sourse=$_SERVER['DOCUMENT_ROOT']."/content/goods/".$sourse_id."/preview-$sourse_id.".$pict_ext;
		$dest=$_SERVER['DOCUMENT_ROOT']."/content/goods/".$dest_id."/preview-$dest_id.".$pict_ext;
		echo "sourse=$sourse<br>dest=$dest<br><br>";
		copy ($sourse,$dest);
	}
	
	private function getIdByArticle($article)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="select goods_id from goods WHERE goods_article=$article";
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
			//var_dump($goods);
			return $goods[0]['goods_id'];
		}
		else
		{
			return null;
		}
	}
	
	
	public function copyImg($article)
	{
		$id=$this->getIdByArticle($article);
		echo "id=$id<br>";
		$mod_goods=$this->getModGoods($id);
		if (is_array($mod_goods))
		{
			foreach ($mod_goods as $mod_good)
			{
				$mod_id=$mod_good['goods_id'];
				if ($id!=$mod_id)
				{
					$this->copyPictures($id,$mod_id);
				}
				
			}
		}
		else
		{
			echo "no mog goods for art=$article ($id)<br>";
		}
	}
}

$test=new imgCopy();
$test->copyImg(1402995);
$test->copyImg(1402997);
$test->copyImg(1403088);
$test->copyImg(1409482);
$test->copyImg(1403011);
$test->copyImg(1427534);
$test->copyImg(1427520);
$test->copyImg(1403091);
$test->copyImg(1409451);
$test->copyImg(1403012);
$test->copyImg(1409467);
$test->copyImg(1402993);
$test->copyImg(1403081);