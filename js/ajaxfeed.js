var ajaxData = function() {
	$.getJSON('feed.php', function(data){
		var output = '<ul>';
		$.each(data, function (key, val) {
			output += '<li>' + val + '</li>';
		});
		output+='</ul>';
		$('#update').html(output);
	});
};

setInterval(ajaxData, 1000);
