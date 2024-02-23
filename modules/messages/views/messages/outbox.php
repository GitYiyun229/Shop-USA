<?php 
global $tmpl;
$tmpl -> addScript('form');
$tmpl -> addScript('thickbox','libraries/jquery/thickbox');
$tmpl -> addStylesheet('thickbox','libraries/jquery/thickbox');
$Itemid = CInput::get('Itemid');
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
				<span>So&#7841;n tin m&#7899;i <img alt="a" src="<?php echo  URL_ROOT.'images/arrow-r.gif'; ?>" /> </span>
			</a>
			<a class="button4" href="<?php echo Route::_('index.php?module=messages&task=inbox&Itemid='.$Itemid); ?>" >
				<span> Tin &#273;&#227; nh&#7853;n <img alt="a" src="<?php echo  URL_ROOT.'images/arrow-r.gif'; ?>" /> </span>
			</a>
			<a class="button4" href="javascript:void(0);" >
				<span> Tin &#273;&#227; g&#7917;i <img alt="a" src="<?php echo  URL_ROOT.'images/arrow-b.gif'; ?>" /> </span>
			</a>
			</p>		
		</div>	
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
											<a onclick="javascript: if(checkSubmit('H&#227;y ch&#7885;n &#237;t nh&#7845;t m&#7897;t ng&#432;&#7901;i')){ submitform('delete');}" class='del-icon' >
												<span>X&#243;a</span>
											</a>
											<span class='total'>B&#7841;n c&#243; <span class='red'><?php echo $total; ?></span> th&#432; &#273;&#227; g&#7917;i</span>
										</div>					
									</div>					
								</div>					
							</div>	
							<div class="form_user_footer_body">
									<div id = "msg_error"></div>
									<!-- TABLE 							-->
									<table cellpadding="6" cellspacing="0" border="1" bordercolor="#CECECE">
										<thead>
											<tr>
												<th>STT</th>
												<th><?php echo $fsform -> orderTable("Ng&#432;&#7901;i g&#7917;i",'sender_id'); ?></th>
												<th><?php echo $fsform -> orderTable("Ti&#234;u &#273;&#7873;",'subject'); ?></th>
												<th><?php echo $fsform -> orderTable("Ng&#224;y nh&#7853;n",'created_time'); ?></th>
												<th><?php echo $fsform -> orderTable("K&#237;ch th&#432;&#7899;c",'message_size'); ?></th>
												<th><?php echo 'Xem nhanh'; ?></th>
												<th><?php echo 'X&#243;a'; ?></th>
											</tr>
										</thead>
										<tbody>
											<?php for($i = 0 ; $i < count($data); $i ++ ){?>
											<?php
												 $item = $data[$i];
												 $readed = strstr($item -> readers_id , "'".$_SESSION['sim_number']."'");
												 $readed  = ($readed === false) ? 'unread': '';
												 $link_view = Route::_("index.php?module=messages&task=detail&id=".$item->id."&Itemid=".$Itemid."");
												 $link_view_fast = Route::_("index.php?module=messages&task=view_fast&raw=1&id=".$item->id."&Itemid=".$Itemid."");
											?>
												<tr class='row<?php echo ($i%2) . ' '. $readed; ?>'>
													<td>
														<?php echo ($i+1); ?><br/>
														<input type="checkbox" id="cb<?php echo $i;?>" name="id[]" value="<?php echo $item->id; ?>" onclick="isChecked(this.checked);">
													</td>
													<td> 
														<a href="<?php echo $link_view?>" >
															<?php
															if(!@$arr_fullname[$item -> sender_id])
																echo "Kh&#244;ng bi&#7871;t";
															else 
																echo @$arr_fullname[$item -> sender_id];
															?>
														</a>
													</td>
													<td>
														<a href="<?php echo $link_view?>" ><?php echo $item -> subject;  ?></a>
													</td>
													<td><?php echo date('d-m-Y',strtotime($item -> created_time )); ?></td>
													<td><?php echo $item -> message_size ? $item -> message_size : 0; ?> B</td>
													
													<td><a title="Xem tin nh&#7855;n"  class="thickbox"  href="<?php echo $link_view_fast; ?>">Xem</a></td>
													<?php 
													$link_del = Route::_("index.php?module=messages&task=delete&last_task=outbox&id=".$item->id."&Itemid=$Itemid&")
													?>
													<td><a href="<?php echo $link_del; ?>"><img src="<?php echo URL_ROOT; ?>images/del_button.jpg" alt="del"  /></a></td>
												</tr>
											<?php } ?>
										</tbody>
									</table>	
								<!-- ENd TABLE 							-->
									
								<!-- BUTTON				-->
								<!--<div class="form_button">
								<?php 
								
								$link_edit = Route::_("index.php?module=users&task=edit&Itemid=$Itemid"); 
								$link_upgrade = Route::_("index.php?module=users&task=upgrade&Itemid=$Itemid");
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
									<?php echo $pagination->showPagination();?>
									<?php } ?>
							</div>
							
							<input type="hidden" name="sort" value="<?php echo CInput::get('sort',''); ?>">
							<input type="hidden" name="sortby" value="<?php echo CInput::get('sortby',''); ?>">
							
							<input type="hidden" name="module" value="messages">
							<input type="hidden" name="view" value="messages">
							<input type="hidden" name="task" value="">
							<input type="hidden" name="last_task" value="outbox">
							<input type="hidden" name="boxchecked" value="0">
							<input type="hidden" name="Itemid" value="<?php echo CInput::get('Itemid'); ?>">
						</form>			
					</div>
				</div>
				<div class="form_right">
					<?php $tmpl -> loadModules('right-inner','Round'); ?>
				</div>
				
			</div>	
		</div>	
	</div>
</div>

