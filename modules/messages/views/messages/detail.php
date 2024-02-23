<?php 
global $tmpl;
$tmpl -> addScript('form');
$tmpl -> addScript('tiny_mce','libraries/jquery/tiny_mce');
$Itemid = CInput::get('Itemid');
$id = CInput::get('id');
// sim_number of sender
$senderid = str_replace("'","",$data -> sender_id);
?>
<?php $fsform = FSFactory::getClass('fsform','form'); ?>
<div class="frame_display  messages">
	<div class="frame_head">
		<?php global $tmpl;?>
		<?php $tmpl->loadDirectModule('newest_news');?>
		<?php $task = CInput::get('task','inbox');?>	
	</div>
	<div class="frame_body">
		<div class="form_head">
			<p class="title">
			<a class="button4" href="<?php echo Route::_('index.php?module=messages&task=compose&Itemid='.$Itemid); ?>" >
				<span>So&#7841;n tin m&#7899;i <img alt="a" src="<?php echo  URL_ROOT.'images/arrow-r.gif' ?>" /> </span><br />
			</a>
			<?php if($senderid != $_SESSION['sim_number']) {?>
				<a class="button4" href="<?php echo Route::_('index.php?module=messages&task=inbox&Itemid='.$Itemid); ?>" >
					<span> Tin &#273;&#227; nh&#7853;n <img alt="a" src="<?php echo  URL_ROOT.'images/arrow-b.gif'; ?>" /> </span>
				</a>
				<a class="button4" href="<?php echo Route::_('index.php?module=messages&task=outbox&Itemid='.$Itemid); ?>" >
					<span> Tin &#273;&#227; g&#7917;i <img alt="a" src="<?php echo  URL_ROOT.'images/arrow-r.gif'; ?>" /> </span>
				</a>
			<?php } else { ?>
				<a class="button4" href="<?php echo Route::_('index.php?module=messages&task=inbox&Itemid='.$Itemid); ?>" >
					<span> Tin &#273;&#227; nh&#7853;n <img alt="a" src="<?php echo  URL_ROOT.'images/arrow-r.gif'; ?>" /> </span>
				</a>
				<a class="button4" href="<?php echo Route::_('index.php?module=messages&task=outbox&Itemid='.$Itemid); ?>" >
					<span> Tin &#273;&#227; g&#7917;i <img alt="a" src="<?php echo  URL_ROOT.'images/arrow-b.gif'; ?>" /> </span>
				</a>
			<?php }?>
			
			</p>		
		</div>	
		<div class="form_body">
			<div class="form_body_inner">
				<div class="form_left">
				
					<!--	MESSAGE END REPLY				-->
					<div class="form_user">
						<!-- FORM							-->
							<?php $url = $_SERVER["REQUEST_URI"]; ?>
							<div class="form_user_head">
								<div class="form_user_head_l">
									<div class="form_user_head_r">
										<div class="form_user_head_c">
											<?php $link_reply = Route::_("index.php?module=messages&task=reply&id=$id&raw=1&Itemid=$Itemid")?>
											<?php $link_forward = Route::_("index.php?module=messages&task=forward&id=$id&raw=1&Itemid=$Itemid")?>
											<a title="Tr&#7843; l&#7901;i"  class="reply_bt button4"  href="javascript:void(0);"><span> Tr&#7843; l&#7901;i  </span></a>
											<a title="Chuy&#7875;n ti&#7871;p"  class="forward_bt button4"  href="javascript:void(0);"><span>  Chuy&#7875;n ti&#7871;p   </span></a>
										</div>					
									</div>					
								</div>					
							</div>	
							<div class="form_user_body">
								
								<div class="form_user_body_inner">
								
									<!--		FORM MAIN - MESSAGE						-->
									<div class='email-head'>
										<div class='email-head-left'>
											<p class='email-subject'><strong><?php echo $data -> subject; ?></strong></p>
											<p class='email-sender'> Ng&#432;&#7901;i g&#7917;i: 
												<?php
													
													if(!@$arr_fullname[$senderid])
														echo "Kh&#244;ng bi&#7871;t";
													else 
														echo @$arr_fullname[$senderid];
													?>
											</p>
											<p class='email-recipient'> Ng&#432;&#7901;i nh&#7853;n: 
												<?php
													$str_recipients = $data ->recipients_id;
													$str_recipients = str_replace("'","",$str_recipients);
													$arr_recipients  = explode(",",$str_recipients);
													if(count($arr_recipients))
													{
														$i = 0;
														foreach ($arr_recipients as $recipient) {
															if(!@$arr_fullname[$recipient])
																echo "Kh&#244;ng bi&#7871;t";
															else 
																echo @$arr_fullname[$recipient];
															
															if(($i+1) < count($arr_recipients))
															{
																echo ", ";
															}	
															$i ++;
														}
													}
												?>
											</p>
										</div>
										<div class='email-head-right'>
											<p class='created_time'><?php echo show_datetime($data -> created_time); ?></p>
											
										</div>
									</div>
									<div class='email-body'>
										<div class='email-body-inner'>
											<?php echo $data -> message; ?>
										</div>
									</div>
									<!--		end FORM MAIN - MESSAGE						-->
									
									
									<!--		FORM Reply - MESSAGE						-->
									<?php 
									if(count($replies)) { 
										foreach ($replies as $reply) {
									?>
									<div class='email-head'>
										<div class='email-head-left'>
											<p class='email-sender'> Ng&#432;&#7901;i g&#7917;i: 
												<?php
													
													if(!@$arr_fullname[$reply -> sender_id])
														echo "Kh&#244;ng bi&#7871;t";
													else 
														echo @$arr_fullname[$reply -> sender_id];
													?>
											</p>
											<p class='email-recipient'> Ng&#432;&#7901;i nh&#7853;n: 
												<?php
													$str_r_recipients = $reply ->recipients_id;
													$str_r_recipients = str_replace("'","",$str_r_recipients);
													$arr_r_recipients  = explode(",",$str_r_recipients);
													if(count($arr_r_recipients))
													{
														$i = 0;
														foreach ($arr_r_recipients as $recipient) {
															if(!@$arr_fullname[$recipient])
																echo "Kh&#244;ng bi&#7871;t";
															else 
																echo @$arr_fullname[$recipient];
																
															// separate	
															if(($i+1) < count($arr_r_recipients))
															{
																echo ", ";
															}	
															$i ++;	
														}
													}
												?>
											</p>
										</div>
										<div class='email-head-right'>
											<p class='created_time'><?php echo show_datetime($reply -> created_time); ?></p>
											
										</div>
									</div>
									<div class='email-body'>
										<div class='email-body-inner'>
											<?php echo $reply -> message; ?>
										</div>
									</div>
									<?php 
										}
									}?>
									
									
									<!--		end FORM MAIN - MESSAGE						-->
									
								</div>
							</div>
							<div class="form_user_footer">
								<div class="form_user_footer_l">
									<div class="form_user_footer_r">
										<div class="form_user_footer_c">
											<a title="Tr&#7843; l&#7901;i"  class="reply_bt button4"  href="javascript:void(0);"><span> Tr&#7843; l&#7901;i  </span></a>
											<a title="Chuy&#7875;n ti&#7871;p"  class="forward_bt button4"  href="javascript:void(0);"><span>  Chuy&#7875;n ti&#7871;p   </span></a>
										</div>					
									</div>					
								</div>					
							</div>		
					</div>
					<!--	end MESSAGE END REPLY				-->
					
					<!--	REPLY FROM 				-->
					
					<div id="reply">
						<?php 
							array_push($arr_recipients,$senderid);
							array_unique($arr_recipients);
							$arr_members = $arr_recipients;
							$arr_members_without_me  = array();
							
							for($i = 0 ; $i < count($arr_members); $i ++ )
							{
								if($arr_members[$i] != $_SESSION['sim_number'])
								{
									$arr_members_without_me[] = $arr_members[$i] ;
								}
							}
							$str_members_without_me = implode("; ",$arr_members_without_me);
							?>
						<?php include_once 'detail_reply.php'; ?>
					</div>
					<!--	end REPLY FROM 				-->
					
					<!--	FORWARD FROM 				-->
					<div id="forward">
						<?php include_once 'detail_forward.php'; ?>
					</div>
					<!--	end FORWARD FROM 				-->
				</div>
				
			</div>	
		</div>	
	</div>
</div>
<script type="text/javascript" >
	$(document).ready(function() {
		$(".reply_bt").click(function(){
			$('#reply').show();
			$('#reply #recipients').focus();
			$('#forward').hide();
		});
		$(".forward_bt").click(function(){
			$('#reply').hide();
			$('#forward').show();
			$('#forward #recipients_f').focus();
		});
	});
</script>