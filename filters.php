<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 23.02.17
 * Time: 15:19
 */
define ("host","localhost");
//define ("host","10.0.0.2");
/**
 * database username
 */
define ("user", "root");
//define ("user", "uh333660_mebli");
/**
 * database password
 */
define ("pass", "");
//define ("pass", "Z7A8JqUh");
/**
 * database name
 */
define ("db", "mebli");
//define ("db", "uh333660_mebli");
class Filter
{
    public function test()
    {
        /*$tables=$this->getTables();
        echo "<pre>";
        print_r($tables);
        echo "<pre>";*/
        $this->getRTables();
    }
    private function getTables()
    {
        $db_connect=$this->getConnection();
        $query="show tables";
        if ($res=mysqli_query($db_connect,$query))
        {
            unset($tables);
            while ($row = mysqli_fetch_assoc($res))
            {
                $tables[] = $row;
            }
        }
        $this->breakConnection($db_connect);
		return $tables;
    }
    private function getRTables()
    {
        $tables=$this->getTables();
        unset ($rTables);
		foreach ($tables as $table)
        {
            $table_name=$table['Tables_in_mebli'];
			//echo "$table_name";
			if (mb_substr($table_name,0,1)=='r')
            {
                $rTables[]=$table_name;
				//echo $table_name."<br>";
            }
        }
		return $rTables;
    }
    private function getConnection()
    {
        return $db_connect=mysqli_connect(host,user,pass,db);
    }
    private function breakConnection($db_connect)
    {
        mysqli_close($db_connect);
    }
}
$test=new Filter();
$test->test();
