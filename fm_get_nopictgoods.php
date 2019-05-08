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

Class GenGoodsNoPict
{
    private function isActualFM($id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
		$query="select goods_noactual from goods WHERE goods_id=$id";
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
        if ($goods[0]['goods_noactual']==1)
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    private function getActiveGoods()
    {
        $db_connect=mysqli_connect(host,user,pass,db);
		$query="select distinct goods_id from goodshaslang WHERE goodshaslang_active=1";
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
		return $goods;
    }
    
    private function getGoods()
    {
        $goods=$this->getActiveGoods();
        if (is_array($goods))
        {
            foreach($goods as $good)
            {
                $id=$good['goods_id'];
                if ($this->isActualFM($id))
                {
                    $goods_list[]=$id;
                }
            }
        }
        return $goods_list;
    }

    private function getPictEx($id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goods_pict FROM goods WHERE goods_id=$id";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $picts[] = $row;
            }
            foreach ($picts as $pict)
            {
                $pict_ext=$pict['goods_pict'];
            }
        }
        mysqli_close($db_connect);
        return $pict_ext;

    }

    public function test()
    {
        $goods=$this->getGoods();
        //var_dump($goods);
        if (is_array($goods))
        {
            foreach ($goods as $id)
            {
                $path=$_SERVER['DOCUMENT_ROOT']."/content/original/goods/".$id."/orig-mainpict-".$id.".".$this->getPictEx($id);

                //echo "$path<br>";
                if (!file_exists($path))
                {
                    echo "No pict for good_id=$id<br>";
                }
                //break;
            }
        }
    }
}

$test=new GenGoodsNoPict();
$test->test();