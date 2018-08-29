<?php

header('Content-type: text/html; charset=UTF-8');

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


define ("host_ddn","es835db.mirohost.net");
define ("user_ddn", "u_fayni");
define ("pass_ddn", "ZID1c0eud3Dc");
define ("db_ddn", "ddnPZS");

//define ("host_ddn","localhost");
//define ("user_ddn", "root");
//define ("pass_ddn", "");
//define ("db_ddn", "ddn");

class EmailFM
{
	
	private function getOrdersByUser($user_id)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="SELECT booking_id FROM booking WHERE member_id=$user_id";
		if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $bookings[] = $row;
            }
        }
        else
        {
            echo "Error in SQL getUsers ".mysqli_error($db_connect)."<br>";
        }
		mysqli_close($db_connect);
		return $bookings;
	}
	
	private function getProductNameByBooking($booking_id)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="SELECT basket_prodname FROM basket WHERE booking_id=$booking_id";
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
            echo "Error in SQL getUsers ".mysqli_error($db_connect)."<br>";
        }
		mysqli_close($db_connect);
		return $goods;
	}
	
	private function getUsers()
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="SELECT member_id, member_email, member_name, member_tel FROM member";
		//echo "$query<br>";
		if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $users[] = $row;
            }
        }
        else
        {
            echo "Error in SQL getUsers ".mysqli_error($db_connect)."<br>";
        }
		mysqli_close($db_connect);
		if (is_array($users))
		{
			return $users;
		}
		else
		{
			return null;
		}
	}
	
	public function getEmails()
	{
		$members=$this->getUsers();
		//var_dump($members);
		if (is_array($members))
		 {
			 foreach($members as $member)
			 {
				 $member_id=$member['member_id'];
				 $email=$member['member_email'];
				 $name=$member['member_name'];
				 $tel=$member['member_tel'];
				 $f_string="$email;$name;$tel;";
				 $orders=$this->getOrdersByUser($member_id);
				 //var_dump ($orders);
				 if (is_array ($orders))
				 {
					 foreach($orders as $order)
					 {
						 $order_id=$order['booking_id'];
						 $goods=$this->getProductNameByBooking($order_id);
						 //echo "member=$member_id (mail=$email, ) order=$order_id goods are:<br>";
						 //echo "<pre>";
						 //print_r($goods);
						 //echo "</pre>";
						 if (is_array($goods))
						 {
							 foreach ($goods as $good)
							 {
								 $good_name=$good['basket_prodname'];
								 $f_string.="$good_name, ";
								 //echo "$good_name<br>";
								 //echo 
							 }
						 }
						 
					 }
				 }
				 $f_string.=";".PHP_EOL;
				 echo "$f_string<br>";
				 file_put_contents("emails_fm.csv",$f_string,FILE_APPEND);
				 
				 //break;*/
			 }
			 
		 }
		 else
		 {
			 echo"No array of members!<br>";
		 }
	}
}


