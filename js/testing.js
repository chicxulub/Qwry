function intro(){
	
	var intros = $(".test-intro");
	intros.each(function(index){
		$(this).delay(1000 + (4000 * index)).show("fade",500).delay(3000).hide("fade",500);
	});
	$(".main-container").delay(11000).hide("fade",500);
	$(".testing").delay(12000).show("fade",1000);
	$(".test-q").delay(12000).show("fade",1000);
	/*
	$(".main-container").delay(500).hide("fade",500);
	$(".testing").delay(510).show("fade",1000)
	$(".test-q").delay(510).show("fade",1000);*/
}