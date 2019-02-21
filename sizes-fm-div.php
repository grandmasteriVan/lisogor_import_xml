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

class fixSizes
{
    /**
     * выбираем товары, принадлижащие одной категории
     * @param $cat_id int айди категории
     * @return array масссив ид товаров
     */
    private function getGoodsByCategory($cat_id)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="select goods_id from goodshascategory WHERE category_id=$cat_id";
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

    /**
     * получаем размеры товаров
     * @param $id int ид товара
     * @return array|null массив с размерами товара
     */
    private function getSizes($id)
    {
       
			$db_connect=mysqli_connect(host,user,pass,db);
			$query="select goods_length, goods_width, goods_height, goods_depth from goods WHERE goods_id=$id";
			if ($res=mysqli_query($db_connect,$query))
			{
					while ($row = mysqli_fetch_assoc($res))
					{
						$sizes[] = $row;
					}
			}
			else
			{
				echo "Error in SQL: $query<br>";		
			}
			mysqli_close($db_connect);
			if (is_array($sizes))
			{
				return $sizes;
			}
			else
			{
				return null;
			}
		}

		private function updateLen($id,$len)
		{
			$db_connect=mysqli_connect(host,user,pass,db);
      $query="UPDATE goods SET goods_length=$len WHERE goods_id=$id";
      echo "$query<br>";
      //$file_string="$query".PHP_EOL;
      //file_put_contents("ukr_kichen.txt",$file_string,FILE_APPEND);
      mysqli_query($db_connect,$query);
      mysqli_close($db_connect);
		}

		private function updateWidth($id,$width)
		{
			$db_connect=mysqli_connect(host,user,pass,db);
      $query="UPDATE goods SET goods_width=$width WHERE goods_id=$id";
      echo "$query<br>";
      //$file_string="$query".PHP_EOL;
      //file_put_contents("ukr_kichen.txt",$file_string,FILE_APPEND);
      mysqli_query($db_connect,$query);
      mysqli_close($db_connect);
		}

		private function updateDep($id,$dep)
		{
			$db_connect=mysqli_connect(host,user,pass,db);
      $query="UPDATE goods SET goods_depth=$dep WHERE goods_id=$id";
      echo "$query<br>";
      //$file_string="$query".PHP_EOL;
      //file_put_contents("ukr_kichen.txt",$file_string,FILE_APPEND);
      mysqli_query($db_connect,$query);
      mysqli_close($db_connect);
		}

		public function fix($cat_id)
		{
			$goods=$this->getGoodsByCategory($cat_id);
			if (is_array($goods))
			{
				foreach ($goods as $good)
				{
					$id=$good['goods_id'];
					$sizes=$this->getSizes($id);
					if (is_array($sizes))
					{
						$depth=$sizes[0]['goods_depth'];
						$len=$sizes[0]['goods_length'];
						if($len==0&&$depth>0)
						{
							echo "$id глубина=$depth длина=$len<br>";
							$this->updateDep($id,0);
							$this->updateLen($id,$depth);
						}
					}
				}
			}
		}

		public function testSizes($cat_id)
		{
			$goods=$this->getGoodsByCategory($cat_id);
			if (is_array($goods))
			{
				foreach ($goods as $good)
				{
					$id=$good['goods_id'];
					$sizes=$this->getSizes($id);
					if (is_array($sizes))
					{
						$len=$sizes[0]['goods_length'];
						$width=$sizes[0]['goods_width'];
						/*if ($len>$width)
						{
							echo "$id<br>";
							$this->updateLen($id,$width);
							$this->updateWidth($id,$len);
						}*/
						if ($len==0)
						{
							echo "$id<br>";
						}
					}
				}
			}
		}

}

$test=new fixSizes();
//$test->fix(1);
$test->testSizes(1);