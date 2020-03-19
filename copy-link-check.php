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
//define ("db", "fm");
define ("db", "newfm");

class urlCopyCheck
{
    private function getLink()
    {
        $db_connect=mysqli_connect(host,user,pass,db);
		$query="SELECT goodshaslang_url, goodshaslang_name, goods_id FROM goodshaslang WHERE goodshaslang_url LIKE '%copy%' AND goodshaslang_active=1";
		if ($res=mysqli_query($db_connect,$query))
		{		
            while ($row = mysqli_fetch_assoc($res))
			{
				$links[] = $row;
			}
		}
		else
		{
			echo "Error in SQL: $query<br>";		
        }
        mysqli_close($db_connect);
        return $links;
    }

    private function getStatus($id)
    {
        $stat="";
        $db_connect=mysqli_connect(host,user,pass,db);
		$query="SELECT goods_productionout, goods_noactual FROM goods WHERE goods_id=$id";
		if ($res=mysqli_query($db_connect,$query))
		{		
            while ($row = mysqli_fetch_assoc($res))
			{
				$status[] = $row;
			}
		}
		else
		{
			echo "Error in SQL: $query<br>";		
        }
        mysqli_close($db_connect);
        $status=$status[0];
        if ($status['goods_productionout']==1)
        {
            $stat.="Снят с производства";
        }
        if ($status['goods_noactual']==1)
        {
            $stat.=" Не актуальный";
        }
        else
        {
            $stat.=" Актуальный";
        }
        return $stat;
    }

    public function swowLinks()
    {
        $links=$this->getLink();
        foreach ($links as $link)
        {
            $id=$link['goods_id'];
            $linkText=$link['goodshaslang_url'];
            $name=$link['goodshaslang_name'];
            $status=$this->getStatus($id);
            echo "$name;$id;$linkText;$status<br>";
            //break;
        }
    }
}

$test = new urlCopyCheck();
$test->swowLinks();