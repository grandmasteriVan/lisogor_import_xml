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

class ContentCopy
{
	private function getRefCont ($id)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="select goodshaslang_content from goodshaslang WHERE goods_id=$id AND lang_id=1";
		if ($res=mysqli_query($db_connect,$query))
		{
				while ($row = mysqli_fetch_assoc($res))
				{
					$cont[] = $row;
				}
		}
		else
		{
			 echo "Error in SQL: $query<br>";		
		}
		mysqli_close($db_connect);
		if (is_array($cont))
		{
			return $cont[0]['goodshaslang_content'];
		}
		else
		{
			return null;
		}
	}
	
	private function setCont($id,$cont)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="UPDATE goodshaslang SET goodshaslang_content='$cont' WHERE goods_id=$id AND lang_id=1";
		//echo "$query<br><br>";
		echo "$id rewrited!<br>";
		mysqli_query($db_connect,$query);
		mysqli_close($db_connect);
	}
	
	private function getFeatures($good_id)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="select goodshasfeature_valueid, feature_id from goodshasfeature WHERE goods_id=$good_id";
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
	
	private function getGoods($cat_id, $f_id)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="select goods_id from goodshascategory WHERE category_id=$cat_id";
		if ($res=mysqli_query($db_connect,$query))
		{
				while ($row = mysqli_fetch_assoc($res))
				{
					$goods_all[] = $row;
				}
		}
		else
		{
			 echo "Error in SQL: $query<br>";		
		}
		if (is_array ($goods_all))
		{
			foreach ($goods_all as $good)
			{
				$id=$good['goods_id'];
				$features=$this->getFeatures($id);
				if (is_array($features))
				{
					foreach ($features as $feature)
					{
						$feature_id=$feature['feature_id'];
						$val_id=$feature['goodshasfeature_valueid'];
						if ($feature_id==232&&$val_id==$f_id)
						{
							$goods_by_factoty[]=$id;
							break;
						}
					}
				}
			}
		}
		
		mysqli_close($db_connect);
		if (is_array($goods_by_factoty))
		{
			return $goods_by_factoty;
		}
		else
		{
			return null;
		}
	}
	
	public function copyContent($ref_id,$factory_id, $category_id)
	{
		$ref_cont=$this->getRefCont($ref_id);
		$goods=$this->getGoods($category_id,$factory_id);
		//$goods=$this->getGoods(9,93);
		var_dump($goods);
		echo "<br><br>";
		var_dump ($ref_cont);
		echo "<br><br>";
		//if (is_array($goods))
		{
			foreach ($goods as $good)
			{
				$id=$good;
				//var_dump($good);
				//var_dump($id);
				if ($id!=$ref_id)
				{
					$this->setCont($id,$ref_cont);
				}
				
				//break;
			}
		}
	}
}

$test=new ContentCopy();
$test->copyContent(15423,93,9);