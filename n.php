<?php
//header('Content-Type: text/html; charset=utf-8');
/**
 * database host
 */
//define ("host","localhost");
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
/*
$db_connect=mysqli_connect(host,user,pass,db);
$query="SELECT factory_name, factory_id FROM factory WHERE factory_soft=0 AND factory_noactual=0";
if ($res=mysqli_query($db_connect,$query))
    {
            while ($row = mysqli_fetch_assoc($res))
            {
                $factories[] = $row;
            }
            //var_dump($goods);
			//echo "<pre>";
			//print_r ($factories);
			//echo "</pre>";
    }
	if (is_array($factories))
	{
		foreach ($factories as $factory)
		{
			unset ($categories);
			$f_id=$factory['factory_id'];
			$f_name=$factory['factory_name'];
			$query="SELECT category_name FROM category WHERE category_active=1 AND factory_id=$f_id";
			if ($res=mysqli_query($db_connect,$query))
			{
					while ($row = mysqli_fetch_assoc($res))
					{
						$categories[] = $row;
					}
					//var_dump($goods);
					//$categories=asort($categories);
					echo "$f_name:<br>";
					//echo min($categories);
					//echo "<pre>";
					//print_r ($categories);
					//echo "</pre>";
					if (is_array($categories))
					{
						foreach ($categories as $cat)
						{
							//echo $cat['category_name'].", ";
						}
						echo "<br><br>";
					}
					else
					{
						//echo "has no categories<br><br>";
					}
			}
		}
	}
	mysqli_close($db_connect);
	*/
	/*
	function checkDuplicate($id)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="SELECT 	goodshascategory_id FROM goodshascategory WHERE goods_id=$id AND category_id=1056";
		//echo $query."<br>";
		if ($res=mysqli_query($db_connect,$query))
		{
			while ($row = mysqli_fetch_assoc($res))
            {
                $articles[] = $row;
            }
			$art=null;
			if (is_array($articles))
            {
                foreach ($articles as $article)
                {
                    //получаем нужный текст
                    $art=$article['goodshascategory_id'];
                }
            }
		}
		mysqli_query($db_connect, $query);
		//var_dump ($art);
		if ($art==null)
		{
			return false;
		}
		else
		{
			return true;
		}
	}
	
	
	$db_connect=mysqli_connect(host,user,pass,db);
	$query="select goods_id from goods where factory_id=156";
	$cat_id=1073;
	if ($res=mysqli_query($db_connect,$query))
    {
            while ($row = mysqli_fetch_assoc($res))
            {
                $goods[] = $row;
            }
            //var_dump($goods);
			echo "<pre>";
			print_r ($goods);
			echo "</pre>";
			foreach ($goods as $good)
			{
				$id=$good['goods_id'];
				$query="delete from goodshascategory where goods_id=$id AND category_id=$cat_id";
				echo "$query<br>";
				mysqli_query($db_connect,$query);
				if (checkDuplicate($id))
				{
					echo "good $id has A category<br>";
					$query="update goodshascategory SET goodshascategory_active=1 where category_id=$cat_id and goods_id=$id";
					echo "$query<br>";
					mysqli_query($db_connect,$query);
				}
				else
				{
					$query="insert into goodshascategory (category_id, goods_id, goodshascategory_price, goodshascategory_active, goodshascategory_pricecur) VALUES ($cat_id,$id,0,1,0)";
					echo "$query<br>";
					mysqli_query($db_connect,$query);
				}
			}
    }
	else
	{
		echo "error in SQL $query";
	}
	
	mysqli_close($db_connect);
	
	/*
	$db_connect=mysqli_connect(host,user,pass,db);
	$query="SELECT goods_article FROM goods WHERE factory_id=176 AND goods_maintcharter=125";
	if ($res=mysqli_query($db_connect,$query))
    {
            while ($row = mysqli_fetch_assoc($res))
            {
                $factories[] = $row;
            }
            var_dump($goods);
			echo "<pre>";
			print_r ($factories);
			echo "</pre>";
			foreach ($factories as $f)
			{
				echo $f['goods_article']."<br>";
			}
    }
	*/
	/*
	$db_connect=mysqli_connect(host,user,pass,db);
	$query="update goods set goods_avail=0 where 1";
	mysqli_query($db_connect,$query);
	*/
	/*$db_connect=mysqli_connect(host,user,pass,db);
	$query="SELECT factory_name, factory_id FROM factory WHERE factory_noactual=0";
	if ($res=mysqli_query($db_connect,$query))
    {
            while ($row = mysqli_fetch_assoc($res))
            {
                $factories[] = $row;
            }
            
			//echo "<pre>";
			//print_r ($factories);
			//echo "</pre>";
			foreach ($factories as $factory)
			{
				echo $factory['factory_name']."<br>";
			}
    }*/
	/*
	$db_connect=mysqli_connect(host,user,pass,db);
	$txt=iconv("UTF-8","Windows-1251","У нас есть ещё акции! Интересно? Тогда нажимайте");
	$add="<hr /><p style=\"text-align: center;\">".$txt."</p><p style=\"text-align: center;\"><a href=\"http://fayni-mebli.com/%D0%B2%D1%81%D0%B5-%D1%82%D0%B5%D0%BA%D1%83%D1%89%D0%B8%D0%B5-%D0%B0%D0%BA%D1%86%D0%B8%D0%B8.html\" target=\"_blank\"><img alt=\"\" src=\"http://fayni-mebli.com/admin/upload/file/akcija/button_akcii.png\" style=\"width: 150px; height: 36px;\" /></a></p>";
	
	$query="SELECT article_id, article_content FROM article WHERE article_content like '%akcija/button_akcii.png%'";
	
	if ($res=mysqli_query($db_connect,$query))
	{
		while ($row = mysqli_fetch_assoc($res))
        {
            $articles[] = $row;
        }
		if (is_array($articles))
		{
			foreach ($articles as $article)
			{
				$id=$article['article_id'];
				//$text=$article['article_content'].$add;
				$text=str_replace("style=\"width: 150px; height: 36px;\"","style=\"width: 107px; height: 34px;\"",$text=$article['article_content']);
				$query="update article SET article_content='$text' where article_id=$id";
				echo "$query<br>";
				mysqli_query($db_connect,$query);
				//break;
			}
		}
		else
		{
			echo "not array!<br>";
		}
	}
	else
	{
		echo "error in SQL $query<br>";
	}
	mysqli_close($db_connect);
	*/
	//$db_connect=mysqli_connect(host,user,pass,db);
	//$query="UPDATE goods SET goods_article_1c='' WHERE factory_id=30 AND goods_article_link=''";
	//mysqli_query($db_connect,$query);
	
	
	
	/*$db_connect=mysqli_connect(host,user,pass,db);
	$query="SELECT  goods_id, goods_article, goods_name FROM goods WHERE goods_lidermain=1";
	
	if ($res=mysqli_query($db_connect,$query))
	{
		while ($row = mysqli_fetch_assoc($res))
        {
            $goods[] = $row;
        }
		if (is_array($goods))
		{
			foreach ($goods as $good)
			{
				$name=$good['goods_name'];
				$id=$good['goods_id'];
				$art=$good['goods_article'];
				echo "$id  $name<br>";
			}
		}
		else
		{
			echo "not array!<br>";
		}
	}
	else
	{
		echo "error in SQL $query<br>";
	}
	mysqli_close($db_connect);
	
	//echo " Популярности:<br>";
	$db_connect=mysqli_connect(host,user,pass,db);
	unset($goods);
	$query="SELECT goods_id, goods_name, goods_popular FROM goods WHERE goods_stock=1 or factory_id=114";
	if ($res=mysqli_query($db_connect,$query))
	{
		while ($row = mysqli_fetch_assoc($res))
        {
            $goods[] = $row;
        }
		//var_dump($goods);
		if (is_array($goods))
		{
			foreach ($goods as $good)
			{
				$name=$good['goods_name'];
				$id=$good['goods_id'];
				$popular=$good['goods_popular'];
				//var_dump($good);
				//echo "$id  $name:  $popular<br>";
				$str="$id;$name;$popular;".PHP_EOL;
				//file_put_contents("pop.csv",$str,FILE_APPEND);
				//break;
			}
		}
		else
		{
			echo "not array!<br>";
		}
	}
	else
	{
		echo "error in SQL $query<br>";
	}
	
	mysqli_close($db_connect);
	*/
	//$db_connect=mysqli_connect(host,user,pass,db);
	//$query="update goods SET goods_lider=1 where goods_lidermain=1";
	//mysqli_query($db_connect,$query);
	//$query="update goods SET goods_lidermain=0 where 1";
	//mysqli_query($db_connect,$query);
	//mysqli_close($db_connect);
	/*$db_connect=mysqli_connect(host,user,pass,db);
	$query="SELECT goods_id, goods_name FROM goods WHERE goods_avail=1 AND factory_id!=58";
	if ($res=mysqli_query($db_connect,$query))
	{
		//все в наличии не а-офис, кроме шк акция
		while ($row = mysqli_fetch_assoc($res))
        {
            $goods[] = $row;
        }
		if (is_array($goods))
		{
			foreach ($goods as $good)
			{
				$name=$good['goods_name'];
				$id=$good['goods_id'];
				//var_dump($good);
				echo "$id  $name<br>";
				$str="$id;$name;".PHP_EOL;
				//file_put_contents("avail.csv",$str,FILE_APPEND);
				//break;
			}
			//var_dump($goods);
		}
		//все распрадажные шк в наличии
		$query="SELECT goods_id, goods_name FROM goods WHERE goods_avail=1 AND factory_id=114 AND goods_maintcharter=9";
		if ($res=mysqli_query($db_connect,$query))
		{
			while ($row = mysqli_fetch_assoc($res))
			{
				$goods_sk[] = $row;
			}
			foreach ($goods_sk as $good)
			{
				$name=$good['goods_name'];
				$id=$good['goods_id'];
				//var_dump($good);
				echo "$id  $name<br>";
				$str="$id;$name;".PHP_EOL;
				//file_put_contents("avail.csv",$str,FILE_APPEND);
				//break;
			}
		}
		//var_dump($goods);
		//var_dump();
		$diff=array_diff_assoc($goods,$goods_sk);
		//var_dump($diff);
		foreach ($diff as $good)
			{
				$name=$good['goods_name'];
				$id=$good['goods_id'];
				//var_dump($good);
				//echo "$id  $name<br>";
				$str="$id;$name;".PHP_EOL;
				//file_put_contents("avail.csv",$str,FILE_APPEND);
				//break;
			}
	}
	else
	{
		echo "error in SQL";
	}
	mysqli_close($db_connect);
	*/
	/*$db_connect=mysqli_connect(host,user,pass,db);
	$query="SELECT goods_id, goods_name, goods_avail FROM goods WHERE factory_id=161 or factory_id=163 or factory_id=164 or factory_id=165 or factory_id=166 or factory_id=167 or factory_id=168 or factory_id=169 or factory_id=170 or factory_id=171";
	if ($res=mysqli_query($db_connect,$query))
	{
		while ($row = mysqli_fetch_assoc($res))
        {
            $goods[] = $row;
        }
		//var_dump ($goods);
		echo "<pre>";
		print_r($goods);
		echo "</pre>";
	}
	mysqli_close($db_connect);
	*/
	//для товаров, у которых фабрика не распродажа и товар находится в разделе прямые или угловые или кресла снять галочку лидер
	//$db_connect=mysqli_connect(host,user,pass,db);
	//$query="update goods SET goods_noactual=1 where factory_id=137";
	//mysqli_query($db_connect,$query);
	//mysqli_close($db_connect);
	
	//снять все акции и проценты с матролюкса
	//$db_connect=mysqli_connect(host,user,pass,db);
	//$query="update goods SET goods_stock=0, goods_discount=0 where factory_id=46";
	//mysqli_query($db_connect,$query);
	//mysqli_close($db_connect);
	
	//найти угловые диваны которых нет в прямых
	/*$db_connect=mysqli_connect(host,user,pass,db);
	$query="SELECT goods_id FROM goodshastcharter WHERE tcharter_id=38";
	if ($res=mysqli_query($db_connect,$query))
	{		while ($row = mysqli_fetch_assoc($res))
		{				
			$goods_ugl[] = $row['goods_id'];
		}
	}
	$query="SELECT goods_id FROM goodshastcharter WHERE tcharter_id=1";
	if ($res=mysqli_query($db_connect,$query))
	{		while ($row = mysqli_fetch_assoc($res))
		{				
			$goods_str[] = $row['goods_id'];
		}
	}
	$dif=array_diff($goods_ugl,$goods_str);
	//var_dump($dif);
	echo "<pre>";
	print_r($dif);
	echo "</pre>";*/
