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
        if (!mb_strpos($text,"7216121"))
        {
            $text.=",7216121";
        }
        if (!mb_strpos($text,"7216122"))
        {
            $text.=",7216122";
        }
        if (!mb_strpos($text,"7216123"))
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
        $rnd=rand(1,2);
        if ($with==800 AND $height==1900)
        {
            if ($rnd==1)
            {
                $text.=",1402997,1433962";
            }
            if ($rnd==2)
            {
                $text.=",1403088,1433962";
            }
        }
		if ($with==900 AND $height==1900)
        {
            if ($rnd==1)
            {
                $text.=",1405480,1404324";
            }
            if ($rnd==2)
            {
                $text.=",1405608,1433963";
            }
        }
		if ($with==1200 AND $height==1900)
        {
            if ($rnd==1)
            {
                $text.=",1405481,1404326";
            }
            if ($rnd==2)
            {
                $text.=",1405609,1433965";
            }
            
        }
		if ($with==1400 AND $height==1900)
        {
            if ($rnd==1)
            {
                $text.=",1405483,1433966";
            }
            if ($rnd==2)
            {
                $text.=",1405610,1404327";
            }
        }
		
		if ($with==1600 AND $height==1900)
        {
            if ($rnd==1)
            {
                $text.=",1405484,1404328";
            }
            if ($rnd==2)
            {
                $text.=",1405612,1433967";
            }
        }
		if ($with==1800 AND $height==1900)
        {
            if ($rnd==1)
            {
                $text.=",1405485,1433968";
            }
            if ($rnd==2)
            {
                $text.=",1405613,1404329";
            }
        }
		////////////////////////////////////////
		if ($with==800 AND $height==2000)
        {
            if ($rnd==1)
            {
                $text.=",1405486,1433969";
            }
            if ($rnd==2)
            {
                $text.=",1405614,1404330";
            }
            
        }
		if ($with==900 AND $height==2000)
        {
            if ($rnd==1)
            {
                $text.=",1405487,1404331";
            }
            if ($rnd==2)
            {
                $text.=",1405615,1433970";
            }
            
        }
		if ($with==1200 AND $height==2000)
        {
            if ($rnd==1)
            {
                $text.=",1405488,1404332";
            }
            if ($rnd==2)
            {
                $text.=",1405616,1433972";
            }
           
        }
		if ($with==1400 AND $height==2000)
        {
            if ($rnd==1)
            {
                $text.=",1405489,1433973";
            }
            if ($rnd==2)
            {
                $text.=",1405617,1404333";
            }
           
        }
		
		if ($with==1600 AND $height==2000)
        {
            if ($rnd==1)
            {
                $text.=",1405491,1433974";
            }
            if ($rnd==2)
            {
                $text.=",1405619,1404335";
            }
        }
		if ($with==1800 AND $height==2000)
        {
            if ($rnd==1)
            {
                $text.=",1405492,1404337";
            }
            if ($rnd==2)
            {
                $text.=",1405620,1433975";
            }
        }
        return $text;
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
				//echo "$i<br>";
			}
			return ($new_goods);
			
		}
		else
		{
			return null;
		}
	}	
	
	private function insDB($id,$text)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="update goods SET goods_buywith='$text' where goods_id=$id";
		mysqli_query($db_connect,$query);
		mysqli_close($db_connect);
		
	}
	
    public function insertBw()
    {
        $goods=$this->getGoods();
		$goods=$this->uniteGoods($goods);
		foreach ($goods as $good)
		{
			$id=$good['id'];
			$text=$good['buywith'];
			$len=$good['len'];
			$whidth=$good['whidth'];
			$text=$this->insertTumb($text);
			$text=$this->insertMatr($text,$whidth,$len);
			//удаляем лишнюю запятую в начале строки
			if ($text{0}==",")
			{
				$text=mb_substr($text,1);	
			}
			echo "$id: $text<br>";
			$this->insDB($id,$text);
			
		}
        //var_dump($goods);
    }
}
$test=new BWInsert();
$test->insertBw();
