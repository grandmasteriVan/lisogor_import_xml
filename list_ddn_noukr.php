<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 02.03.2018
 * Time: 14:00
 */
header('Content-type: text/html; charset=UTF-8');
//define ("host","localhost");
define ("host","es835db.mirohost.net");
/**
 * database username
 */
//define ("user", "root");
define ("user", "u_fayni");
/**
 * database password
 */
//define ("pass", "");
define ("pass", "ZID1c0eud3Dc");
/**
 * database name
 */
//define ("db", "ddn_new");
define ("db", "ddnPZS");
class ListDDNNoUkr
{
	private function getAllTov()
	{
		$db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goods_id FROM goods";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $goods[]=$row;
            }
            //var_dump ($query);
            //var_dump ($tovByFactory);
        }
        else
        {
            echo "Error in SQL $query".mysqli_error($db_connect)."<br>";
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
	private function getLangVer($id)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="SELECT lang_id,goodshaslang_active FROM goodshaslang WHERE goods_id=$id";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $goods[]=$row;
            }
            //var_dump ($query);
            //var_dump ($tovByFactory);
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
	
	public function getList()
	{
		$goods=$this->getAllTov();
		if (is_array($goods))
		{
			foreach ($goods as $good)
			{
				$id=$good['goods_id'];
				$good_lang=$this->getLangVer($id);
				//echo "$id ".count($good_lang)."<br>";
				if (count($good_lang)>1)
				{
					$rus_active=null;
					$urk_active=null;
					foreach ($good_lang as $lang)
					{
						$lang_id=null;
						$active=null;
						$lang_id=$lang['lang_id'];
						$active=$lang['goodshaslang_active'];
						if (($lang_id==3)&&($active==0))
						{
							$urk_active=0;
						}
						if (($lang_id==1)&&($active==0))
						{
							$rus_active=0;
						}
					}
					if ($urk_active==0&&$rus_active==1)
					{
						echo "$id отключена укр версия<br>";
					}
				}
				else
				{
					echo "$id имеет только 1 языковую версию<br>";
				}
			}
		}
	}
}

$test=new ListDDNNoUkr();
$test->getList();