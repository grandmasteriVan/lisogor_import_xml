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
	//$query="update goods SET goods_noactual=1 where factory_id=142";
	//mysqli_query($db_connect,$query);
	//mysqli_close($db_connect);
	
	//снять все акции и проценты с матролюкса
	//$db_connect=mysqli_connect(host,user,pass,db);
	//$query="update goods SET goods_stock=0, goods_discount=0, goods_oldprice=0 where factory_id=46";
	//mysqli_query($db_connect,$query);
	//mysqli_close($db_connect);
	
	//снять все акции и проценты с слип енд флай
	//$db_connect=mysqli_connect(host,user,pass,db);
	//$query="update goods SET goods_stock=0, goods_discount=0, goods_oldprice=0 where factory_id=124";
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
	/*
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
	*/
	/*
	$db_connect=mysqli_connect(host,user,pass,db);
	$query="SELECT goods_id, goods_name FROM goods WHERE goods_maintcharter=14";
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
					$name=$good['goods_name'];
					$id=$good['goods_id'];
					$name_new=str_ireplace("Матрас ","",$name);
					echo "$id  $name-$name_new<br>";
					$query="UPDATE goods SET goods_name='$name_new' WHERE goods_id=$id";
					mysqli_query($db_connect,$query);
					
				}
			}
    }
	//echo $goods['count(goods_id)'];
	else
	{
		echo "Error in SQL ".mysqli_error($db_connect)."<br>";
	}
	mysqli_close($db_connect);
	*/
	/*
	function getNumTov($f_id)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="SELECT count(goods_id) FROM goods WHERE goods_active=1 AND goods_noactual=0 AND factory_id=$f_id";
		if ($res=mysqli_query($db_connect,$query))
		{
				while ($row = mysqli_fetch_assoc($res))
				{
					$count = $row;
				}
				//var_dump($goods);
				//echo "<pre>";
				//print_r ($factories);
				//echo "</pre>";
				$count=$count['count(goods_id)'];
		}
		//echo $goods['count(goods_id)'];
		else
		{
			echo "Error in SQL ".mysqli_error($db_connect)."<br>";
		}
		mysqli_close($db_connect);
		return $count;
	}
	
	function getFactories()
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="SELECT factory_name, factory_id FROM factory WHERE factory_noactual=0";
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
				return $factories;
			}
			else
			{
				return null;
			}
	}
	
	
	$db_connect=mysqli_connect(host,user,pass,db);
	$factories=getFactories();
	if (is_array($factories))
	{
		foreach ($factories as $factory)
		{
			$name=$factory['factory_name'];
			$id=$factory['factory_id'];
			$num=getNumTov($id);
			if ($num<=5)
			{
				echo "<b>$name</b> имеет <b>$num</b> активных товаров!!!<br>";
			}
		}
	}
	mysqli_close($db_connect);
	*/
	/*
	$db_connect=mysqli_connect(host,user,pass,db);
	$query="SELECT goods_id FROM goods WHERE factory_id=7";
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
					$id=$good['goods_id'];
					$query="SELECT goodshasfeature_id, feature_id, goodshasfeature_valueint FROM goodshasfeature WHERE goods_id=$id";
					unset($features);
					if ($res=mysqli_query($db_connect,$query))
					{
						while ($row = mysqli_fetch_assoc($res))
						{
							$features[] = $row;
						}
						if (is_array($features))
						{
							foreach ($features as $feature)
							{
								$goodshasfeature_id=$feature['goodshasfeature_id'];
								$f_val=$feature['goodshasfeature_valueint'];
								$f_id=$feature['feature_id'];
								//материал оббивки
								if ($f_id==17&&$f_val==3)
								{
									$query="UPDATE goodshasfeature SET goodshasfeature_valueint=1 WHERE goodshasfeature_id=$goodshasfeature_id AND goods_id=$id";
									mysqli_query($db_connect,$query);
									echo "goods_id=$id $query<br>";
								}
								//удаляем материал
								if ($f_id==60)
								{
									$query="DELETE FROM goodshasfeature WHERE goodshasfeature_id=$goodshasfeature_id AND goods_id=$id";
									mysqli_query($db_connect,$query);
									echo "goods_id=$id $query<br>";
								}
							}
						}
						else
						{
							echo "$id has no features<br>";
						}
					}	
					else
					{
						echo "Error in SQL ".mysqli_error($db_connect)."<br>";
					}
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
	
	//удаляем материал вообще из всех диванов
	$query="SELECT goods_id FROM goods WHERE goods_maintcharter=1 OR goods_maintcharter=3 OR goods_maintcharter=2";
	if ($res=mysqli_query($db_connect,$query))
	{
		unset($goods);
		while ($row = mysqli_fetch_assoc($res))
        {
                $goods[] = $row;
        }
		if (is_array($goods))
		{
			foreach ($goods as $good)
			{
				$id=$good['goods_id'];
				$query="DELETE FROM goodshasfeature WHERE feature_id=60 AND goods_id=$id";
				mysqli_query($db_connect,$query);
				echo "goods_id=$id $query<br>";
			}
			
		}
	}
	else
	{
		echo "Error in SQL ".mysqli_error($db_connect)."<br>";
	}

	mysqli_close($db_connect);
*/
/*
	function modMatr($goods_maintcharter=14)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goods_id, goods_parent, goods_content FROM goods WHERE (goods_maintcharter=$goods_maintcharter OR goods_maintcharter=150) AND goods_parent<>goods_id AND goods_noactual=0 AND goods_active=1 AND factory_id=124";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $arr[] = $row;
            }
        }
        mysqli_close($db_connect);
        return $arr;
    }
    /**
     * @param int $goods_maintcharter
     * @return array
     *//*
    function parrentMatr($goods_maintcharter=14)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goods_id, goods_parent, goods_content FROM goods WHERE (goods_maintcharter=$goods_maintcharter OR goods_maintcharter=150) and goods_parent=goods_id AND goods_noactual=0 AND goods_active=1 AND factory_id=124";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $arr[] = $row;
            }
        }
        mysqli_close($db_connect);
        /*echo "<pre>";
        print_r ($arr);
        echo "</pre>";*//*
        return $arr;
    }
	$db_connect=mysqli_connect(host,user,pass,db);
	$par=parrentMatr();
	//var_dump($par);
	$mod=modMatr();
	//echo "<br><br>MOD<br>";
	//var_dump($mod);
	if (is_array($par))
	{
		foreach ($par as $parrent)
		{
			$par_id=$parrent['goods_id'];
			$par_cont=$parrent['goods_content'];
			if (is_array($mod))
			{
				foreach ($mod as $mod_mart)
				{
					if ($par_id==$mod_mart['goods_parent'])
					{
						$mod_id=$mod_mart['goods_id'];
						$query="UPDATE goods SET goods_content='$par_cont' WHERE goods_id=$mod_id";
						mysqli_query($db_connect,$query);
						//echo "$query<br>";
					}
					
					
				}
			}
			else
			{
				echo "No mod matr!<br>";
			}
			//break;
		}
	}
	else
	{
		echo "No parrent matr!<br>";
	}
	mysqli_close($db_connect);
	*/
	/*
	$db_connect=mysqli_connect(host,user,pass,db);
	$query="SELECT goods_id FROM goodshasfeature WHERE feature_id=14 and goodshasfeature_valueid=91";
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
				$id=$good['goods_id'];
				$query="UPDATE goods SET goods_popular=-200 WHERE goods_id=$id";
				echo "$query <br>";
				mysqli_query($db_connect,$query);
			}
		}
		else
		{
			echo "No array!<br>";
		}
	}
	else
	{
		echo "Error in SQL ".mysqli_error($db_connect)."<br>";
	}
	mysqli_close($db_connect);
	*/
	/*
	$db_connect=mysqli_connect(host,user,pass,db);
	$query="SELECT goods_id FROM goods WHERE factory_id=7 AND goods_article_1c=''";
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
				$id=$good['goods_id'];
				$query="SELECT component_child FROM component WHERE goods_id=$id";
				unset ($components);
				if ($res=mysqli_query($db_connect,$query))
				{
					while ($row = mysqli_fetch_assoc($res))
					{
						$components[] = $row;
					}
					if (is_array ($components))
					{
						foreach ($components as $component)
						{
							$comp_id=$component['component_child'];
							$query="UPDATE goodshastcharter SET tcharter_id=147 WHERE goods_id=$comp_id";
							echo "$query <br>";
							mysqli_query($db_connect,$query);
							$query="UPDATE goods SET goods_maintcharter=147 WHERE goods_id=$comp_id";
							echo "$query <br>";
							mysqli_query($db_connect,$query);
						}
					}
					else
					{
						echo "No components for id=$id<br>";
					}
				}
				else
				{
					echo "Error in SQL ".mysqli_error($db_connect)."<br>";
				}
				//break;
			}
		}
		else
		{
			echo "No array!<br>";
		}
	}
	else
	{
		echo "Error in SQL ".mysqli_error($db_connect)."<br>";
	}
	mysqli_close($db_connect);
	*/
	
	//снять все акции и проценты с асат
	//$db_connect=mysqli_connect(host,user,pass,db);
	//$query="update goods SET goods_stock=0, goods_discount=0, goods_oldprice=0 where factory_id=197";
	//mysqli_query($db_connect,$query);
	//mysqli_close($db_connect);
	
	
	//список диванов только с одним наполнением
	/*
	$db_connect=mysqli_connect(host,user,pass,db);
	$query="SELECT goods_id FROM goods WHERE goods_maintcharter=1 OR goods_maintcharter=38 OR goods_maintcharter=2 AND goods_active=1 AND goods_noactual=0";
	if ($res=mysqli_query($db_connect,$query))
	{
		unset($goods);
		while ($row = mysqli_fetch_assoc($res))
        {
                $goods[] = $row;
        }
		if (is_array($goods))
		{
			foreach ($goods as $good)
			{
				$id=$good['goods_id'];
				unset($feature);
				$query="SELECT goodshasfeature_valueint FROM goodshasfeature WHERE feature_id=4 AND goods_id=$id";
				if ($res=mysqli_query($db_connect,$query))
				{
					
					while ($row = mysqli_fetch_assoc($res))
					{
						$feature[] = $row;
					}
					if (is_array($feature))
					{
						//var_dump($feature);
						if (count($feature)==1&&$feature[0]['goodshasfeature_valueint']==2)
						{
							echo "$id<br>";
						}
					}
					else
					{
						echo "$id не имеет наполнения!<br>";
					}
					
				}
				else
				{
					echo "Error in SQL ".mysqli_error($db_connect)."<br>";
				}
				
				//break;
				
			}
			
			
		}
	}
	else
	{
		echo "Error in SQL ".mysqli_error($db_connect)."<br>";
	}

	mysqli_close($db_connect);
	*/
	/*
	echo "<br><br><br><b>DDN</b><br>";
	$db_connect=mysqli_connect(host_ddn,user_ddn,pass_ddn,db_ddn);
	$query="SELECT goods_id FROM goods";
	if ($res=mysqli_query($db_connect,$query))
	{
		unset($goods);
		while ($row = mysqli_fetch_assoc($res))
        {
                $goods[] = $row;
        }
		if (is_array($goods))
		{
			foreach ($goods as $good)
			{
				$id=$good['goods_id'];
				unset($feature);
				$query="SELECT goodshasfeature_valueid FROM goodshasfeature WHERE feature_id=3 AND goods_id=$id";
				if ($res=mysqli_query($db_connect,$query))
				{
					
					while ($row = mysqli_fetch_assoc($res))
					{
						$feature[] = $row;
					}
					if (is_array($feature))
					{
						//var_dump($feature);
						if (count($feature)==1&&($feature[0]['goodshasfeature_valueint']==43||$feature[0]['goodshasfeature_valueint']==44))
						{
							echo "$id<br>";
						}
					}
					else
					{
						echo "$id не имеет наполнения!<br>";
					}
					
				}
				else
				{
					echo "Error in SQL ".mysqli_error($db_connect)."<br>";
				}
				
				//break;
				
			}
			
			
		}
	}
	else
	{
		echo "Error in SQL ".mysqli_error($db_connect)."<br>";
	}
	mysqli_close($db_connect);
	*/
	
	//список активный фабрик ФМ
	/*
	$db_connect=mysqli_connect(host,user,pass,db);
	$query="SELECT factory_name FROM factory WHERE factory_active=1";
	if ($res=mysqli_query($db_connect,$query))
	{
		unset($goods);
		while ($row = mysqli_fetch_assoc($res))
        {
                $factoryes[] = $row;
        }
		if (is_array($factoryes))
		{
			foreach ($factoryes as $factory)
			{
				$name=$factory['factory_name'];
				echo "$name<br>";
				
			}
		}
	}
	else
	{
		echo "Error in SQL ".mysqli_error($db_connect)."<br>";
	}
	mysqli_close($db_connect);
	*/
	
	/*function getGoods()
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goods_id, goods_name FROM goods WHERE goods_active=1 AND goods_noactual=0 AND factory_id=154";
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
        mysqli_close($db_connect);
        if (!empty($goods))
        {
            return $goods;
        }
        return 0;
    }
	$db_connect=mysqli_connect(host,user,pass,db);
        $goods=getGoods();
        if (is_array($goods))
        {
            foreach ($goods as $good)
            {
                $id=$good['goods_id'];
                $name=" ".$good['goods_name'];
                if ((mb_strpos($name, "Пенал")||mb_strpos($name, "пенал")||mb_strpos($name, "Стеллаж")||mb_strpos($name, "стеллаж")||mb_strpos($name, "Витрина")||mb_strpos($name, "витрина")||mb_strpos($name, "Угловой элемент")||mb_strpos($name, "угловой элемент")||mb_strpos($name, "Сервант")||mb_strpos($name, "сервант"))&&(!mb_strpos($name, "Кухня")))
                {
                    echo "$name<br>";
					$query="DELETE FROM goodshastcharter WHERE goods_id=$id";
                    mysqli_query($db_connect,$query);
                    echo $query."<br>";
                    $query="INSERT INTO goodshastcharter (goods_id, tcharter_id) VALUES ($id,71)";
                    mysqli_query($db_connect,$query);
					echo $query."<br>";
                    $query="UPDATE goods SET goods_maintcharter=71 WHERE goods_id=$id";
                    mysqli_query($db_connect,$query);
                    echo $query."<br>";
                }
                
            }
        }
        else
        {
            echo "No goods!<br>";
        }
        mysqli_close($db_connect);
		*/
		
	//отключить все товары слип енд флай
	//$db_connect=mysqli_connect(host,user,pass,db);
	//$query="update goods SET goods_noactual=1 where factory_id=124";
	//mysqli_query($db_connect,$query);
	//mysqli_close($db_connect);
	/*
	function getGoods()
	{
		$db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goods_id FROM goods WHERE factory_id=205 AND goods_maintcharter=13";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $goods[] = $row;
            }
        }
        else
        {
            echo "Error in SQL getGood ".mysqli_error($db_connect)."<br>";
        }
        mysqli_close($db_connect);
        return $goods;
	}
	$db_connect=mysqli_connect(host,user,pass,db);
	$goods=getGoods();
	if (is_array($goods))
	{
		foreach ($goods as $good)
		{
			$id=$good['goods_id'];
			$content="<p style=\"text-align: center;\"><iframe allow=\"encrypted-media\" allowfullscreen=\"\" frameborder=\"0\" gesture=\"media\" height=\"214\" src=\"https://www.youtube.com/embed/EoGsmck1bZI\" style=\"text-align: center;\" width=\"380\"></iframe></p>
<p></p>
<p>Возможные цвета кровати: белый, бежевый, коричневый, черный бархат, черный глянец, бордо, черное/серебро, черное/золото, черная медь, белое/серебро, белый бархат.</p>
<p>Основание под матрас - металлические трубки. За дополнительную плату возможно заказать: учащённые металличские трубки, металлические трубки + ДВП подложка, буковые ламели. Стоимость уточняйте у менеджера.</p>";
			$query="UPDATE goods SET goods_content='$content' WHERE goods_id=$id";
			mysqli_query($db_connect,$query);
			echo "$query<br>";
			//break;
		}
	}
	else
	{
		echo "No array!<br>";
	}
	mysqli_close($db_connect);
	*/
	/*
	$db_connect=mysqli_connect(host,user,pass,db);
    $query="SELECT count(goods_id) FROM goods WHERE goods_active=1 AND goods_noactual=0 AND goods_productionout=0 AND (goods_maintcharter=5 OR goods_maintcharter=11 OR goods_maintcharter=4 OR goods_maintcharter=40 OR goods_maintcharter=98 )";
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
	var_dump($goods);
    mysqli_close($db_connect);
    */  
    /*    
	$db_connect=mysqli_connect(host,user,pass,db);
    $query="SELECT goods_id FROM goods WHERE goods_active=1 AND goods_noactual=0 AND goods_productionout=0 AND (goods_maintcharter=14 OR goods_maintcharter=150) AND goods_content NOT LIKE '%JF1wYXFtPck%'";
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
	echo "<b>Матрасы, в котором нет видео JF1wYXFtPck (как выбрать матрас)</b><br>";
	echo "<pre>";
	print_r ($goods);
	echo "</pre>";
    mysqli_close($db_connect);
	
	$db_connect=mysqli_connect(host,user,pass,db);
	unset ($goods);
    $query="SELECT goods_id FROM goods WHERE goods_active=1 AND goods_noactual=0 AND goods_productionout=0 AND (goods_maintcharter=13 OR goods_maintcharter=33) AND goods_content NOT LIKE '%EoGsmck1bZI%'";
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
	echo "<b>Кровати, в котором нет видео EoGsmck1bZI (как выбрать кровать)</b><br>";
	echo "<pre>";
	print_r ($goods);
	echo "</pre>";
    mysqli_close($db_connect);
	*/
	/*
	//включить все нужные категории во всех товарах ливс
	$db_connect=mysqli_connect(host,user,pass,db);
	$query="select goods_id from goods where factory_id=7";
	//$cat_id=1073;
	if ($res=mysqli_query($db_connect,$query))
    {
            while ($row = mysqli_fetch_assoc($res))
            {
                $goods[] = $row;
            }
            //var_dump($goods);
			//echo "<pre>";
			//print_r ($goods);
			//echo "</pre>";
			foreach ($goods as $good)
			{
				$id=$good['goods_id'];
				
				//a
				$cat_id=39;
				if (checkDuplicate($id,$cat_id))
				{
					echo "good $id has A category<br>";
					$query="update goodshascategory SET goodshascategory_active=1 where category_id=$cat_id and goods_id=$id";
					//echo "$query<br>";
					mysqli_query($db_connect,$query);
				}
				else
				{
					$query="insert into goodshascategory (category_id, goods_id, goodshascategory_price, goodshascategory_active, goodshascategory_pricecur) VALUES ($cat_id,$id,0,1,0)";
					echo "$query<br>";
					mysqli_query($db_connect,$query);
				}
				//0
				$cat_id=68;
				if (checkDuplicate($id,$cat_id))
				{
					echo "good $id has 0 category<br>";
					$query="update goodshascategory SET goodshascategory_active=1 where category_id=$cat_id and goods_id=$id";
					//echo "$query<br>";
					mysqli_query($db_connect,$query);
				}
				else
				{
					$query="insert into goodshascategory (category_id, goods_id, goodshascategory_price, goodshascategory_active, goodshascategory_pricecur) VALUES ($cat_id,$id,0,1,0)";
					echo "$query<br>";
					mysqli_query($db_connect,$query);
				}
				//1
				$cat_id=69;
				if (checkDuplicate($id,$cat_id))
				{
					echo "good $id has 1 category<br>";
					$query="update goodshascategory SET goodshascategory_active=1 where category_id=$cat_id and goods_id=$id";
					//echo "$query<br>";
					mysqli_query($db_connect,$query);
				}
				else
				{
					$query="insert into goodshascategory (category_id, goods_id, goodshascategory_price, goodshascategory_active, goodshascategory_pricecur) VALUES ($cat_id,$id,0,1,0)";
					echo "$query<br>";
					mysqli_query($db_connect,$query);
				}
				//2
				$cat_id=543;
				if (checkDuplicate($id,$cat_id))
				{
					echo "good $id has 2 category<br>";
					$query="update goodshascategory SET goodshascategory_active=1 where category_id=$cat_id and goods_id=$id";
					//echo "$query<br>";
					mysqli_query($db_connect,$query);
				}
				else
				{
					$query="insert into goodshascategory (category_id, goods_id, goodshascategory_price, goodshascategory_active, goodshascategory_pricecur) VALUES ($cat_id,$id,0,1,0)";
					echo "$query<br>";
					mysqli_query($db_connect,$query);
				}
				//3
				$cat_id=544;
				if (checkDuplicate($id,$cat_id))
				{
					echo "good $id has 3 category<br>";
					$query="update goodshascategory SET goodshascategory_active=1 where category_id=$cat_id and goods_id=$id";
					//echo "$query<br>";
					mysqli_query($db_connect,$query);
				}
				else
				{
					$query="insert into goodshascategory (category_id, goods_id, goodshascategory_price, goodshascategory_active, goodshascategory_pricecur) VALUES ($cat_id,$id,0,1,0)";
					echo "$query<br>";
					mysqli_query($db_connect,$query);
				}
				//4
				$cat_id=545;
				if (checkDuplicate($id,$cat_id))
				{
					echo "good $id has 4 category<br>";
					$query="update goodshascategory SET goodshascategory_active=1 where category_id=$cat_id and goods_id=$id";
					//echo "$query<br>";
					mysqli_query($db_connect,$query);
				}
				else
				{
					$query="insert into goodshascategory (category_id, goods_id, goodshascategory_price, goodshascategory_active, goodshascategory_pricecur) VALUES ($cat_id,$id,0,1,0)";
					echo "$query<br>";
					mysqli_query($db_connect,$query);
				}
				//5
				$cat_id=546;
				if (checkDuplicate($id,$cat_id))
				{
					echo "good $id has 5 category<br>";
					$query="update goodshascategory SET goodshascategory_active=1 where category_id=$cat_id and goods_id=$id";
					//echo "$query<br>";
					mysqli_query($db_connect,$query);
				}
				else
				{
					$query="insert into goodshascategory (category_id, goods_id, goodshascategory_price, goodshascategory_active, goodshascategory_pricecur) VALUES ($cat_id,$id,0,1,0)";
					echo "$query<br>";
					mysqli_query($db_connect,$query);
				}
				//6
				$cat_id=547;
				if (checkDuplicate($id,$cat_id))
				{
					echo "good $id has 6 category<br>";
					$query="update goodshascategory SET goodshascategory_active=1 where category_id=$cat_id and goods_id=$id";
					//echo "$query<br>";
					mysqli_query($db_connect,$query);
				}
				else
				{
					$query="insert into goodshascategory (category_id, goods_id, goodshascategory_price, goodshascategory_active, goodshascategory_pricecur) VALUES ($cat_id,$id,0,1,0)";
					echo "$query<br>";
					mysqli_query($db_connect,$query);
				}
				//7
				$cat_id=548;
				if (checkDuplicate($id,$cat_id))
				{
					echo "good $id has 7 category<br>";
					$query="update goodshascategory SET goodshascategory_active=1 where category_id=$cat_id and goods_id=$id";
					//echo "$query<br>";
					mysqli_query($db_connect,$query);
				}
				else
				{
					$query="insert into goodshascategory (category_id, goods_id, goodshascategory_price, goodshascategory_active, goodshascategory_pricecur) VALUES ($cat_id,$id,0,1,0)";
					echo "$query<br>";
					mysqli_query($db_connect,$query);
				}
				//8
				$cat_id=549;
				if (checkDuplicate($id,$cat_id))
				{
					echo "good $id has 8 category<br>";
					$query="update goodshascategory SET goodshascategory_active=1 where category_id=$cat_id and goods_id=$id";
					//echo "$query<br>";
					mysqli_query($db_connect,$query);
				}
				else
				{
					$query="insert into goodshascategory (category_id, goods_id, goodshascategory_price, goodshascategory_active, goodshascategory_pricecur) VALUES ($cat_id,$id,0,1,0)";
					echo "$query<br>";
					mysqli_query($db_connect,$query);
				}
				//9
				$cat_id=550;
				if (checkDuplicate($id,$cat_id))
				{
					echo "good $id has 9 category<br>";
					$query="update goodshascategory SET goodshascategory_active=1 where category_id=$cat_id and goods_id=$id";
					//echo "$query<br>";
					mysqli_query($db_connect,$query);
				}
				else
				{
					$query="insert into goodshascategory (category_id, goods_id, goodshascategory_price, goodshascategory_active, goodshascategory_pricecur) VALUES ($cat_id,$id,0,1,0)";
					echo "$query<br>";
					mysqli_query($db_connect,$query);
				}
				//10
				$cat_id=551;
				if (checkDuplicate($id,$cat_id))
				{
					echo "good $id has 10 category<br>";
					$query="update goodshascategory SET goodshascategory_active=1 where category_id=$cat_id and goods_id=$id";
					//echo "$query<br>";
					mysqli_query($db_connect,$query);
				}
				else
				{
					$query="insert into goodshascategory (category_id, goods_id, goodshascategory_price, goodshascategory_active, goodshascategory_pricecur) VALUES ($cat_id,$id,0,1,0)";
					echo "$query<br>";
					mysqli_query($db_connect,$query);
				}
				//11
				$cat_id=552;
				if (checkDuplicate($id,$cat_id))
				{
					echo "good $id has 11 category<br>";
					$query="update goodshascategory SET goodshascategory_active=1 where category_id=$cat_id and goods_id=$id";
					//echo "$query<br>";
					mysqli_query($db_connect,$query);
				}
				else
				{
					$query="insert into goodshascategory (category_id, goods_id, goodshascategory_price, goodshascategory_active, goodshascategory_pricecur) VALUES ($cat_id,$id,0,1,0)";
					echo "$query<br>";
					mysqli_query($db_connect,$query);
				}
				//12
				$cat_id=553;
				if (checkDuplicate($id,$cat_id))
				{
					echo "good $id has 12 category<br>";
					$query="update goodshascategory SET goodshascategory_active=1 where category_id=$cat_id and goods_id=$id";
					//echo "$query<br>";
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
	
	//проверка не дублируются ли категории
	function checkDuplicate($id,$cat_id)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="SELECT 	goodshascategory_id FROM goodshascategory WHERE goods_id=$id AND category_id=$cat_id";
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
	}*/
	
	//$db_connect=mysqli_connect(host,user,pass,db);
	//$query="update goods SET goods_noactual=0 where factory_id=142";
	//mysqli_query($db_connect,$query);
	//mysqli_close($db_connect);
	
	
	/*$db_connect=mysqli_connect(host,user,pass,db);
	$query="select goods_name, goods_content from goods where goods_active=1 AND goods_noactual=0";
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
		foreach($goods as $good)
		{
			$name=$good['goods_name'];
			$text=$good['goods_content'];
			$text=strip_tags($text);
			$file=$name.PHP_EOL.$text.PHP_EOL.PHP_EOL;
			file_put_contents("texts_fm.txt",$file,FILE_APPEND);
		}
	}
	
	
	mysqli_close($db_connect);
	*/
	/*
	$db_connect=mysqli_connect(host,user,pass,db);
    $query="update goods SET goods_stock=0, goods_discount=0, goods_oldprice=0 where factory_id=35";
    mysqli_query($db_connect,$query);
    mysqli_close($db_connect);
	*/
	/*
	$db_connect=mysqli_connect(host,user,pass,db);
	$query="update goods SET goods_noactual=1 where factory_id=139";
	mysqli_query($db_connect,$query);
	mysqli_close($db_connect);
	
	$db_connect=mysqli_connect(host,user,pass,db);
	$query="update goods SET goods_noactual=1 where factory_id=135";
	mysqli_query($db_connect,$query);
	mysqli_close($db_connect);
	
	$db_connect=mysqli_connect(host,user,pass,db);
	$query="update goods SET goods_noactual=1 where factory_id=150";
	mysqli_query($db_connect,$query);
	mysqli_close($db_connect);
	
	$db_connect=mysqli_connect(host,user,pass,db);
	$query="update goods SET goods_noactual=1 where factory_id=158";
	mysqli_query($db_connect,$query);
	mysqli_close($db_connect);
	
	$db_connect=mysqli_connect(host,user,pass,db);
	$query="update goods SET goods_noactual=1 where factory_id=152";
	mysqli_query($db_connect,$query);
	mysqli_close($db_connect);
	
	
	$db_connect=mysqli_connect(host,user,pass,db);
	$query="update goods SET goods_noactual=1 where factory_id=142";
	mysqli_query($db_connect,$query);
	mysqli_close($db_connect);
	*/
	/*$db_connect=mysqli_connect(host,user,pass,db);
	$query="UPDATE goods SET goods_noactual=0 WHERE factory_id=97";
	mysqli_query($db_connect,$query);
	mysqli_close($db_connect);*/
	/*
	//скопировать фильтры и контент из родительского товара фабрики его дочкам
	public function copyFilters()
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        //return;
		$parent_list=$this->parrentMatr();
        $mod_list=$this->modMatr();
		//return;
        foreach ($parent_list as $parent)
        {
            $parent_id=$parent['goods_id'];
			//главный раздел каталога матраса
			$maintcharter=$parent['goods_maintcharter'];
			//идем по дочкам
            foreach ($mod_list as $mod)
            {
                if ($parent['goods_id'] == $mod['goods_parent'])
                {
                    $mod_id = $mod['goods_id'];
                    $mod_size = $mod['goods_width'];
                    $mod_size_l = $mod['goods_length'];
					//прописываем тот же главный раздел каталога дочке, что и родителю
					$query="UPDATE goods SET goods_maintcharter=$maintcharter WHERE goods_id=$mod_id";
					mysqli_query($db_connect, $query);
					
                    //echo "<br><b>$mod_size * $mod_size_l</b><br>";
                    //дропаем старые записи
                    $query = "DELETE FROM goodshasfeature WHERE goods_id=$mod_id";
                    mysqli_query($db_connect, $query);
                    //echo $query."<br>";
                    //для каждой фичи записываем ее в БД
                    foreach ($features as $feat)
                    {
                        //echo "копируем фильтры<br>";
                        $goodshasfeature_valueint = $feat['goodshasfeature_valueint'];
                        $goodshasfeature_valuefloat = $feat['goodshasfeature_valuefloat'];
                        $goodshasfeature_valuetext = $feat['goodshasfeature_valuetext'];
                        $feature_id = $feat['feature_id'];
                        //пишем размерность (одно/полтора/двуспальные)

                        //не пишем ненужные значния
                        if ($feature_id == 93 || $feature_id == 33 || $feature_id == 52 || $feature_id == 53 || $feature_id == 55 || $feature_id == 54 || $feature_id == 56 || $feature_id == 147) {
                            $query = "INSERT INTO goodshasfeature (goodshasfeature_valueint, goodshasfeature_valuefloat, " .
                                "goodshasfeature_valuetext, goods_id, feature_id) " .
                                "VALUES ($goodshasfeature_valueint, $goodshasfeature_valuefloat, " .
                                "'$goodshasfeature_valuetext', $mod_id, $feature_id)";
                            mysqli_query($db_connect, $query);
                            //echo "Удачно!<br>";
                            //echo $query."<br>";
                        }
                    }
                    //////////////////////
                   ///пишем размеры
                    if ($mod_size <= 900)
                    {
                        //$goodshasfeature_valueint=1;
                        $this->setFilter($mod_id, 192, 1);
                    }
                    if ($mod_size > 900 && $mod_size <= 1500)
                    {
                        //$goodshasfeature_valueint=3;
                        $this->setFilter($mod_id, 192, 3);
                    }
                    if ($mod_size > 1500)
                    {
                        //$goodshasfeature_valueint=2;
                        $this->setFilter($mod_id, 192, 2);
                    }
                    //пишем размер
                    if ($mod_size == 600 && $mod_size_l == 1200)
                    {
                        //$goodshasfeature_valueint=1;
                        $this->setFilter($mod_id, 211, 2);
                    }
                    if ($mod_size == 700 && $mod_size_l == 1400)
                    {
                        $this->setFilter($mod_id, 211, 2);
                    }
                    if ($mod_size == 700 && $mod_size_l == 1900)
                    {
                        $this->setFilter($mod_id, 211, 3);
                    }
                    if ($mod_size == 700 && $mod_size_l == 2000)
                    {
                        $this->setFilter($mod_id, 211, 4);
                    }
                    if ($mod_size == 800 && $mod_size_l == 1600)
                    {
                        $this->setFilter($mod_id, 211, 5);
                    }
                    if ($mod_size == 800 && $mod_size_l == 1900)
                    {
                        $this->setFilter($mod_id, 211, 6);
                    }
                    if ($mod_size == 800 && $mod_size_l == 2000)
                    {
                        $this->setFilter($mod_id, 211, 7);
                    }
                    if ($mod_size == 900 && $mod_size_l == 1900)
                    {
                        $this->setFilter($mod_id, 211, 8);
                    }
                    if ($mod_size == 900 && $mod_size_l == 2000)
                    {
                        $this->setFilter($mod_id, 211, 9);
                    }
                    if ($mod_size == 1000 && $mod_size_l == 1900)
                    {
                        $this->setFilter($mod_id, 211, 10);
                    }
                    if ($mod_size == 1000 && $mod_size_l == 2000)
                    {
                        $this->setFilter($mod_id, 211, 11);
                    }
                    if ($mod_size == 1200 && $mod_size_l == 1900)
                    {
                        $this->setFilter($mod_id, 211, 12);
                    }
                    if ($mod_size == 1200 && $mod_size_l == 2000)
                    {
                        $this->setFilter($mod_id, 211, 13);
                    }
                    if ($mod_size == 1400 && $mod_size_l == 1900)
                    {
                        $this->setFilter($mod_id, 211, 14);
                    }
                    if ($mod_size == 1400 && $mod_size_l == 2000)
                    {
                        $this->setFilter($mod_id, 211, 15);
                    }
                    if ($mod_size == 1500 && $mod_size_l == 1900)
                    {
                        $this->setFilter($mod_id, 211, 16);
                    }
                    if ($mod_size == 1500 && $mod_size_l == 2000)
                    {
                        $this->setFilter($mod_id, 211, 17);
                    }
                    if ($mod_size == 1600 && $mod_size_l == 1900)
                    {
                        $this->setFilter($mod_id, 211, 18);
                    }
                    if ($mod_size == 1600 && $mod_size_l == 2000)
                    {
                        $this->setFilter($mod_id, 211, 19);
                    }
                    if ($mod_size == 1700 && $mod_size_l == 1900)
                    {
                        $this->setFilter($mod_id, 211, 20);
                    }
                    if ($mod_size == 1700 && $mod_size_l == 2000)
                    {
                        $this->setFilter($mod_id, 211, 21);
                    }
                    if ($mod_size == 1800 && $mod_size_l == 1900)
                    {
                        $this->setFilter($mod_id, 211, 22);
                    }
                    if ($mod_size == 1800 && $mod_size_l == 2000)
                    {
                        $this->setFilter($mod_id, 211, 23);
                    }
                    if ($mod_size == 1900 && $mod_size_l == 1900)
                    {
                        $this->setFilter($mod_id, 211, 24);
                    }
                    if ($mod_size == 1900 && $mod_size_l == 2000)
                    {
                        $this->setFilter($mod_id, 211, 25);
                    }
                    if ($mod_size == 2000 && $mod_size_l == 2000)
                    {
                        $this->setFilter($mod_id, 211, 26);
                    }
                    if ($mod_size == 2000 && $mod_size_l == 2200)
                    {
                        $this->setFilter($mod_id, 211, 27);
                    }
					
                }

            }

            //break;
        }
		mysqli_close($db_connect);
    }
	*/
	/*
	$db_connect=mysqli_connect(host,user,pass,db);
	$query="select goodshaslang_id, goodshaslang_content from goodshaslang where lang_id=1 and (goodshaslang_id>14080 AND goodshaslang_id< 318010)";
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
	//unset ($res);
	if (is_array($goods))
	{
		//var_dump($goods);
		$i=1;
		foreach ($goods as $good)
		{
			$id=$good['goodshaslang_id'];
			$cont=$good['goodshaslang_content'];
			if (strrpos ($cont,'%D0%93%D0%B0%D1%80%D0%B0%D0%BD%D1%82-%D0%BF%D0%B5%D1%81%D0%BA%D0%BE%D1%81%D1%82%D1%80%D1%83%D0%B9')!=false)
			//if (strrpos ($cont,'garant-peskostruj')!=false)
			{
				//echo "<pre>";
				$cont=str_replace('%D0%93%D0%B0%D1%80%D0%B0%D0%BD%D1%82-%D0%BF%D0%B5%D1%81%D0%BA%D0%BE%D1%81%D1%82%D1%80%D1%83%D0%B9','garant-peskostruj',$cont);
				//print_r($good);
				//echo "$cont<br>";
				//echo "</pre>";
				$query="UPDATE goodshaslang SET goodshaslang_content='$cont' WHERE goodshaslang_id=$id";
				mysqli_query($db_connect,$query);
				
				echo "$i<br>";
				$i++;
				//break;
			}
		}
	}
	else
	{
		echo "No array!";
	}
	*/
	
	
	
	/*
	$db_connect=mysqli_connect(host,user,pass,db);
	$query="select sectionhaslang_id, sectionhaslang_content from sectionhaslang where lang_id=1";
	if ($res=mysqli_query($db_connect,$query))
	{
            while ($row = mysqli_fetch_assoc($res))
            {
                $sections[] = $row;
            }
    }
	if (is_array ($sections))
	{
		foreach ($sections as $section)
		{
			$id=$section['sectionhaslang_id'];
			$cont=$section['sectionhaslang_content'];
			$new_cont=preg_replace('~<p[^>]*>~', '<p>', $cont);
			echo $new_cont."<br>";
			//$query="UPDATE sectionhaslang SET sectionhaslang_content='$new_cont' WHERE sectionhaslang_id=$id";
			//mysqli_query($db_connect,$query);
			//break;
		}
	}
	else
	{
		echo "No array!<br>";
	}
	*/
	/*
	set_time_limit(9000);
	function translateText($txt)
    {
        //я
		$api_key="trnsl.1.1.20170706T112229Z.752766fa973319f4.6dcbe2932c5e110da20ee3ce61c5986e7e492e7f";
		//алена
        //$api_key="trnsl.1.1.20180827T115930Z.dabf581f6854b5e7.14a06f36c6a994bdfa2be1f303fd9fb71f2b3c9f";
        $lang="ru-uk";
        $txt=str_replace(" ","%20",$txt);
        $link="https://translate.yandex.net/api/v1.5/tr.json/translate?key=".$api_key."&text=".$txt."&lang=".$lang;
        //echo $link."<br>";
        $result=file_get_contents($link);
        $result=json_decode($result,true);
        $ukr_txt=$result['text'][0];
        //var_dump($result);
        return $ukr_txt;
    }
	
	$db_connect=mysqli_connect(host,user,pass,db);
	$query="select goods_id, goodshaslang_name from goodshaslang where lang_id=1 AND goodshaslang_active=1 AND goods_id>35042";
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
		foreach ($goods as $good)
		{
			$name=$good['goodshaslang_name'];
			$id=$good['goods_id'];
			$name_ukr=translateText($name);
			$f_string="$id;$name_ukr;".PHP_EOL;
			file_put_contents("names_ukr.csv",$f_string,FILE_APPEND);
		}
	}
	else
	{
		echo "no array!<br>";
	}
	*/
	/*
	function getGoods($cat_id)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="select goods_id from goodshascategory WHERE category_id=$cat_id";
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

	$goods=getGoods(130);
	if (is_array($goods))
	{
		foreach ($goods as $good)
		{
			$id=$good['goods_id'];
			
		}
	}
	else
	{
		echo "No goods!";
	}
	*/
	
	function getGoodsByFactory()
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="select goods_id from goodshasfeature WHERE feature_id=232 AND goodshasfeature_valueid=181";
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
	
	function get1C($id)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="select goods_article_1c from goods WHERE goods_id=$id";
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
		//var_dump ($goods);
		return $goods[0]['goods_article_1c'];
	}
	
	function write1C($id,$code)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="update goods SET goods_article_1c='$code' where goods_id=$id";
		mysqli_query($db_connect,$query);
		echo "$query<br>";
		mysqli_close($db_connect);
	}
	
	
	$goods=getGoodsByFactory();
	//var_dump ($goods);
	foreach ($goods as $good)
	{
		$id=$good['goods_id'];
		$code=get1C($id);
		$new_code=$code.";1";
		echo "$id $code $new_code<br>";
		write1C($id,$new_code);
		//break;
	}
 	
	
	
?>

