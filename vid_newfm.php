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

	function delAllVid($cont)
	{
		$cont_new=preg_replace("'<iframe[^>]*?>.*?</iframe>'si","",$cont);
		return $cont_new;
	}

	function getVidId($cont)
    {
        //echo "Whghgh<pre>";
        preg_match_all('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $cont, $videoId);
		/*preg_match('#(\.be/|/embed/|/v/|/watch\?v=)([A-Za-z0-9_-]{5,11})#', $YoutubeCode, $matches);
			if(isset($matches[2]) && $matches[2] != '')
			{
				$YoutubeCode = $matches[2];
			}*/
		
		
		
		
        //echo count ($videoId)."<br>";
        return $videoId;
    }
	
	function getGoodsWithVid()
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="select goods_id, goodshaslang_content from goodshaslang where lang_id=1 AND goodshaslang_content LIKE '%iframe%' AND goodshaslang_active=1";
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
		if (is_array($goods))
		{
			return $goods;
		}
		else
		{
			return null;
		}
	}

	function getGoodsByFactory ($f_id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goods_id FROM goodshasfeature WHERE feature_id=232 AND goodshasfeature_valueid=$f_id";
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
		//var_dump($goods);
		mysqli_close($db_connect);
		//var_dump ($goods);
        if (is_array($goods))
        {
            return $goods;
        }
        else
        {
            return null;
        }
        
	}
	
	function getGoodsfileId($goods_id,$goodsfile_link)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="SELECT * FROM goodsfile WHERE goods_id=$goods_id AND goodsfile_link like '$goodsfile_link'";
		//echo "$query<br>";
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
		//var_dump($goods);
        if (is_array($goods))
        {
            return $goods[0]['goodsfile_id'];
        }
        else
        {
            return null;
        }
	}

	function insVideofile($vid,$goods_id)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$key=substr(md5(time()+random_int(10,10000)),0,15);

        $query="INSERT INTO goodsfile (goods_id,goodsfile_link,goodsfile_key) VALUES ($goods_id,'$vid','$key')";
        //echo "$query<br>";
        mysqli_query($db_connect,$query);
        mysqli_close($db_connect);
	}

	function insVidLang($goodsfile_id)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
        $query="INSERT INTO goodsfilehaslang (goodsfilehaslang_name,goodsfilehaslang_active,goodsfile_id,lang_id) VALUES ('',1,$goodsfile_id,1)";
        //echo "$query<br>";
		mysqli_query($db_connect,$query);
		$query="INSERT INTO goodsfilehaslang (goodsfilehaslang_name,goodsfilehaslang_active,goodsfile_id,lang_id) VALUES ('',1,$goodsfile_id,2)";
        //echo "$query<br>";
        mysqli_query($db_connect,$query);
        mysqli_close($db_connect);
	}
	
	function writeVidInGal($vid,$fid)
	{
		$goods=getGoodsByFactory($fid);
		//var_dump ($goods);
		foreach($goods as $good)
		{
			$id=$good['goods_id'];
			//delVideo($vid,$id);

			if ($id==15299)
			{
				insVideofile($vid,$id);
				$goodsfile_id=getGoodsfileId($id,$vid);
				insVidLang($goodsfile_id);
			}
			
			
			//echo "goodsfile_id=$goodsfile_id<br>";
			
			
			/*setActive($goodsfile_id);
			if ($id==15299)
			{
				echo $goodsfile_id;
			}*/
			
			break;

		}
	}

	function delVideo($vid,$goods_id)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		
		$query="SELECT goodsfile_id FROM goodsfile WHERE goods_id=$goods_id AND goodsfile_link like '$goodsfile_link'";
		//echo "$query<br>";
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
		
		//var_dump($goods);
        if (is_array($goods))
        {
			foreach ($goods as $good)
			{
				$fileId=$good['goodsfile_id'];
				$query="DELETE FROM goodsfile WHERE goodsfile_id=$fileId";
				mysqli_query($db_connect,$query);
				$query="DELETE FROM goodsfilehaslang WHERE goodsfile_id=$fileId";
				mysqli_query($db_connect,$query);
			}
        }
        
		mysqli_close($db_connect);
	}

	function setActive($fileId)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="UPDATE goodsfilehaslang SET goodsfilehaslang_active=1 WHERE goodsfile_id=$fileId";
		//echo "$query<br>";
		mysqli_query($db_connect,$query);
		mysqli_close($db_connect);
	}
	
	function VidsFromContToGal()
	{
		$goods=getGoodsWithVid();
		if (is_array($goods))
		{
			foreach ($goods as $good)
			{
				$id=$good['goods_id'];
				$cont=$good['goodshaslang_content'];
				$cont=str_replace("?rel=0","",$cont);
				$cont=str_replace(" width=\"560\"","",$cont);
				$cont=str_replace(" width=\"420\"","",$cont);
				
				$vids=getVidId($cont);
				echo "$id:";
				echo "<pre>";
				print_r($vids);
				echo "</pre>";
				
			}
		}
		else
		{
			echo "No goods!<br>";
		}
	}
	
	//VidsFromContToGal();
	//writeVidInGal('HM6nrxefkCw',86);
	writeVidInGal('HM6nrxefkCw',93);
	echo "Done!";
	