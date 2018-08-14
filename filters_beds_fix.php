<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 14.08.18
 * Time: 09:21
 */
 
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
Class Filters
{
 
 /**    
	* @param int $goods_maintcharter
     * @return array
     */
    private function allBads($goods_maintcharter=13)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goods_id, goods_parent FROM goods WHERE goods_maintcharter=$goods_maintcharter AND goods_noactual=0 AND goods_active=1 AND goods_productionout=0";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $arr[] = $row;
            }
        }
		else
		{
			echo "Error in SQL ".mysqli_error($db_connect)."<br>";
		}
        mysqli_close($db_connect);
        return $arr;
    }
	
	private function getFilters($feature_id,$goods_id)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="SELECT * FROM goodshasfeature WHERE goods_id=$goods_id AND feature_id=$feature_id";
		if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $arr[] = $row;
            }
        }
		else
		{
			echo "Error in SQL ".mysqli_error($db_connect)."<br>";
		}
		mysqli_close($db_connect);
		if (is_array($arr))
		{
			return $arr[0]['goodshasfeature_valuefloat'];
		}
		else
		{
			return null;
		}
	}
	
	private function setFilter ($goods_id,$feature_id,$goodshasfeature_valueint)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="INSERT INTO goodshasfeature (goodshasfeature_valueint, goodshasfeature_valuefloat, ".
            "goodshasfeature_valuetext, goods_id, feature_id) ".
            "VALUES ($goodshasfeature_valueint, 0, ".
            "'', $goods_id, $feature_id)";
        mysqli_query($db_connect,$query);
		echo "$query<br>";
        mysqli_close($db_connect);
    }
	
	private function delFilter($feature_id,$goods_id)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
        $query="DELETE FROM goodshasfeature WHERE goods_id=$goods_id AND feature_id=$feature_id";
        mysqli_query($db_connect,$query);
		echo "$query<br>";
        mysqli_close($db_connect);
	}
	
	public function fixFilters()
	{
		$goods=$this->allBads();
		
		if (is_array($goods))
		{
			foreach ($goods as $good)
			{
				$id=$good['goods_id'];
				$length=$this->getFilters(85,$id);
				$width=$this->getFilters(84,$id);
				//если нет старого фильтра, то все ок
				if (!is_null($length)||!is_null($width))
				{
					$this->delFilter(227,$id);
					
					$no_standart=true;
					
					if ($length==1900&&$width==800)
					{
						$this->setFilter($id,227,6);
						$no_standart=false;
						$this->delFilter(85,$id);
						$this->delFilter(84,$id);
					}
					if ($length==1900&&$width==900)
					{
						$this->setFilter(8,0,'',$id,227);
						$no_standart=false;
						$this->delFilter(85,$id);
						$this->delFilter(84,$id);
					}
					if ($length==2000&&$width==900)
					{
						$this->setFilter($id,227,9);
						$no_standart=false;
						$this->delFilter(85,$id);
						$this->delFilter(84,$id);
					}
					if ($length==1900&&$width==1200)
					{
						$this->setFilter($id,227,12);
						$no_standart=false;
						$this->delFilter(85,$id);
						$this->delFilter(84,$id);
					}
					if ($length==2000&&$width==1200)
					{
						$this->setFilter($id,227,13);
						$no_standart=false;
						$this->delFilter(85,$id);
						$this->delFilter(84,$id);
					}
					if ($length==1900&&$width==1400)
					{
						$this->setFilter($id,227,14);
						$no_standart=false;
						$this->delFilter(85,$id);
						$this->delFilter(84,$id);
					}
					if ($length==2000&&$width==1400)
					{
						$this->setFilter($id,227,15);
						$no_standart=false;
						$this->delFilter(85,$id);
						$this->delFilter(84,$id);
					}
					if ($length==1900&&$width==1600)
					{
						$this->setFilter($id,227,18);
						$no_standart=false;
						$this->delFilter(85,$id);
						$this->delFilter(84,$id);
					}
					if ($length==2000&&$width==1600)
					{
						$this->setFilter($id,227,19);
						$no_standart=false;
						$this->delFilter(85,$id);
						$this->delFilter(84,$id);
					}
					if ($length==2000&&$width==1800)
					{
						$this->setFilter($id,227,23);
						$no_standart=false;
						$this->delFilter(85,$id);
						$this->delFilter(84,$id);
					}
					if ($length==2000&&$width==2000)
					{
						$this->setFilter($id,227,26);
						$no_standart=false;
						$this->delFilter(85,$id);
						$this->delFilter(84,$id);
					}
					if ($no_standart&&$length!=0&&$width!=0)
					{
						echo "<b>Не стандартный размер не помещается в фильтр!!! id=$id</b><br>";
					}
					
				}
			}
		}
		else
		{
			echo "No goods!<br>";
		}
			
	}
}

$test=new Filters();
$test->fixFilters();