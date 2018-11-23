<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 21.07.16
 * Time: 11:11
 */
header('Content-type: text/html; charset=UTF-8');

define ("host_ddn","es835db.mirohost.net");
//define ("host_ddn","localhost");

define ("user_ddn", "u_fayni");
//define ("user_ddn", "root");

define ("pass_ddn", "ZID1c0eud3Dc");
//define ("pass_ddn", "");

define ("db_ddn", "ddnPZS");
//define ("db_ddn", "ddn");

class Filters
{
	private function getAllGoods()
	{
		 $db_connect=mysqli_connect(host_ddn,user_ddn,pass_ddn,db_ddn);
		$query="SELECT goods_id FROM goods";
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
		return $goods;
	}
	
	private function delFeature($goods_id,$feature_id)
	{
		$db_connect=mysqli_connect(host_ddn,user_ddn,pass_ddn,db_ddn);
		$query="DELETE FROM goodshasfeature WHERE goods_id=$goods_id AND feature_id=$feature_id";
		echo "$query<br>";
		mysqli_query($db_connect,$query);
		mysqli_close($db_connect);
	}
	
	private function delFeatureVal($goods_id,$val_id)
	{
		$db_connect=mysqli_connect(host_ddn,user_ddn,pass_ddn,db_ddn);
		$query="DELETE FROM goodshasfeature WHERE goods_id=$goods_id AND feature_id=3 AND goodshasfeature_valueid=$val_id";
		echo "$query<br>";
		mysqli_query($db_connect,$query);
		mysqli_close($db_connect);
	}
	
	private function insFeature($goods_id, $feature_id, $value_id)
	{
		$db_connect=mysqli_connect(host_ddn,user_ddn,pass_ddn,db_ddn);
		$query="INSERT INTO goodshasfeature (goods_id, feature_id, goodshasfeature_valueid) VALUES ($goods_id, $feature_id, $value_id)";
		echo "$query<br><br>";
		mysqli_query($db_connect,$query);
		mysqli_close($db_connect);
	}
	
	private function getFeature($good_id,$feature_id)
	{
		$db_connect=mysqli_connect(host_ddn,user_ddn,pass_ddn,db_ddn);
		$query="select goodshasfeature_valueid from goodshasfeature WHERE goods_id=$good_id AND feature_id=$feature_id";
		if ($res=mysqli_query($db_connect,$query))
		{
				while ($row = mysqli_fetch_assoc($res))
				{
					$goods[] = $row['goodshasfeature_valueid'];
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
	
	public function setFilters()
	{
		$goods=$this->getAllGoods();
		//var_dump($goods);
		if (is_array($goods))
		{
			foreach ($goods as $good)
			{
				$id=$good['goods_id'];
				//выбираем только наполенние, остальные фильтры нам не нужны
				$features=$this->getFeature($id,3);
				if (is_array($features))
				{
					//var_dump ($features);
					if (count($features)==1&&$features[0]==41)
					{
						echo "$id= Только ППУ!<br>";
						//$this->delFeature($id,3);
						$this->delFeatureVal($id,212);
						$this->insFeature($id,3,212);
					}
					
					if (count($features)==1&&($features[0]==39||$features[0]==43||$features[0]==44))
					{
						echo "$id= Пружина+ППУ!<br>";
						//$this->delFeature($id,3);
						$this->delFeatureVal($id,208);
						$this->insFeature($id,3,208);
					}
					
					if (in_array(35,$features)||(in_array(42,$features)&&(in_array(43,$features)||in_array(44,$features)||in_array(49,$features))))
					{
						echo "$id= Змейка+Пружина+ППУ!<br>";
						//var_dump($features);
						//$this->delFeature($id,3);
						$this->delFeatureVal($id,209);
						$this->insFeature($id,3,209);
					}
					if ((in_array(37,$features)&&(!in_array(44,$features)&&!in_array(43,$features)&&!in_array(39,$features)))||(in_array(36,$features)&&in_array(41,$features)&&in_array(44,$features)&&!in_array(43,$features)&&!in_array(39,$features)))
					{
						echo "$id= Ламели+ППУ!<br>";
						//var_dump($features);
						$this->delFeatureVal($id,210);
						$this->insFeature($id,3,210);
					}
					if (in_array(38,$features)||(in_array(36,$features)&&(in_array(44,$features)||in_array(43,$features)||in_array(39,$features))))
					{
						echo "$id= Ламели+пружина+ППУ!<br>";
						//var_dump($features);
						$this->delFeatureVal($id,211);
						$this->insFeature($id,3,211);
					}
					
					if ($id==3100)
					{
						var_dump($features);
						//if (in_array("35",$features))
						//	echo "!!!";
						
					}
					//break;
					
				}
				//break;
			}
		}
		else
		{
			echo "No goods!<br>";
		}
	}	
}

$test = new Filters();
$test->setFilters();