<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 05.02.2018
 * Time: 10:12
 */
header('Content-Type: text/html; charset=utf-8');
/**
 * database host
 */
//define ("host","localhost");
/**
 *
 */
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
/**
 * Class BWInsert
 */
class BWInsert
{
    /**
     * @param $text
     * @return string
     */
    private function insertTumb($text)
    {
        if (mb_strpos($text,"7216121"))
        {
            $text.=",7216121";
        }
        if (mb_strpos($text,"7216122"))
        {
            $text.=",7216122";
        }
        if (mb_strpos($text,"7216123"))
        {
            $text.=",7216123";
        }
        return $text;
    }
    /**
     * @param $text
     * @param $with
     * @param $height
     */
    private function insertMatr($text, $with, $height)
    {
        $rnd=rand(1,3);
        if ($with==800 AND $height==1900)
        {
            if ($rnd==1)
            {
                $text.=",";
            }
            if ($rnd==2)
            {
                $text.=",";
            }
            if ($rnd==3)
            {
                $text.=",";
            }
        }
    }
    /**
     * @return array|null
     */
    private function getGoods()
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goods.goods_id,goods.goods_buywith,goodshasfeature.goodshasfeature_valuefloat, goodshasfeature.feature_id FROM goods join goodshasfeature ON goods.goods_id=goodshasfeature.goods_id ".
            "WHERE goods.factory_id=37 AND (goods.goodskind_id=39 OR goods.goodskind_id=50) AND (goodshasfeature.feature_id=85 OR goodshasfeature.feature_id=84)";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $arr[] = $row;
            }
        }
		else
		{
			echo "Error in SQL<br>";
			var_dump(mysqli_error($db_connect));
		}
        mysqli_close($db_connect);
        if (is_array($arr))
        {
            return $arr;
        }
        else
        {
            return null;
        }
    }
    /**
     *
     */
	private function uniteGoods($goods)
	{
		if (is_array($goods))
		{
			echo count($goods);
			for ($i=0;$i<=count($goods)-1;$i=$i+2)
			{
				$id=$goods[$i]['goods_id'];
				$buywith=$goods[$i]['goods_buywith'];
				$whidth=$goods[$i+1]['goodshasfeature_valuefloat'];
				$len=$goods[$i]['goodshasfeature_valuefloat'];
				$new_goods[]=array('id'=>$id,'buywith'=>$buywith, 'len'=>$len, 'whidth'=>$whidth);
				//break;
				echo "$i<br>";
			}
			return ($new_goods);
			
		}
		else
		{
			return null;
		}
	}	
	 
    public function insertBw()
    {
        $goods=$this->getGoods();
		$goods=$this->uniteGoods($goods);
        var_dump($goods);
    }
}
$test=new BWInsert();
$test->insertBw();
