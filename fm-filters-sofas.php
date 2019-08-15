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

class FiltersFix
{
    private function getPrice ($id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
		$query="SELECT goods_priceord from goods WHERE goods_id=$id";
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
        if (is_array($goods_all))
        {
            return $goods_all[0]['goods_priceord'];
        }
        else
        {
            return null;
        }
    }

    private function getGoodsPrice($catId, $minPrice, $maxPrice)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
		$query="SELECT goods_id from goodshascategory WHERE category_id=$catId";
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
        foreach ($goods_all as $good)
        {
            $id=$good['goods_id'];
            $price=$this->getPrice($id);
            //echo "$id=$price<br>";
            if ($price>=$minPrice&&$price<$maxPrice)
            {
                $return[]=$id;
            }

        }
        return $return;
    }

    public function FixPriceCat($catId)
    {
        //9000-17000-17000+
        $goods=$this->getGoodsPrice(1,17000,20000000);
        var_dump ($goods);

    }
}

$test=new FiltersFix();
$test->FixPriceCat(1);