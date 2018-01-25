<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 18.01.2018
 * Time: 09:26
 */
header('Content-Type: text/html; charset=utf-8');
/**
 * database host
 */
//define ("host","localhost");
/**
 *
 */
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
/**
 * Class FontSize
 */
class FontSize
{
    /**
     * @return array|null
     */
    private function getGoods()
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goods_id, goods_content FROM goods WHERE goods_noactual=0 AND goods_active=1 AND goods_content<>''";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row=mysqli_fetch_assoc($res))
            {
                $goods[]=$row;
            }
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
    /**
     * @param $text
     * @return null|string|string[]
     */
    private function replaceSize($text)
    {
        $text=preg_replace("/font-size\:(\s?)(\d+)px;/","font-size:12pt;",$text);
        return $text;
    }
    /**
     * @param $text
     * @return mixed
     */
    private function insertSize($text)
    {
        $text=str_replace("<p>","<p><span style='font-size: 12pt'>",$text);
        $text=str_replace("</p>","</span></p>",$text);
        return $text;
    }
    /**
     * @param $text
     * @return bool
     */
    private function checkType($text)
    {
        if (mb_strpos($text,"font-size")!=false)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    /**
     *
     */
    public function changeSize()
    {
        $allGoods=$this->getGoods();
        if (is_array($allGoods))
        {
            foreach ($allGoods as $good)
            {
                $id=$good['goods_id'];
                $cont=$good['goods_content'];
				//echo "old:".$cont."<br>";
                if ($this->checkType($cont))
                {
                    //echo "old:".$cont."<br>";
					$cont_new=$this->replaceSize($cont);
					//echo "new:".$cont_new;
					//break;
                }
                else
                {
                    $cont_new=$this->insertSize($cont);
					//echo "$id<br>";
                }
				//echo "new:".$cont_new;
				//break;
				$query="UPDATE goods SET goods_content='$cont_new' WHERE goods_id=$id"
				
            }
			
			
        }
		else
		{
			echo "No array to work with";
		}
    }
}

$test=new FontSize();
$test->changeSize();
