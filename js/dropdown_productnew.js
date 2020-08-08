$(document).ready(function(){

//Color
$("#color_product").click(function() {
   $.ajax({
    type: "POST",
    url: "return_color.php",
    cache: false,
    success: function(html)
    {
    $("#color_list").html(html).show();
    }
    });
});
	jQuery(document).live("click", function(e) {
	var $clicked = $(e.target);
	if (! $clicked.hasClass("color_product")){
	jQuery("#color_list").fadeOut();

	}
});

//type

$("#type_product").click(function() {
   $.ajax({
    type: "POST",
    url: "return_type.php",
    cache: false,
    success: function(html)
    {
    $("#type_list").html(html).show();
    }
    });
});
	jQuery(document).live("click", function(e) {
	var $clicked = $(e.target);
	if (! $clicked.hasClass("type_product")){
	jQuery("#type_list").fadeOut();

	}
});
//model
$("#model_product").click(function() {
   $.ajax({
    type: "POST",
    url: "return_model.php",
    cache: false,
    success: function(html)
    {
    $("#model_list").html(html).show();
    }
    });
});
	jQuery(document).live("click", function(e) {
	var $clicked = $(e.target);
	if (! $clicked.hasClass("model_product")){
	jQuery("#model_list").fadeOut();

	}
});

//unit
$("#unit").click(function() {
   $.ajax({
    type: "POST",
    url: "return_unit.php",
    cache: false,
    success: function(html)
    {
    $("#unit_list").html(html).show();
    }
    });
});
	jQuery(document).live("click", function(e) {
	var $clicked = $(e.target);
	if (! $clicked.hasClass("unit")){
	jQuery("#unit_list").fadeOut();

	}
});
//stock_part
$("#stock_part").click(function() {
   $.ajax({
    type: "POST",
    url: "return_stock_part.php",
    cache: false,
    success: function(html)
    {
    $("#stock_part_list").html(html).show();
    }
    });
});
	jQuery(document).live("click", function(e) {
	var $clicked = $(e.target);
	if (! $clicked.hasClass("stock_part")){
	jQuery("#stock_part_list").fadeOut();

	}
});

//size_product
$("#size_product").click(function() {
   $.ajax({
    type: "POST",
    url: "return_size_product.php",
    cache: false,
    success: function(html)
    {
    $("#size_product_list").html(html).show();
    }
    });
});
	jQuery(document).live("click", function(e) {
	var $clicked = $(e.target);
	if (! $clicked.hasClass("size_product")){
	jQuery("#size_product_list").fadeOut();

	}
});

//minimum
$("#minimum").click(function() {
   $.ajax({
    type: "POST",
    url: "return_minimum_list.php",
    cache: false,
    success: function(html)
    {
    $("#minimum_list").html(html).show();
    }
    });
});
    jQuery(document).live("click", function(e) {
    var $clicked = $(e.target);
    if (! $clicked.hasClass("minimum")){
    jQuery("#minimum_list").fadeOut();

    }
});

});

	