class EmailDDN
{
	private function getUsers()
	{
		$db_connect=mysqli_connect(host_ddn,user_ddn,pass_ddn,db_ddn);
		$query="SELECT member_id, member_email, member_name, member_tel FROM member";
		if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $users[] = $row;
            }
        }
        else
        {
            echo "Error in SQL getUsers ".mysqli_error($db_connect)."<br>";
        }
		mysqli_close($db_connect);
		if (is_array($users))
		{
			return $users;
		}
		else
		{
			return null;
		}
	}
	
	private function getGoodsNameById($goods_id)
	{
		$db_connect=mysqli_connect(host_ddn,user_ddn,pass_ddn,db_ddn);
		$query="SELECT goodshaslang_name FROM goodshaslang WHERE goods_id=$goods_id AND lang_id=1";
		if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $goods_name[] = $row;
            }
        }
        else
        {
            echo "Error in SQL getUsers ".mysqli_error($db_connect)."<br>";
        }
		mysqli_close($db_connect);
		$name=$goods_name[0]['goodshaslang_name'];
		return $name;
	}
	
	private function getGoodsFromBookings($booking)
	{
		$db_connect=mysqli_connect(host_ddn,user_ddn,pass_ddn,db_ddn);
		//$book_id=$booking['booking_id'];
		$query="SELECT goodshastissue_id FROM basket WHERE booking_id=$booking";
		//echo "$query<br>";
		
		if ($res=mysqli_query($db_connect,$query))
		{
			while ($row = mysqli_fetch_assoc($res))
			{
				$t_issues[] = $row;
			}
			//$t_issue=$t_issue['goodshastissue_id'];
			//var_dump ($t_issues);
			if (is_array ($t_issues))
			{
				foreach ($t_issues as $t_issue)
				{
					$tissue_id=$t_issue['goodshastissue_id'];
					$query="SELECT goods_id FROM goodshastissue WHERE goodshastissue_id=$tissue_id";
					if ($res=mysqli_query($db_connect,$query))
						if ($res=mysqli_query($db_connect,$query))
						{
							while ($row = mysqli_fetch_assoc($res))
							{
								$goods_id[] = $row;
							}
							//$good_id=$goods_id['goods_id'];
							//var_dump($goods_id);
							//echo "$user_id-$book_id-$good_id<br>";
						}
						else
						{
							echo "Error in SQL getUsers ".mysqli_error($db_connect)."<br>";
						}
				}
				
			}
			/*$query="SELECT goods_id FROM goodshastissue WHERE goodshastissue_id=$t_issue";
			if ($res=mysqli_query($db_connect,$query))
			{
				while ($row = mysqli_fetch_assoc($res))
				{
					$goods_id = $row;
				}
				$good_id=$goods_id['goods_id'];
				echo "$user_id-$book_id-$good_id<br>";
			}
			else
			{
				echo "Error in SQL getUsers ".mysqli_error($db_connect)."<br>";
			}
			*/		
					
		}
		else
		{
			echo "Error in SQL getUsers ".mysqli_error($db_connect)."<br>";
		}
		mysqli_close($db_connect);
		return $goods_id;
	}
	
	private function getOrdersByUser($user_id)
	{
		$db_connect=mysqli_connect(host_ddn,user_ddn,pass_ddn,db_ddn);
		$query="SELECT booking_id FROM booking WHERE member_id=$user_id";
		if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $bookings[] = $row;
            }
        }
        else
        {
            echo "Error in SQL getUsers ".mysqli_error($db_connect)."<br>";
        }
		mysqli_close($db_connect);
		return $bookings;
	}
	 public function getEmails()
	 {
		 $members=$this->getUsers();
		 //var_dump($members);
		 if (is_array($members))
		 {
			 foreach($members as $member)
			 {
				 $member_id=$member['member_id'];
				 $email=$member['member_email'];
				 $name=$member['member_name'];
				 $tel=$member['member_tel'];
				 $f_string="$email;$name;$tel;";
				 //echo "$member_id<br>";
				 $orders=$this->getOrdersByUser($member_id);
				 //var_dump ($orders);
				 if (is_array ($orders))
				 {
					 foreach($orders as $order)
					 {
						 $order_id=$order['booking_id'];
						 $goods=$this->getGoodsFromBookings($order_id);
						 //echo "member=$member_id (mail=$email, ) order=$order_id goods are:<br>";
						 //echo "<pre>";
						 //print_r($goods);
						 //echo "</pre>";
						 if (is_array($goods))
						 {
							 foreach ($goods as $good)
							 {
								 $good_id=$good['goods_id'];
								 $good_name=$this->getGoodsNameById($good_id);
								 $f_string.="$good_name, ";
								 //echo "$good_name<br>";
								 //echo 
							 }
						 }
						 
					 }
				 }
				 $f_string.=";".PHP_EOL;
				 echo "$f_string<br>";
				 file_put_contents("emails_ddn.csv",$f_string,FILE_APPEND);
				 
				 //break;
			 }
			 
		 }
		 else
		 {
			 echo"No array of members!<br>";
		 }
	 }	
}

//$test=new EmailDDN();
$test = new EmailFM();
$test->getEmails();
