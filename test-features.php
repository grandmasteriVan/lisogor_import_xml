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


class TestFeatures
{
	private function getFeaturesByCategory ($cat_id)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="select feature_id from categoryhasfeature where category_id=$cat_id";
		if ($res=mysqli_query($db_connect,$query))
		{
				while ($row = mysqli_fetch_assoc($res))
				{
					$features[] = $row;
				}
		}
		else
		{
			echo "Error in SQL: $query<br>";
		}
		if (is_array($features))
		{
			return $features;
		}
		else
		{
			return null;
		}
	}
	
	private function checkFeatureLang($f_id)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="select featurehaslang_id from featurehaslang where feature_id=$f_id and lang_id=2";
		if ($res=mysqli_query($db_connect,$query))
		{
				while ($row = mysqli_fetch_assoc($res))
				{
					$features[] = $row;
				}
		}
		else
		{
			echo "Error in SQL: $query<br>";
		}
		if (is_array($features))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	private function checkValueLang($val_id)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="select fvaluehaslang_id from fvaluehaslang where fvalue_id=$val_id and lang_id=2";
		if ($res=mysqli_query($db_connect,$query))
		{
				while ($row = mysqli_fetch_assoc($res))
				{
					$features[] = $row;
				}
		}
		else
		{
			echo "Error in SQL: $query<br>";
		}
		if (is_array($features))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	private function getValForFeature($f_id)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="select fkind_id from feature where feature_id=$f_id";
		if ($res=mysqli_query($db_connect,$query))
		{
				while ($row = mysqli_fetch_assoc($res))
				{
					$fkind[] = $row;
				}
		}
		else
		{
			echo "Error in SQL: $query<br>";
		}
		if (is_array($fkind))
		{
			$fkind=$fkind[0]['fkind_id'];
			$query="select fvalue_id from fvalue where fkind_id=$fkind";
			if ($res=mysqli_query($db_connect,$query))
			{
				while ($row = mysqli_fetch_assoc($res))
				{
					$fvalue[] = $row;
				}
				//var_dump($fvalue);
				return $fvalue;
			}
			else
			{
				echo "Error in SQL: $query<br>";
			}
		}
	}
	
	
	public function test($cat_id)
	{
		echo "Тест для категории $cat_id<br>";
		$features=$this->getFeaturesByCategory($cat_id);
		if (is_array($features))
		{
			foreach ($features as $feature)
			{
				$f_id=$feature['feature_id'];
				if ($this->checkFeatureLang($f_id))
				{
					echo "у фичи $f_id есть укр язык<br>";
				}
				else
				{
					echo "у фичи $f_id <b>нет</b> укр языка <br>";
				}
				$vals=$this->getValForFeature($f_id);
				if (is_array($vals))
				{
					foreach ($vals as $val)
					{
						//var_dump($val);
						$val_id=$val['fvalue_id'];
						if ($this->checkValueLang($val_id))
						{
							echo "у значения $val_id есть укр язык<br>";
						}
						else
						{
							echo "у значения $val_id <b>нет</b> укр языка <br>";
						}
					}
				}
				else
				{
					//echo "No arr!<br>";
				}
				echo "<br><br>";
				//break;
			}
		}
	}
	
}

$test=new TestFeatures();
$test->test(9);