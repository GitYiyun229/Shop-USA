<?php 
global $tmpl;
$tmpl -> addScript('form');
$tmpl -> addScript('tiny_mce','libraries/jquery/tiny_mce');
$Itemid = CInput::get('Itemid',0);
$link_back = Route::_("index.php?module=messages&Itemid=$Itemid");
?>
<script type="text/javascript">
	tinyMCE.init({
		// General options
		mode : "exact",
		elements : "message",
		theme : "advanced",
		plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,inlinepopups,autosave",

		// Theme options
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "link,unlink,image,|,forecolor,backcolor,|,sub,sup,|,charmap,emotions,iespell,sub,sup,|,charmap,emotions,iespell",
		theme_advanced_buttons3 : "",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_resizing : true

	
	});
</script>
<div class="frame_display  messages">
	<div class="frame_head">
		<?php global $tmpl;?>
		<?php $tmpl->loadDirectModule('newest_news');?>
		<?php $task = CInput::get('task','inbox');?>	
	</div>
	<div class="frame_body">
		<div class="form_head">
			<p class="title">
			<a class="button4" href="javascript:void(0);" ><span>So&#7841;n tin m&#7899;i <img alt="a" src="<?php echo  URL_ROOT.'images/arrow-b.gif';?>" /> </span></a>
			<a class="button4" href="<?php echo Route::_('index.php?module=messages&task=inbox&Itemid='.$Itemid); ?>" >
				<span> Tin &#273;&#227; nh&#7853;n <img alt="a" src="<?php echo  URL_ROOT.'images/arrow-r.gif'; ?>" /> </span>
			</a>
			<a class="button4" href="<?php echo Route::_('index.php?module=messages&task=outbox&Itemid='.$Itemid); ?>" >
				<span> Tin &#273;&#227; g&#7917;i <img alt="a" src="<?php echo  URL_ROOT.'images/arrow-r.gif'; ?>" /> </span>
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
											<a class="button4" href="javascript:void(0);" onclick="javascript: sendMail();" ><span> G&#7917;i &#273;i</span></a>
											<a class="button4" href="javascript:window.location = '<?php echo $link_back; ?>';" ><span> H&#7911;y b&#7887;  </span></a>
										</div>					
									</div>					
								</div>					
							</div>	
							<div class="form_user_body">
								
								<div class="form_user_body_inner">
									<div id = "msg_error"></div>
									<!--		FORM MAIN - MESSAGE						-->
									<table width="100%" cellpadding="5" >
										<tr>
											<td></td>
											<td>Nh&#7919;ng &#244; c&#243; d&#7845;u sao (<span class='red'>*</span>) l&#224; b&#7855;t bu&#7897;c ph&#7843;i nh&#7853;p</td>
										</tr>
										<tr>
											<td></td>
											<td>
												<span class='red'>B&#7841;n ch&#7881; &#273;&#432;&#7907;c nh&#7853;p t&#7889;i &#273;a 5 th&#224;nh vi&#234;n. <br/>
													M&#7895;i member c&#225;ch nhau b&#7903;i d&#7845;u ";". V&#237; d&#7909;: 917453234;917736483
												</span>
											</td>
										</tr>
										
										<tr>
											<td> <span class='red'>*</span>Danh s&#225;ch ng&#432;&#7901;i nh&#7853;n</td>
											<td>
												<input type="text" name='recipients' id='recipients'/>
											</td>
										</tr>
										<tr>
											<td> <span class='red'>*</span>Ti&#234;u &#273;&#7873;</td>
											<td>
												<input type="text" name='subject' id='subject'/>
											</td>
										</tr>
										
										<tr>
											<td> <span class='red'>*</span>N&#7897;i dung</td>
											<td>
												<textarea rows="16" cols="70" name='message' id='message' ></textarea>
											</td>
										</tr>
										<tr>
											<td ><span class='red'>*</span><?php echo Text::_("Nh&#7853;p m&atilde; hi&#7875;n th&#7883;"); ?></td>
											<td >
												<input type="text" name="keystring" id="keystring"  />
												<a onclick="reloadCaptcha();" title="&#7844;n v&#224;o &#7843;nh &#273;&#7875; &#273;&#7893;i m&#227; kh&#225;c" ><img id="keystring_img" src="<?php echo URL_ROOT; ?>libraries/kcaptcha/index.php?<?php echo session_name()?>=<?php echo session_id()?>" /></a>
											</td>
										</tr>
										<tr>
											<td ></td>
											<td >
												<a class="button4" href="javascript:void(0);" onclick="javascript: sendMail();" ><span> G&#7917;i &#273;i</span></a>
												<a class="button4" href="javascript:window.location = '<?php echo $link_back; ?>';" ><span> H&#7911;y b&#7887;  </span></a>
												<br/>
												<br/>
											</td>
										</tr>
									</table>
									<!--		end FORM MAIN - MESSAGE						-->
									
								</div>
							</div>
							<input type="hidden" name="module" value="messages">
							<input type="hidden" name="view" value="messages">
							<input type="hidden" name="task" value="save_compose">
							<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>">
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
<script type="text/javascript" >
function reloadCaptcha()
{
	<?php unset($_SESSION['captcha_keystring']);?>
	$("#keystring_img").attr({ 
        src: "<?php echo URL_ROOT; ?>libraries/kcaptcha/index.php?<?php echo session_name();?>=<?php echo session_id();?>&n=" + Math.random() });
}
function sendMail()
{
	count_error = 0;
	$('#msg_error').html('');
	if(!notEmpty("recipients","<?php echo "B&#7841;n h&#227;y &#273;i&#7873;n danh s&#225;ch ng&#432;&#7901;i nh&#7853;n "; ?>"))
	{
		count_error++;
	}
	else
	{	
		if(!isNumericList("recipients","<?php echo "Danh s&#225;ch kh&#244;ng &#273;&#250;ng &#273;&#7883;nh d&#7841;ng"; ?>"))
		{
			count_error++;
		}
	}
	if(!notEmpty("subject","<?php echo "Nh&#7853;p ti&#234;u &#273;&#7873; b&#224;i vi&#7871;t"; ?>"))
	{
		count_error++;
	}
     
     if ( (tinyMCE.get('message').getContent()=="") || (tinyMCE.get('message').getContent()==null) ) {
     	$("#msg_error").html($("#msg_error").html() + "<li>Nh&#7853;p n&#7897;i dung</li>");
     	count_error++;
 	}

	if(!notEmpty("keystring","<?php echo "B&#7841;n h&#227;y nh&#7853;p m&#227; hi&#7875;n th&#7883;"; ?>"))
	{
		count_error++;
	}
	if(!count_error)
	{
		document.fontForm.submit();
	}
}
</script>
