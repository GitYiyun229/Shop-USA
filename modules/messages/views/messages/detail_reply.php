<?php 
global $tmpl;
$tmpl -> addScript('form');
//$tmpl -> addScript('tiny_mce','libraries/jquery/tiny_mce');
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
						<!-- FORM							-->
							<?php $url = $_SERVER["REQUEST_URI"]; ?>
						<form action="<?php echo $url; ?>" name="fontForm" method="post" onsubmit="javascript: return checkSubmitForm();">
							<div class="form_user_head">
								<div class="form_user_head_l">
									<div class="form_user_head_r">
										<div class="form_user_head_c">
											<span><strong>Tr&#7843; l&#7901;i nhanh</strong> </span>
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
											<td>
												<span class='red'>M&#7895;i member c&#225;ch nhau b&#7903;i d&#7845;u ";". V&#237;  917453234;917736483
												</span>
											</td>
										</tr>
										
										<tr>
											<td> <span class='red'>*</span>Danh s&#225;ch ng&#432;&#7901;i nh&#7853;n</td>
											<td>
												<input type="text" name='recipients' id='recipients' value="<?php echo $str_members_without_me; ?>"/>
											</td>
										</tr>
										
										<tr>
											<td> <span class='red'>*</span>N&#7897;i dung</td>
											<td>
												<textarea rows="8" cols="30" name='message' id='message'></textarea>
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
							<input type="hidden" name="task" value="save_reply">
							<input type="hidden" name="message_id" value="<?php echo CInput::get('id'); ?>">
							<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>">
						</form>			
<script type="text/javascript" >
function checkSubmitForm()
{
	$('#msg_error').html('');
	count_error =0;
	if(!notEmpty("recipients","<?php echo "B&#7841;n h&#227;y &#273;i&#7873;n danh s&#225;ch ng&#432;&#7901;i nh&#7853;n "; ?>"))
	{
		count_error ++;
	}
	if(!isNumericList("recipients","<?php echo "Danh s&#225;ch kh&#244;ng &#273;&#250;ng &#273;&#7883;nh d&#7841;ng"; ?>"))
	{
		count_error ++;
	}
	 if ( (tinyMCE.get('message').getContent()=="") || (tinyMCE.get('message').getContent()==null) ) {
	     	$("#msg_error").html($("#msg_error").html() + "<li>Nh&#7853;p n&#7897;i dung</li>");
	     	count_error++;
	 }
	 	
	if(count_error)
	{
		return false;
	}
	return true;
}
</script>
