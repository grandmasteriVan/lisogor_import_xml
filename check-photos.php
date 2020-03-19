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

class checkFoto
{
    private function getGoodsByCat($cat_id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
		$query="SELECT goods_id from goodshascategory WHERE category_id=$cat_id";
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

    private function isActive($id)
    {
        $active=true;
        $db_connect=mysqli_connect(host,user,pass,db);
		$query="SELECT goodshaslang_active from goodshaslang WHERE goods_id=$id AND lang_id=1";
		if ($res=mysqli_query($db_connect,$query))
		{
				while ($row = mysqli_fetch_assoc($res))
				{
					$goods_active[] = $row;
				}
		}
		else
		{
			 echo "Error in SQL: $query<br>";		
        }
        if ($goods_active[0]['goodshaslang_active']==1)
        {
            $query="SELECT goods_productionout, goods_noactual from goods WHERE goods_id=$id";
            if ($res=mysqli_query($db_connect,$query))
            {
                    while ($row = mysqli_fetch_assoc($res))
                    {
                        $goods_actual[] = $row;
                    }
            }
            else
            {
                echo "Error in SQL: $query<br>";		
            }
            if ($goods_actual[0]['goods_productionout']==1||$goods_actual[0]['goods_noactual']==1)
            {
                $active=false;
            }
        }
        else
        {
            $active=false;
        }
        
        
        mysqli_close($db_connect);
        return $active;
    }

    private function getPicExt($id)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="SELECT goods_pict FROM goods WHERE goods_id=$id";
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
			return $goods[0]['goods_pict'];
		}
		else
		{
			return null;
		}
	}

    public function test($cat)
    {
        $goods=$this->getGoodsByCat($cat);
        foreach ($goods as $good)
        {
            $id=$good['goods_id'];
            if ($this->isActive($id))
            {
                $ext=$this->getPicExt($id);
                $path=$_SERVER['DOCUMENT_ROOT']."/content/original/goods/".$id."/orig-mainpict-".$id.".".$ext;
                if (!is_readable($path))
                {
                    if (strlen($ext)>1)
                    {
                        echo "Нет оригинала для $id $path<br>";
                    }
                    
                }
                
            }
        }
    }
}

$test=new checkFoto();
echo "<b>Диваны</b><br>";
$test->test(1);
echo "<b>Кресла</b><br>";
$test->test(2);
echo "<b>Угловые</b><br>";
$test->test(38);
echo "<b>Безкаркаска</b><br>";
$test->test(36);
