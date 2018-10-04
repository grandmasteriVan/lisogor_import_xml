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
define ("user", "root");
//define ("user", "newfm");
/**
 * database password
 */
define ("pass", "");
//define ("pass", "N0r7F8g6");
/**
 * database name
 */
define ("db", "fm_new");
//define ("db", "newfm");

Class clean_style
{
	private function cleanParagraph($cont)
	{
		$new_cont = preg_replace('~<p[^>]*>~', '<p>', $cont);
		$new_cont=str_replace('<b>','',$new_cont);
		$new_cont=str_replace('</b>','',$new_cont);
		$new_cont=str_replace('<i>','',$new_cont);
		$new_cont=str_replace('</i>','',$new_cont);
		$new_cont=str_replace('<strong>','',$new_cont);
		$new_cont=str_replace('</strong>','',$new_cont);
		
		//div
		$new_cont = preg_replace('~<div[^>]*>~', '<p>', $new_cont);
		$new_cont=str_replace('</div>','</p>',$new_cont);
		//span
		$new_cont = preg_replace('~<span[^>]*>~', '<p>', $new_cont);
		$new_cont=str_replace('</span>','</p>',$new_cont);
		return $new_cont;
	}
	
	private function writeCont($id,$cont)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="update goodshaslang SET goodshaslang_content='$cont' where lang_id=1 AND goods_id=$id";
		//mysqli_query($db_connect,$query);
		mysqli_close($db_connect);
	}
	
	private function getGoods()
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="select goods_id, goodshaslang_content from goodshaslang where lang_id=1 AND goodshaslang_active=1 AND goodshaslang_content NOT LIKE ''";
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
	
	public function test()
	{
		$goods=$this->getGoods();
		if (is_array($goods))
		{
			$i=0;
			foreach ($goods as $good)
			{
				$id=$good['goods_id'];
				$cont=$good['goodshaslang_content'];
				//var_dump ($good);
				$cont_new=$this->cleanParagraph($cont);
				//echo "$id<br>old cont:<br>$cont<br>new cont<br>$cont_new";
				//break;
				$this->writeCont($id,$cont_new);
				$i++;
				echo "$i:$id<br>";
				
			}
		}
		else
		{
			echo "No array!";
		}
	}
		
}

$test=new clean_style();
$test->test();