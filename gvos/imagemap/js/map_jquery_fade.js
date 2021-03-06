// Runs when the DOM has been loaded
$(document).ready(function() {
	// Check if map exists
	if($('#map')) {
		// Loop through each AREA in the imagemap
		$('#map area').each(function() {
	
			// Assigning an action to the mouseover event
			$(this).mouseover(function(e) {
				var link_id = $(this).attr('id').replace('area_', '');
				$('#'+link_id).fadeIn('fast');
				document.getElementById("text").innerHTML=$(this).attr('alt');
			});
			
			// Assigning an action to the mouseout event
			$(this).mouseout(function(e) {
				var link_id = $(this).attr('id').replace('area_', '');
				$('#'+link_id).hide();
				document.getElementById("text").innerHTML="Graf von Oberndorff Schule - Entdecke neue Welten";
			});
			
			// Assigning an action to the click event
			//$(this).click(function(e) {
			//	e.preventDefault();
			//	var link_id = $(this).attr('id').replace('area_', '');
			//	alert('You clicked ' + link_id);
			//});
		
		});
	}
});
