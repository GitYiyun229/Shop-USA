$('.load_more').click(function(){
	var pagecurrent = $(this).attr( "data-pagecurrent" );
	var nextpage = $(this).attr( "data-nextpage" );
	var limit = $(this).attr( "limit" );
	// var start = $(this).attr( "data-start" );
	// var end = $(this).attr( "data-end" );
	var id = $(this).attr( "data-id" );
	var cid = $(this).attr( "data-cat_id" );
	var dclass = $(this).attr( "data-class" );
	// var col = $(this).attr( "data-col" );
	// var col2 = $(this).attr( "data-col2" );

	pagecurrent = Number(pagecurrent);
	nextpage = Number(nextpage);

	$(this).attr("data-pagecurrent",nextpage);
	$(this).attr("data-nextpage",nextpage+1);
	// alert(limit);
	$.ajax({
	    type : 'GET',
	    dataType: 'html',
	    url : '/index.php?module=sales_offline&view=cat&raw=1&task=nextphone',
	    data: 'id='+id+'&pagecurrent='+pagecurrent+'&limit='+limit+'&dclass='+dclass+'&cid='+cid,
	    success : function(html){
	      $('#'+dclass+id).append(html);
	    }
  	});
})


