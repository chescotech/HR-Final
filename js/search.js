
$(function(){
$(".search_keyword").keyup(function() 
{ 
	var search_keyword_value = $(this).val();
	var dataString = 'search_keyword='+ search_keyword_value;
	if(search_keyword_value!=='')
	{
		$.ajax({
			type: "POST",
			url: "search.php",
			data: dataString,
			cache: false,
			success: function(html)
			{
				$("#result").html(html).show();
			}
		});
	}
	return false;
        
});

$("#result").live("click",function(e){
	/*
       var $clicked = $(e.target);
	var $name = $clicked.find('.search_keyword').html();	
	var decoded = $("<div/>").html($name).text();
	$('#search_keyword_id').val(decoded);
        */
       alert('clicked');
        
});
$(document).live("click", function(e) { 
	var $clicked = $(e.target);
	if (! $clicked.hasClass("search_keyword")){
		$("#result").fadeOut(); 
	}
});
$('#result').click(function(){
	//$("#result").fadeIn();
        alert('clicked');
});
});


