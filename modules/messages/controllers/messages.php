<?php
/*
 * 
 */
	// controller
	
	class MessagesControllersMessages
	{
		var $module;
		var $view;
		function __construct()
		{
			
			$this->module  = 'messages';
			$this->view  = 'messages';
			include 'modules/'.$this->module.'/models/'.$this->view.'.php';
		}
		function display(){
			// call models
			$this->inbox();
		}
		
		function inbox()
		{
			$fssecurity  = FSFactory::getClass('fssecurity');
            $fssecurity -> checkLogin();
			$model = new MessagesModelsMessages();
			
			$email =  $model -> getEmailFromUserid();
			$data  = $model -> getMessages($email);
			$total = $model -> getTotal($email);
			
			$pagination = $model->getPagination($total);
			include 'modules/'.$this->module.'/views/'.$this->view.'/inbox.php';
		}
		function outbox()
		{
			$fssecurity  = FSFactory::getClass('fssecurity');
            $fssecurity -> checkLogin();
			$model = new MessagesModelsMessages();
			$total = $model -> getTotal();
			$data  = $model -> getMessages();

			$str_sims = "";
			$arr_sims = array();
			
			$pagination = $model->getPagination();
			include 'modules/'.$this->module.'/views/'.$this->view.'/outbox.php';
		}
		
		function delete()
		{
			$fssecurity  = FSFactory::getClass('fssecurity');
            $fssecurity -> checkLogin();
			$model = new MessagesModelsMessages();
			$Itemid = FSInput::get('Itemid');
			$last_task = FSInput::get('last_task','');
//			if($last_task)
//			{
//				$url_redirect = "index.php?module=messages&task=$last_task&Itemid=$Itemid";
//			}
//			else
//			{
//				$url_redirect = "index.php?module=messages&Itemid=$Itemid";
//			}
//			$sort = FSInput::get('sort');
//			if($sort)
//				$url_redirect .= "&sort=$sort";
//			$sortby = FSInput::get('sortby');
//			if($sortby)
//				$url_redirect .= "&sortby=$sortby";
			$url_redirect='index.php?module=users&task=user_info&Itemid=40';	
			$rows = $model->delete();
			$url_redirect = FSRoute :: _($url_redirect);
			if($rows)
			{
				setRedirect($url_redirect,  FSText::_('Bạn đã xóa thành công '.$rows.' e-mail'));	
			}
			else
			{
				setRedirect($url_redirect,FSText::_('Không có email nào được xóa'),'error');	
			}
		}
		
		
		
		
		function listUserInMessages()
		{
			
		}
		
		function view_fast()
		{
			$fssecurity  = FSFactory::getClass('fssecurity');
            $fssecurity -> checkLogin();
			$model = new MessagesModelsMessages();
			
			$data  = $model -> getMessagesById();
			
			// mark read
			$id = FSInput::get('id');
			$mark_read  = $model -> mark_read($id);
			
			include 'modules/'.$this->module.'/views/'.$this->view.'/view_fast.php';
		}
		function detail()
		{
			$fssecurity  = FSFactory::getClass('fssecurity');
            $fssecurity -> checkLogin();
			$model = new MessagesModelsMessages();
			
			$data  = $model -> getMessagesById();
			$replies  = $model -> getRepliesByMsgid();
			
			// list member
			$str_sims = "";
			$arr_sims = array();
			
			// choise sim_number
			
			if( $data -> sender_id  )
			{
				$arr_sims[] = $data -> sender_id;
			}
			if( $data -> recipients_id  )
			{
				$arr_sims[] = $data -> recipients_id;
			} 	
			if(count($replies))
			{
				foreach ($replies as $item)
				{
					if( $item -> sender_id   )
					{
						$arr_sims[] = $item -> sender_id;
					}
					if( $item -> recipients_id  )
					{
						$arr_sims[] = $item -> recipients_id;
					} 	
				}
			}
			$arr_sims = array_unique($arr_sims);
			$str_sims = implode(",",$arr_sims);
			$str_sims = str_replace("'","",$str_sims);
			if($str_sims)
				$members = 	$model -> getListMember( $str_sims);
			
			$arr_email = array();
			if(isset($members))
			{
				foreach ($members as $item)
				{
					$arr_email[$item -> sim_number] = $item -> email; 
					$arr_fullname[$item -> sim_number] = $item -> fname." ".@$item -> mname." ".$item -> lname; 
				}	
			}
			$arr_fullname[$_SESSION['sim_number']] = "t&#244;i";
			
			// mark read
			$id = FSInput::get('id');
			$mark_read  = $model -> mark_read($id);
			
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}
//		******************************************************
		/************* COMPOSE *******************/
		function compose()
		{
			$fssecurity  = FSFactory::getClass('fssecurity');
            $fssecurity -> checkLogin();
			include 'modules/'.$this->module.'/views/'.$this->view.'/compose.php';
		}
		
		/*
		 * Save compose-message
		 */
		function save_compose()
		{
			$fssecurity  = FSFactory::getClass('fssecurity');
            $fssecurity -> checkLogin();
			$Itemid = FSInput::get('Itemid');
			if(!$this -> check_captcha() )
			{
				$msg = "B&#7841;n c&#7847;n nh&#7853;p m&#227; hi&#7875;n th&#7883;";
				$link = FSRoute :: _("index.php?module=messages&task=compose&Itemid=$Itemid");
				setRedirect($link,$msg);
			}
			$model = new MessagesModelsMessages();
			if(!$model -> save_compose() )
			{
				$msg = "B&#7841;n kh&#244;ng g&#7917;i &#273;&#432;&#7907;c tin nh&#7855;n";
				$link = FSRoute :: _("index.php?module=messages&task=compose&Itemid=$Itemid");
				setRedirect($link,$msg);
			}
			else
			{
				$msg = "B&#7841;n &#273;&#227; g&#7917;i th&#224;nh c&#244;ng tin nh&#7855;n";
				$link = FSRoute :: _("index.php?module=messages&task=inbox&Itemid=$Itemid");
				setRedirect($link,$msg);
			}
		}
		
			/*
		 * Save forward-message
		 */
		function save_forward()
		{
			$fssecurity  = FSFactory::getClass('fssecurity');
            $fssecurity -> checkLogin();
			$Itemid = FSInput::get('Itemid');
			$id = FSInput::get('message_id');
			$model = new MessagesModelsMessages();
			if(!$model -> save_compose() )
			{
				$msg = "B&#7841;n kh&#244;ng g&#7917;i &#273;&#432;&#7907;c tin nh&#7855;n";
				$link = FSRoute :: _("index.php?module=messages&task=detail&id=$id&Itemid=$Itemid");
				setRedirect($link,$msg);
			}
			else
			{
				$msg = "B&#7841;n &#273;&#227; g&#7917;i th&#224;nh c&#244;ng tin nh&#7855;n";
				$link = FSRoute :: _("index.php?module=messages&task=detail&id=$id&Itemid=$Itemid");
				setRedirect($link,$msg);
			}
		}
		
		/*
		 * function check Captcha
		 */
		function check_captcha()
		{
			$keystring = trim(FSInput::get("keystring"));
			if(!isset($keystring))
			{	
				return 0;
			}
			if($keystring != $_SESSION['captcha_keystring'])
			{
				return 0;
			}
			return 1;
		}
		
		function reply()
		{
			$fssecurity  = FSFactory::getClass('fssecurity');
            $fssecurity -> checkLogin();
			include 'modules/'.$this->module.'/views/'.$this->view.'/reply.php';
		}
		function forward()
		{
			$fssecurity  = FSFactory::getClass('fssecurity');
            $fssecurity -> checkLogin();
			$model = new MessagesModelsMessages();
			$data  = $model -> getMessagesById();
			include 'modules/'.$this->module.'/views/'.$this->view.'/forward.php';
		}
		
		function save_reply()
		{
			$fssecurity  = FSFactory::getClass('fssecurity');
            $fssecurity -> checkLogin();
			$Itemid = FSInput::get('Itemid');
			$model = new MessagesModelsMessages();
			$id  = FSInput::get('message_id');
			if(!$model -> save_reply() )
			{
				$msg = "B&#7841;n ch&#432;a g&#7917;i &#273;&#432;&#7907;c tin nh&#7855;n";
				$link = FSRoute :: _("index.php?module=messages&task=detail&id=$id&Itemid=$Itemid");
				setRedirect($link,$msg);
			}
			else
			{
				$msg = "B&#7841;n &#273;&#227; g&#7917;i th&#224;nh c&#244;ng tin nh&#7855;n";
				$link = FSRoute :: _("index.php?module=messages&task=detail&id=$id&Itemid=$Itemid");
				setRedirect($link,$msg);
			}
		}
	}
	
?>