jQuery(function($) {
	
	var features = d3.select("g");
	
	var zoom = d3.behavior.zoom()
	.translate([0, 9])
	.scale([0, 9])
	.on("zoom", zoomed);
	
	d3.select("#svg").call(zoom);
	
	function zoomed() {
	  features.attr("transform", "translate(" + d3.event.translate + ")scale(" + d3.event.scale + ")");
	}
});