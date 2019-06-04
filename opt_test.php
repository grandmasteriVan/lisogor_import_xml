<?php
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
define ("user", "optmebli");
/**
 * database password
 */
//define ("pass", "");
define ("pass", "VRYA1Q0R");
/**
 * database name
 */
//define ("db", "opt");
define ("db", "optmebli");

class test1c
{
    public $data;
    /**
     *
     */
    public $filename;
    /**
     * Link constructor.
     * @param $filename
     */
    public function __construct($filename)
    {
        $this->filename = $filename;
    }
    private function ReadFile1()
    {
        $handle=fopen($this->filename,"r");
        while (!feof($handle))
        {
            $str=fgets($handle);
			$str=explode(";",$str);
			//для парсинга Велам, закоментить при обычном файлке!
			//$str[0].=";";
			$arr[]=$str;
            //echo "$str<br>";
        }
        if (!empty($arr))
        {
            $this->data = $arr;
        }
        else
        {
            echo "array is empty in ReadFile";
        }
    }

    private function getGood($code1c)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goods_id from goods WHERE goods_article_1c='$code1c'";
        if ($res=mysqli_query($db_connect,$query))
        {
                while ($row = mysqli_fetch_assoc($res))
                {
                    $good[] = $row;
                }
        }
        else
        {
            echo "Error in SQL: $query<br>";		
        }
        mysqli_close($db_connect);
        return $good;
    }

    public function test()
    {
        $this->ReadFile1();
        //echo "111";
        //var_dump($this->data);
        foreach ($this->data as $pos)
        {
            $code1c=$pos[0];
            $good=$this->getGood($code1c);
            if (!is_array($good))
            {
                echo "$code1c<br>";
            }
        }


    }
}

$test=new test1c('14-05.txt');
$test->test();