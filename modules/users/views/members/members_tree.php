<?php 
global $tmpl;
$tmpl -> addStylesheet("menu","modules/users/assets/css");
?>


<script type="text/javascript">
<!--//--><![CDATA[//><!--
	$(document).ready(function() {
		$("#start_tree ul").each(function() {$(this).css("display", "none");});
		$("#start_tree .hasChild").click(function() {
			var childid = "#" + $(this).attr("childid");
			if ($(childid).css("display") == "none") {$(childid).css("display", "block");}
			else {$(childid).css("display", "none");}
			if ($(this).hasClass("item-close")) {$(this).removeClass("item-close").addClass("item-open");}
			else{$(this).removeClass("item-open").addClass("item-close");}
		});


		// Huy add
		// fisrst: open level = 1
		$(".root-item").click(function(){

			// open or close next element ( ul tag)
			if ($(this).next().css("display") == "none") {$(this).next().css("display", "block");}
			else {$(this).next().css("display", "none");}

			// change class of children element
			if ($(this).children(":first").hasClass("item-close")) {$(this).children(":first").removeClass("item-close").addClass("item-open");}
			else{$(this).children(":first").removeClass("item-open").addClass("item-close");}
		});
	});


	/*
	 *  View info member
	 */
	function ajax_show_info_member(userid)
	{
		$.ajax({
			  url: "index.php?module=users&view=members&task=get_info_member&raw=1&userid="+userid+"",
			  cache: false,
			  success: function(json){
			    	if(json != '0')
			    	{
			    		document.getElementById('lower_member').innerHTML = json;
			    		return false;
			    	}
			    	else
			    	{
						return false;	
			    	}
			  },
			  error: function()
			  {
				 alert('error');
				 return false;
			  }
			});
	}
//--><!]]>
</script>
<div class="members-tree">
	<ul  class="root_tree">
		<li class="root-item">
	        	<a href='javascript:void(0)' childid = 'chidren_level1' class='item-close  hasChild' >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
	        	<a href='javascript:void(0)'><?php echo FSText::_("B&#7841;n"); ?></a>
        </li>
        <ul id="start_tree">
			<?php 
			foreach ($list as $item) {?>
				
				<?php
				// ADD STATISTICS
				// end ADD STATISTICS
				
					$link = "javascript:ajax_show_info_member('".$item -> id ."')";
				?>
				<li>
		        	<a href='javascript:void(0)' childid = '<?php echo 'c_'.$item->id; ?>' class='item-open <?php echo $item->children > 0? 'hasChild':'noChild' ?>'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
		        	<a href="<?php echo $link; ?>">
		        		<?php echo "[".$item->level."]  ".$item->fname." ".$item->mname." ".$item->name." (".date("d/m/Y", strtotime($item->created_date)).")"; ?>
		        	</a>
		        </li>
			<?php 
				$num_child[$item->id] = $item->children ;
				if($item->children  > 0)
					echo "<ul id='c_".$item->id."' >";
					
				
				if(isset($num_child[$item->parent_id] ) && ($num_child[$item->parent_id] == 1) )
					echo "</ul>";
				if(isset($num_child[$item->parent_id]) && ($num_child[$item->parent_id] >= 1) )
					$num_child[$item->parent_id]--;
					  
			}
			?>
    	</ul>	
    </ul>
</div>
