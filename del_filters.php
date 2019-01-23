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
//define ("db", "new_fm");
define ("db", "newfm");

class CheckByCategory
{
    private function getGoodsByCategory($cat_id)
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
        mysqli_close($db_connect);
		return $goods_all;
    }
    
    private function getCategoryForGood($id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
		$query="select category_id from goodshascategory WHERE goods_id=$id";
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
        mysqli_close($db_connect);
		return count($goods_all);
    }

    public function test($cat_id)
    {
        $goods=$this->getGoodsByCategory($cat_id);
        if (is_array($goods))
        {
            foreach($goods as $good)
            {
                $id=$good['goods_id'];
                if ($this->getCategoryForGood($id)>1)
                {
                    echo "товар с ид=$id находится в нескольких категориях<br>";
                }
            }
        }
    }
}

class DellOldFilters
{
    private function getGoodsByCategory($cat_id)
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
        mysqli_close($db_connect);
		return $goods_all;
    }

    private function delFeature($goods_id,$feature_id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="DELETE FROM goodshasfeature WHERE goods_id=$goods_id AND feature_id=$feature_id";
        echo "$query<br>";
        mysqli_query($db_connect,$query);
        mysqli_close($db_connect);

    }


    private function getFeatures($good_id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="select distinct feature_id from goodshasfeature WHERE goods_id=$good_id";
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

    public function delFilters($cat_id)
    {
        $goods=$this->getGoodsByCategory($cat_id);
        if (is_array($goods))
        {
            foreach ($goods as $good)
            {
                $id=$good['goods_id'];
                $features=$this->getFeatures($id);
                if (is_array($features))
                {
                    foreach ($features as $feature)
                    {
                        $feature_id=$feature['feature_id'];
                        if ($feature_id==221||$feature_id==222||$feature_id==223||$feature_id==16||$feature_id==15||$feature_id==32||$feature_id==6||$feature_id==198||$feature_id==154||$feature_id==18)
                        {
                            $this->delFeature($id,$feature_id);
                        }
                    }
                }

            }
        }
    }



}

//$test=new CheckByCategory();
//$test->test(9);

$test1=new DellOldFilters();
$test1->delFilters(9);