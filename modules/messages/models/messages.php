
<?php 
	class MessagesModelsMessages
	{
		var $limit;
		var $page;
		function __construct()
		{
			$limit = 3;
			$page = FSInput::get('page');
			$this->limit = $limit;
			$this->page = $page;
		}
		
		function setQuery($email)
		{
			$task = FSInput::get('task','inbox');
			if($task == 'inbox')
			{
				return $this -> setQueryInbox($email);
			}
			else
			{
				return $this -> setQueryOutbox($email);
			}
		}
		/*
		 * input: $_SESSION['sim_number']
		 * output: email
		 */
		function getEmailFromUserid()
		{
			$userid = $_SESSION['user_id'];
			global $db ;
			$sql = " SELECT email 
					FROM fs_members
					WHERE id = '$userid' ";
			//$db->query($sql);
			return $db->getResult($sql);
		}
		
		/*
		 * set SQL for inbox
		 */
		function setQueryInbox($email)
		{
			if(!$email)
				return;
			$sort = FSInput::get('sort','DESC');
			$sortby= FSInput::get('sortby','id');
			if(!$sortby)
				$sortby = 'id';
			if(!$sort)
				$sort = 'DESC';

			$order = " ORDER BY $sortby $sort";
			
			$sql = " SELECT * 
					FROM fs_messages
					WHERE (`recipients` LIKE \"%,$email,%\" 
							OR `recipients` LIKE \"%,$email\"
							OR `recipients` LIKE \"$email,%\"
							OR `recipients` = \"$email\"
						)
					AND ( deleters NOT LIKE  \"%'$email'%\"  )
					OR deleters is NULL 
					". $order. " ";
			return $sql;
		}
		/*
		 * set SQL for outbox
		 */
		function setQueryOutbox($email)
		{
			if(!$email)
				return;
			$sort = FSInput::get('sort','DESC');
			$sortby= FSInput::get('sortby','id');
			if(!$sortby)
				$sortby = 'id';
			if(!$sort)
				$sort = 'DESC';
		
			$order = " ORDER BY $sortby $sort";
			$sql = " SELECT * 
					FROM fs_messages
					WHERE `sender_id` =  '$email' 
					AND ( deleters_id NOT LIKE  \"%'$email'%\"  
							OR deleters_id is NULL ) 
					". $order. " ";
			return $sql;
		}
		
		/*
		 * input: task
		 */
		function getMessages($email)
		{
			global $db;
			$query = $this->setQuery($email);
			if(!$query)
				return array();
				
			$sql = $db->query_limit($query,$this->limit,$this->page);
			$result = $db->getObjectList();
			return $result;
		}
		function getTotal($email)
		{
			global $db;
			$query = $this->setQuery($email);
			if(!$query)
				return 0;
			$sql = $db->query($query);
			$total = $db->getTotal(); 
			return $total;
		}
		
		function getPagination($total)
		{
			FSFactory::include_class('Pagination');
			$pagination = new Pagination($this->limit,$total,$this->page);
			return $pagination;
		}
		
		/*
		 * input:list 
		 * output: email of sender or recipient
		 */
		function getListMember($str_email)
		{
			if(!$str_email)
				return false;
			global $db ;
			$sql = " SELECT email , fullname
					FROM fs_members
					WHERE email IN ($str_email) ";
			//$db->query($sql);
			return $db->getObjectList($sql);
		}
		
		/*
		 * input: messsage id
		 * output: email of sender or recipient
		 */
		function getSimListFromMsgid($msgid)
		{
			$sql = " SELECT sender_id ,recipients_id
					FROM fs_messages
					WHERE id = $msgid ";
			global $db;
			$db->query($sql);
			$msg =  $db->getObject();
			if(!$msg)
			{
				return;
			}
			$arr_sims = array();
			$arr_sims[] = $msg -> sender_id;
			$recipients = $msg -> recipients_id;
			$recipients = str_replace("'","",$recipients);
			$arr_recipients = explode(",",$recipients) ;
			if(count($arr_recipients))
			{
				foreach ($arr_recipients as $item) {
					$arr_sims[] = $item;
				}
			}
			return $arr_sims;
		}
		
		
		
		/************* DETAIL ************/
		function getMessagesById()
		{
			$id = FSInput::get('id',0);
			$sql = " SELECT * 
					FROM fs_messages
					WHERE id = $id
					 ";
			global $db ;
			$db->query($sql);
			return $db->getObject();
		}
		
		function getRepliesByMsgid()
		{
			$id = FSInput::get('id',0);
			$sql = " SELECT * 
					FROM fs_messages_replies
					WHERE message_id= $id
					 ";
			global $db ;
			$db->query($sql);
			return $db->getObjectList();
			
		}
		function checkExistSim($sim_number)
		{
			global $db;
			$sql = " SELECT sim_number 
					FROM fs_members 
					WHERE sim_number = '$sim_number' ";
			$db->query($sql);
			return $db->getResult();
		}
		/************* ACTION ************/
		function delete()
		{
			$mail = $this -> getEmailFromUserid();
			$cids = FSInput::get('id',array(),'array');
			if(!$mail || !$cids)
				return;
			
			if(count($cids))
			{
				global $db;
				$str_cids = implode(',',$cids);
				$sql = " UPDATE fs_messages
							SET deleters = concat_ws(' ',\",'$mail'\",deleters)
							where id IN ( $str_cids )";
				$db->query($sql);
				$rows = $db->affected_rows();
				return $rows;
			}
			return 0;
		}
		/*
		 * Mark messages is read.
		 */
		function mark_read($id)
		{
			$mail = $this -> getEmailFromUserid();
			if(!$mail)
				return;
			global $db;
			$sql = " UPDATE fs_messages
						SET readers = concat_ws(' ',\",'$mail'\",readers)
						WHERE id = $id 
						AND ( readers is NULL 
							OR readers NOT LIKE  \"%'$mail'%\" )";
			$db->query($sql);
			$rows = $db->affected_rows();
			return $rows;
		}
		/*
		 * compose and save
		 */
		function save_compose()
		{
			global $db;
			$recipients = FSInput::get('recipients');
			$array_recipients  = explode(";",$recipients);
			$array_error = array();
			$array_suc = array();
			
			// check exist sim
			foreach ($array_recipients as $item)
			{
				if($this -> checkExistSim($item))
					$array_suc[] = "\'".$item."\'";
				else
					$array_error[] = $item;
				
			}
			if(count($array_error))
			{
				$str_array = implode(",",$array_error);
				Errors::setError($str_array." kh&#244;ng c&#243; ch&#7911; s&#7903; h&#7919;u",'alert');
			}
			if(!count($array_suc))
			{
				return false;
			}
			if(count($array_suc))
			{
				$array_suc = implode(",",$array_suc);
			}
			
			
			// save
			$recipients = FSInput::get('recipients');
			$subject = FSInput::get('subject');
			$message = htmlspecialchars_decode(FSInput::get('message'));
			$sender_id = $_SESSION['sim_number'];
			$created_time = date('Y-m-d H:i:s');
			$message_size = strlen($message);
			$sql = " INSERT INTO 
						fs_messages (sender_id,recipients_id,subject, message, created_time,message_size)
						VALUES ('$sender_id','$array_suc','$subject','$message','$created_time','$message_size')
					";
			
			$db->query($sql);
			$id = $db->insert();
			return $id;
		}
		
		
		function save_reply()
		{
			global $db;
			$recipients = FSInput::get('recipients');
			$array_recipients  = explode(";",$recipients);
			$message_id = FSInput::get('message_id');
			$sender_id = $_SESSION['sim_number'];
			
			$array_error = array();
			$array_in = array(); // member was entered in this message.
			$array_out = array(); // member is never entered  in this message.
			
			// get List sim_number in message
			$listsim = $this -> getSimListFromMsgid($message_id);
			
			// check exist sim
			foreach ($array_recipients as $item)
			{
				if($this -> checkExistSim($item))
				{
					if($item != $sender_id)
					{
						if(in_array($item,$listsim))
						{
							// in
							$array_in[] = "\'".$item."\'";
						}
						else
						{
							// out
							$array_out[] = "\'".$item."\'";
						}
					}
				}
				else
				{
					$array_error[] = $item;
				}
			}
			echo "1";
//			print_r($listsim);
//			echo "2";
//			print_r($array_in);
//			echo "3";
//			print_r($array_out);
//			
//			die;
			
			if(count($array_error))
			{
				$str_array = implode(",",$array_error);
				Errors::setError($str_array." kh&#244;ng c&#243; ch&#7911; s&#7903; h&#7919;u",'alert');
			}
			if(!count($array_in))
			{
				return false;
			}
			
			
			$recipients = FSInput::get('recipients');
			$message = htmlspecialchars_decode(FSInput::get('message'));
			$created_time = date('Y-m-d H:i:s');
			$message_size = strlen($message);
			
			$subject = $this -> getSubject($message_id);
			// save new message if count(array_out) > 0
			if(count($array_out))
			{
				$str_out = implode(",",$array_out);
				$sql = " INSERT INTO 
						fs_messages (sender_id,recipients_id,subject, message, created_time,message_size)
						VALUES ('$sender_id','$str_out','$subject','$message','$created_time','$message_size')
					";
			
				$db->query($sql);
				$msg_new_id = $db->insert();
				if(!$msg_new_id)
				{
					Errors::setError('Kh&#244;ng th&#7875; t&#7841;o tin m&#7899;i cho nh&#7919;ng ng&#432;&#7901;i kh&#244;ng n&#7857;m trong tin nh&#7855;n n&#224;y');
				}
			}
			
			$str_in = implode(",",$array_in);
			// save reply
			$sql = " INSERT INTO 
						fs_messages_replies (message_id,sender_id, recipients_id, created_time, message, message_size)
						VALUES ('$message_id','$sender_id','$str_in','$created_time','$message','$message_size')
					";
			$db->query($sql);
			$id = $db->insert();
			return $id;
		}
		
		
		
		function getSubject($msgid)
		{
			$sql = " SELECT subject 
					FROM fs_messages
					WHERE id = $msgid ";
			global $db ;
			$db->query($sql);
			return $db->getResult();
		}
		
	}
	
?>