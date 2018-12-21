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

class Compare
{
	private function getFmMirror()
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="select goods_id, goodsmirror_article_ddn from goodsmirror WHERE goodsmirror_article_ddn<>''";
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
	
	private function getGoodsDdn()
	{
		$db_connect=mysqli_connect(host_ddn,user_ddn,pass_ddn,db_ddn);
		$query="select goods_id, goods_article from goods WHERE goods_noactual=1";
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
	
	public function compare1()
	{
		$goods_ddn=$this->getGoodsDdn();
		$goods_fm=$this->getFmMirror();
		foreach ($goods_ddn as $good_ddn)
		{
			$ddn_id=$good_ddn['goods_id'];
			$ddn_art=$good_ddn['goods_article'];
			$infm=false;
			foreach ($goods_fm as $good_fm)
			{
				$fm_id=$good_fm['goods_id'];
				$fm_art=$good_fm['goodsmirror_article_ddn'];
				if ($fm_art==$ddn_art)
				{
					$infm==true;
					break;
				}
			}
			if ($infm==false)
			{
				echo "$ddn_id $ddn_art нет на ФМ<br>";
			}
			
		}
	}
}

$test = new Compare();
$test->compare1();