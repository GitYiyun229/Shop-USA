<?php
$Itemid = FSInput::get('Itemid');
?>
<script src="<?php echo URL_ROOT.'libraries/jquery/thickbox/thickbox.js'; ?>" type="text/javascript" language="javascript" ></script>
<link rel="stylesheet" href="<?php  echo URL_ROOT.'libraries/jquery/thickbox/thickbox.css';?>" />
<?php // $fsform = FSFactory::getClass('fsform','form'); ?>
<div class="frame_display  messages">
	<div class="frame_head">
		<?php global $tmpl;?>
		<?php $task = FSInput::get('task','inbox');?>	
	</div>
	<div class="frame_body">
		<div class="form_body">
			<div class="form_body_inner">
				<div class="form_left">
					<div class="form_user">
						<!-- FORM							-->
							<?php $url = $_SERVER["REQUEST_URI"]; ?>
						<form action="<?php echo $url; ?>" name="fontForm" method="post">
							<div class="form_user_head">
								<div class="form_user_head_l">
									<div class="form_user_head_r">
										<div class="form_user_head_c">
											<a onclick="checkAll(<?php echo count($data); ?>,'cb',1);" class='select_all' >
												<span>Ch&#7885;n t&#7845;t c&#7843;</span>
											</a>
											<a onclick="checkAll(<?php echo count($data); ?>,'cb',0);" class='non-select' >
												<span>B&#7887; ch&#7885;n t&#7845;t c&#7843;</span>
											</a>
											<a onclick="javascript: if(checkSubmit('H&#227;y ch&#7885;n &#237;t nh&#7845;t m&#7897;t ng&#432;&#7901;i')){ submitform('delete','Bạn có chắc chắn muốn xóa các bản ghi này?');}" class='del-icon' >
												<span>X&#243;a</span>
											</a>
											</br>
											<div class='total'>B&#7841;n c&#243; <span class='red'><?php echo $total; ?></span> th&#432; &#273;&#7871;n</div>
										</div>					
									</div>					
								</div>					
							</div>	
							<div class="form_user_footer_body">
									<div id = "msg_error"></div>
									<!-- TABLE 							-->
									<table width="100%" cellpadding="6" cellspacing="0" border="1" bordercolor="#CECECE">
										<thead >
											<tr class="head-tr">
												<th class="center-column">STT</th>
												<th> Người gửi</th>
												<th> Tiêu đề</th>
												<th> Ngày gửi</th>
												<th class="center-column"><?php echo 'Xem nhanh'; ?></th>
												<th class="center-column"><?php echo 'X&#243;a'; ?></th>
											</tr>
										</thead>
										<tbody>
											<?php for($i = 0 ; $i < count($data); $i ++ ){
												$item = $data[$i];
											
												 $readed = strstr($item -> readers , "'".$email."'");
												 $readed  = ($readed === false) ? 'unread': '';
												 $link_view = FSRoute :: _("index.php?module=messages&task=detail&id=".$item->id."&Itemid=".$Itemid."");
												 $link_view_fast = FSRoute :: _("index.php?module=messages&task=view_fast&raw=1&id=".$item->id."&Itemid=".$Itemid."");
											?>
												<tr class='row<?php echo ($i%2) . ' '. $readed; ?>'>
													<td class="center-column">
														<?php echo ($i+1); ?><br/>
														<input type="checkbox" id="cb<?php echo $i;?>" name="id[]" value="<?php echo $item->id; ?>" onclick="isChecked(this.checked);">
													</td>
													<td>
														<?php echo $item -> sender_name; ?> 
													</td>
													<td>
														<a class="subject-a"><?php echo $item -> subject;  ?></a>
													</td>
													<td><?php echo date('d-m-Y',strtotime($item -> created_time )); ?></td>
													
													<td class="center-column"><a title="Xem tin nh&#7855;n"  class="thickbox"  href="<?php echo $link_view_fast; ?>">Xem</a></td>
													<?php 
													$link_del = FSRoute :: _("index.php?module=messages&task=delete&last_task=inbox&id=".$item->id."&Itemid=$Itemid&")
													?>
													<td class="remove-fav"><img src="<?php echo  URL_ROOT.'images/remove_fav.png';?>" alt="del"  /><a href="<?php echo $link_del; ?>"> Xóa</a></td>
												</tr>
											<?php } ?>
										</tbody>
									</table>	
								<!-- ENd TABLE 							-->
									
								<!-- BUTTON				-->
								<!--<div class="form_button">
								<?php 
								
								$link_edit = FSRoute :: _("index.php?module=users&task=edit&Itemid=$Itemid"); 
								$link_upgrade = FSRoute :: _("index.php?module=users&task=upgrade&Itemid=$Itemid");
								?>
									<a href="<?php echo $link_edit; ?>" class="button3"><span>Thay &#273;&#7893;i th&#244;ng tin c&#225; nh&#226;n &#187;</span></a>
									<a href="<?php echo $link_upgrade; ?>" class="button3"><span>N&#226;ng c&#7845;p th&#224;nh vi&#234;n &#187;</span></a>
								</div>-->
								<!-- end BUTTON				-->
							</div>
							<div class="form_user_footer">
								<div class="form_user_footer_l">
									<div class="form_user_footer_r">
										<div class="form_user_footer_c">
											<a onclick="checkAll(<?php echo count($data); ?>,'cb',1);" class='select_all' >
												<span>Ch&#7885;n t&#7845;t c&#7843;</span>
											</a>
											<a onclick="checkAll(<?php echo count($data); ?>,'cb',0);" class='non-select' >
												<span>B&#7887; ch&#7885;n t&#7845;t c&#7843;</span>
											</a>
											<a onclick="javascript: if(checkSubmit('H&#227;y ch&#7885;n &#237;t nh&#7845;t m&#7897;t ng&#432;&#7901;i')){ submitform('delete');}" class='del-icon' >
												<span>X&#243;a</span>
											</a>
											
											
										</div>					
									</div>					
								</div>					
							</div>		
							<div class="footer_form">
									<?php if(@$pagination) {?>
									<?php echo $pagination->showPagination_ajax();?>
									<?php } ?>
							</div>
							
							<input type="hidden" name="sort" value="<?php echo FSInput::get('sort',''); ?>">
							<input type="hidden" name="sortby" value="<?php echo FSInput::get('sortby',''); ?>">
							
							<input type="hidden" name="module" value="messages">
							<input type="hidden" name="view" value="messages">
							<input type="hidden" name="task" value="">
							<input type="hidden" name="last_task" value="inbox">
							<input type="hidden" name="boxchecked" value="0">
							<input type="hidden" name="Itemid" value="<?php echo FSInput::get('Itemid'); ?>">
						</form>			
					</div>
				</div>
			</div>	
		</div>	
	</div>
</div>

<script src="<?php echo URL_ROOT.'modules/users/includes/js/trade_history.js'; ?>" type="text/javascript" language="javascript" ></script>