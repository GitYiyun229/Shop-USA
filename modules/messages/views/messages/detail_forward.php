<?php 
global $tmpl;
$tmpl -> addScript('form');
$Itemid = CInput::get('Itemid',0);
$link_back = Route::_("index.php?module=messages&Itemid=$Itemid");
?>
<script type="text/javascript">
	tinyMCE.init({
		// General options
		mode : "exact",
		elements : "message_f",
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
						<!-- FORM							-->
							<?php $url = $_SERVER["REQUEST_URI"]; ?>
						<form action="<?php echo $url; ?>" name="fontForm" method="post" onsubmit="javascript: return checkSubmitForwardForm();">
							<div class="form_user_head">
								<div class="form_user_head_l">
									<div class="form_user_head_r">
										<div class="form_user_head_c">
											<span><strong>Chuy&#7875;n ti&#7871;p</strong> </span>
										</div>					
									</div>					
								</div>					
							</div>	
							<div class="form_user_body">
								
								<div class="form_user_body_inner">
									<div id = "msg_error_f"></div>
									<!--		FORM MAIN - MESSAGE						-->
									<table width="100%" cellpadding="5" >
										<tr>
											<td></td>
											<td>
												<span class='red'>M&#7895;i member c&#225;ch nhau b&#7903;i d&#7845;u ";". V&#237; d&#7909;: 917453234;917736483
												</span>
											</td>
										</tr>
										
										<tr>
											<td> <span class='red'>*</span>Danh s&#225;ch ng&#432;&#7901;i nh&#7853;n</td>
											<td>
												<input type="text" name='recipients' id='recipients_f'/>
											</td>
										</tr>
										<tr>
											<td> <span class='red'>*</span>Ti&#234;u &#273;&#7873;</td>
											<td>
												<input type="text" name='subject' id='subject_f' value='<?php echo "Fwd: ".$data->subject; ?>'/>
											</td>
										</tr>
										<tr>
											<td> <span class='red'>*</span>N&#7897;i dung</td>
											<td>
												<textarea rows="8" cols="30" name='message' id='message_f'><?php echo strip_tags($data -> message); ?></textarea>
											</td>
										</tr>
										<tr>
											<td ></td>
											<td >
												<input type="submit" value="&#272;&#7891;ng &#253;" name = 'submit_bt' class='button5' />
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
							<input type="hidden" name="message_id" value="<?php echo CInput::get('id'); ?>">
							<input type="hidden" name="task" value="save_forward">
							<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>">
						</form>			
<script type="text/javascript" >
function checkSubmitForwardForm()
{
	$('#msg_error_f').html('');
	count_error =0;
	if($('#recipients_f').val().length == 0 )
	{
		$("#msg_error_f").html($("#msg_error_f").html() + "<li>B&#7841;n h&#227;y &#273;i&#7873;n danh s&#225;ch ng&#432;&#7901;i nh&#7853;n </li>");
		count_error++;
	}

	var numericExpression = /^[0-9; ]+$/;
	if(!$('#recipients_f').val().match(numericExpression) )
	{
		$("#msg_error_f").html($("#msg_error_f").html() + "<li>Danh s&#225;ch kh&#244;ng &#273;&#250;ng &#273;&#7883;nh d&#7841;ng</li>");
		count_error++;
	}
	
	if($('#subject_f').val().length == 0 )
	{
		$("#msg_error_f").html($("#msg_error_f").html() + "<li>Nh&#7853;p ti&#234;u &#273;&#7873; b&#224;i vi&#7871;t </li>");
		count_error++;
	}
	if ( (tinyMCE.get('message_f').getContent()=="") || (tinyMCE.get('message_f').getContent()==null) ) {
	     	$("#msg_error_f").html($("#msg_error_f").html() + "<li>Nh&#7853;p n&#7897;i dung</li>");
	     	count_error++;
	}
	 
	if(count_error)
	{
		return false;
	}
	return true;
}
</script>
