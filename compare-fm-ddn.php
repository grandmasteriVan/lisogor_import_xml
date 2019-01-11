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


define ("host_ddn","es835db.mirohost.net");
define ("user_ddn", "u_fayni");
define ("pass_ddn", "ZID1c0eud3Dc");
define ("db_ddn", "ddnPZS");

class CompareAct
{
    private function getGoods()
    {
        $db_connect=mysqli_connect(host,user,pass,db);
		$query="select goods_id, goodsmirror_article_ddn from goodsmirror WHERE goodsmirror_article_ddn NOT LIKE ''";
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

    private function isActualDDN($article)
    {
        $db_connect=mysqli_connect(host_ddn,user_ddn,pass_ddn,db_ddn);
        $query="select goods_noactual from goods WHERE goods_article=$article";
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

    public function compare()
    {
        $goods=$this->getGoods();
        //var_dump ($goods);
        if (is_array($goods))
        {
            foreach ($goods as $good)
            {
                $id=$good['goods_id'];
                $art_ddn=$good['goodsmirror_article_ddn'];
                $act_fm=$this->isActualFM($id);
                $act_ddn=$this->isActualDDN($art_ddn);
                if ($act_fm!=$act_ddn)
                {
                    if ($act_fm==true&&act_ddn==false)
                    {
                        echo "$id на ФМ актуален а его соответствие на ДДН ($art_ddn) неактуально<br>";
                    }
                    if ($act_fm==false&&act_ddn==true)
                    {
                        echo "$id на ФМ неактуален а его соответствие на ДДН ($art_ddn) актуально<br>";
                    }
                }
                else 
                {
                    //echo "$id is OK<br>";
                }
            }

        }
        else
        {
            echo "No goods<br>";
        }
    }
}

$test = new CompareAct();
$test->compare();