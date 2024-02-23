<?php 
global $tmpl;
//$tmpl -> addScript('form');
?>
<?php // $fsform = FSFactory::getClass('fsform','form'); ?>

<div class="form_user_body">
	
	<div class="form_user_body_inner">
	
		<!--		FORM MAIN - MESSAGE						-->
		<div class='email-head'>
			<table>
				<tr>
					<td width="100">Tiêu đề: </td>
					<td><strong><?php echo $data -> subject; ?></strong></td>
				</tr>
				<tr>
					<td>Người gửi: </td>
					<td><strong><?php echo $data -> sender_name; ?></strong></td>
				</tr>
				<tr>
					<td>Ngày gửi: </td>
					<td><strong><?php echo show_datetime($data -> created_time); ?></strong></td>
				</tr>
			</table>
		</div>
		<hr/>
		<div class='email-body'>
			<div class='email-body-inner'>
				<?php echo $data -> message; ?>
			</div>
		</div>
		<!--		end FORM MAIN - MESSAGE						-->
		
	</div>
</div>
							
