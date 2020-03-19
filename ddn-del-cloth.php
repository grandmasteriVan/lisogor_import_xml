<?php
header('Content-Type: text/html; charset=utf-8');

define ("host_ddn","localhost");
define ("user_ddn", "u_ddnPZS");
define ("pass_ddn", "A8mnsoHf");
define ("db_ddn", "ddnPZS");

class DelCloth
{
    public function DelClothForCat($catId)
    {
        $db_connect=mysqli_connect(host_ddn,user_ddn,pass_ddn,db_ddn);
        $query="DELETE FROM clothhastissue WHERE tissue_id=$catId";
        echo "$query<br>";
        mysqli_query($db_connect,$query);
        mysqli_close($db_connect);
    }
}

$test=new DelCloth();
$test->DelClothForCat(121);
$test->DelClothForCat(111);
$test->DelClothForCat(112);
$test->DelClothForCat(113);
$test->DelClothForCat(114);
$test->DelClothForCat(115);
$test->DelClothForCat(116);
$test->DelClothForCat(117);
$test->DelClothForCat(118);
$test->DelClothForCat(119);
$test->DelClothForCat(120);