//
	//$db_connect=mysqli_connect(host,user,pass,db);
	//$query="update goods SET goods_noactual=1 where factory_id=42";
	//mysqli_query($db_connect,$query);
	//mysqli_close($db_connect);
	
	
	/*$db_connect=mysqli_connect(host,user,pass,db);
    $query="SELECT goods_id, goods_content FROM goods WHERE goods_active=1 AND goods_noactual=0 AND goods_maintcharter=14 AND goods_content LIKE '%you%'";
    if ($res=mysqli_query($db_connect,$query))
    {
        while ($row = mysqli_fetch_assoc($res))
        {
                $goods[] = $row;
        }
    }
	else
	{
		echo "Error in SQL".mysqli_error($db_connect)."<br>";
	}
    mysqli_close($db_connect);
    if (is_array($goods))
	{
		echo "Матрасы с сылкой на видео:<br>";
		foreach ($goods as $good)
		{
			echo $good['goods_id']."<br>";
		}
	}
	else
	{
		echo "No array to work with";
	}*/
	/*
	//все матрасы, у которых стоит фильтр Детские
	$db_connect=mysqli_connect(host,user,pass,db);
    $query="SELECT goods_id, goods_article FROM goods WHERE goods_active=1 AND goods_noactual=0 AND goods_maintcharter=14";
    if ($res=mysqli_query($db_connect,$query))
    {
        while ($row = mysqli_fetch_assoc($res))
        {
                $goods[] = $row;
        }
    }
	else
	{
		echo "Error in SQL ".mysqli_error($db_connect)."<br>";
	}
    //mysqli_close($db_connect);
    if (is_array($goods))
	{
		foreach ($goods as $good)
		{
			$id=$good['goods_id'];
			$art=$good['goods_article'];
			$query="SELECT goodshasfeature_id FROM goodshasfeature WHERE feature_id=52 AND goodshasfeature_valueint=23 AND goods_id=$id";
			if ($res1=mysqli_query($db_connect,$query))
			{
				unset($r);
				while ($row = mysqli_fetch_assoc($res1))
				{
						$r[] = $row;
				}
				//var_dump($r);
				if (is_array($r))
				{
					echo "$art <br>";
				}
				else
				{
					//echo "$id <br>";
				}
			}
			else
			{
				echo "Error in SQL ".mysqli_error($db_connect)."<br>";
			}
			//echo "$query <br>";
			//break;
		}
	}
	else
	{
		echo "No array to work with";
	}
	
	mysqli_close($db_connect);
	*/
	/*$db_connect=mysqli_connect(host,user,pass,db);
    $query="SELECT goods_id, goods_article FROM goods WHERE goods_active=1 AND goods_noactual=0 AND goods_maintcharter=1 AND goodskind_id=26";
	if ($res=mysqli_query($db_connect,$query))
    {
        while ($row = mysqli_fetch_assoc($res))
        {
                $goods[] = $row;
        }
		//echo "<pre>";
		//print_r($goods);
		//echo "</pre>";
		if (is_array($goods))
		{
			foreach($goods as $good)
			{
				echo $good['goods_article']."<br>";
			}
		}
    }
	else
	{
		echo "Error in SQL ".mysqli_error($db_connect)."<br>";
	}
	*/
	/*
	$db_connect=mysqli_connect(host,user,pass,db);
	$query="SELECT goods_id  FROM goods WHERE goods_active=1 AND goods_noactual=0 AND goods_maintcharter=76";
	if ($res=mysqli_query($db_connect,$query))
    {
        while ($row = mysqli_fetch_assoc($res))
        {
                $goods[] = $row;
        }
		//echo "<pre>";
		//print_r($goods);
		//echo "</pre>";
		if (is_array($goods))
		{
			foreach($goods as $good)
			{
				$id=$good['goods_id'];
				$query="SELECT goodshasfeature_id FROM goodshasfeature WHERE feature_id=206 AND goodshasfeature_valueint=2 AND goods_id=$id";
				if ($res=mysqli_query($db_connect,$query))
				{
					unset($arr);
					while ($row = mysqli_fetch_assoc($res))
					{
							$arr[] = $row;
					}
					if (!is_array($arr))
					{
						echo "$id<br>";
					}
				}
				else
				{
					echo "Error in SQL ".mysqli_error($db_connect)."<br>";
				}
			}
		}
    }
	else
	{
		echo "Error in SQL ".mysqli_error($db_connect)."<br>";
	}
	mysqli_close($db_connect);
	*/
	//снять все акции и проценты с комфора
	//$db_connect=mysqli_connect(host,user,pass,db);
	//$query="update goods SET goods_stock=0, goods_discount=0 where factory_id=35";
	//mysqli_query($db_connect,$query);
	//mysqli_close($db_connect);
	
	//снять все акции и проценты с комфора
	//$db_connect=mysqli_connect(host,user,pass,db);
	//$query="update goods SET goods_ noactual=1 where factory_id=107";
	//mysqli_query($db_connect,$query);
	//mysqli_close($db_connect);
	
	
	/*
	function insSP($pos)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$id=$pos['goods_id'];
        $cont=$pos['goods_content'];
		$cont1=str_ireplace("Видео-презинтация","Видео-презентация",$cont);
		$query="UPDATE goods SET goods_content='$cont1' WHERE goods_id=$id";
		mysqli_query($db_connect,$query);
		//echo mysqli_error($db_connect)."<br>";
		//echo "$query <br>";
		mysqli_close($db_connect);
	}
	$db_connect=mysqli_connect(host,user,pass,db);
	$query="SELECT goods_id, goods_content FROM goods WHERE goods_active=1 AND goods_noactual=0 AND factory_id=36";
	if ($res=mysqli_query($db_connect,$query))
    {
            while ($row = mysqli_fetch_assoc($res))
            {
                $goods[] = $row;
            }
            //var_dump($goods);
			//echo "<pre>";
			//print_r ($factories);
			//echo "</pre>";
			if (is_array($goods))
			{
				foreach ($goods as $good)
				{
					insSP($good);
					//break;
				}
			}
			else
			{
				echo "No array";
			}
			
    }
	else
	{
		echo "Error in SQL ".mysqli_error($db_connect)."<br>";
	}
	mysqli_close($db_connect);
	*/
	
	///////////////////////////////////////
	///////////////////////////////////////
	/*$db_connect=mysqli_connect(host,user,pass,db);
	$query="SELECT factory_name, factory_id, factory_soft FROM factory WHERE factory_noactual=0";
	if ($res=mysqli_query($db_connect,$query))
    {
            while ($row = mysqli_fetch_assoc($res))
            {
                $factories[] = $row;
            }
            //var_dump($goods);
			//echo "<pre>";
			//print_r ($factories);
			//echo "</pre>";
    }
	else
	{
		echo "Error in SQL ".mysqli_error($db_connect)."<br>";
	}
	if (is_array($factories))
	{
		foreach ($factories as $factory)
		{
			//unset ($categories);
			$f_id=$factory['factory_id'];
			$f_name=$factory['factory_name'];
			$f_soft=$factory['factory_soft'];
			if ($f_soft==1)
			{
				echo "<b>$f_name</b> мягкая мебель<br>";
			}
			else
			{
				echo "<b>$f_name</b><br>";
			}
			
		}
	}
	else
	{
		echo "No array";
	}
	mysqli_close($db_connect);
	*/
	$db_connect=mysqli_connect(host,user,pass,db);
	//как выбрать кровать
	$query="SELECT count(goods_id) FROM goods WHERE goods_parent=goods_id AND goods_active=1 AND goods_noactual=0 AND goods_content LIKE '%VcNJvc7nrnE%'";
	if ($res=mysqli_query($db_connect,$query))
    {
            while ($row = mysqli_fetch_assoc($res))
            {
                $goods = $row;
            }
            echo "кровати родители<br>";
			var_dump($goods);
			//echo "<pre>";
			//print_r ($factories);
			//echo "</pre>";
    }
	//echo $goods['count(goods_id)'];
	else
	{
		echo "Error in SQL ".mysqli_error($db_connect)."<br>";
	}
	mysqli_close($db_connect);
	
?>

