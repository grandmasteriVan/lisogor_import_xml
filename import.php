<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 01.02.16
 * Time: 10:18
 */
/**
 * database host
 */
//define ("host","localhost");
define ("host","10.0.0.2");
/**
 * database username
 */
//define ("user", "root");
define ("user", "uh333660_mebli");
/**
 * database password
 */
//define ("pass", "");
define ("pass", "Z7A8JqUh");
/**
 * database name
 */
//define ("db", "mebli");
define ("db", "uh333660_mebli");


$selectedFactory=$_POST["factory"];
switch ($selectedFactory)
{
    case "AMF":
        set_time_limit(200);
        include_once "/factory/amf.php";
        $test = new AMF($_FILES['file']['tmp_name']);
        $test->parse_price_amf();
        $test->test_data();
        $test->add_db_afm();
        break;
    case "Poparada":
        include_once "/factory/poparada.php";
        break;
    case "BRW":
        include_once "/factory/brw-gerbor.php";
        parse_price_brw();
        test_data_arr();
        //print_r($data);
        add_db_brw_gerbor($data);
        break;
    case "Gerbor":
        include_once "/factory/brw-gerbor.php";
        parse_price_gerbor();
        test_data_arr();
        add_db_brw_gerbor($data);
        break;
    case "Lisogor":
        include_once "/factory/lisogor.php";
        parse_price_lisogor();
        test_data_arr();
        add_db_lisogor($data);
        break;
    case "Vika":
        include_once "/factory/vika.php";
        parse_price_vika();
        test_data_arr();
        add_db_vika($data);
        break;
    case "Domini":
        //echo "In progress";
        include_once "/factory/domini.php";
        $test = new Domini($_FILES['file']['tmp_name']);
        $test->parce_price_domini();
        $test->test_data();
        $test->add_db_domini();
        break;
    case "SidiM":
        echo "In progress";
        include_once "/factory/sidim.php";
        break;

    default:
        echo "Выберите фабрику и повторите";
        break;
}


?>