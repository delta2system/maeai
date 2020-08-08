$(document).ready(function(){

//Color
$("#ceo").keyup(function() {

   $.ajax({
    type: "POST",
    url: "return_ceo.php",
    data: "ceo="+$("#ceo").val(),
    cache: false,
    success: function(html)
    {
    var po = $("#ceo").position();
    $("#ceo_list").css({"left": po.left+"px","top": (po.top+40)+"px"});
    $("#ceo_list").html(html).show();
    }
    });
});

    jQuery(document).live("click", function(e) {
    var $clicked = $(e.target);
    if (!$clicked.hasClass("ceo")){
    jQuery("#ceo_list").fadeOut();
    }

});

//เจ้าหน้าที่พัสดุ
$("#procurement_officer").keyup(function() {

   $.ajax({
    type: "POST",
    url: "return_procurement_officer.php",
    data: "procurement_officer="+$("#procurement_officer").val(),
    cache: false,
    success: function(html)
    {
    var po = $("#procurement_officer").position();
    $("#procurement_officer_list").css({"left": po.left+"px","top": (po.top+40)+"px"});
    $("#procurement_officer_list").html(html).show();
    }
    });
});

    jQuery(document).live("click", function(e) {
    var $clicked = $(e.target);
    if (!$clicked.hasClass("procurement_officer")){
    jQuery("#procurement_officer_list").fadeOut();
    }

});



//cmt_1
$("#cob").keyup(function() {

   $.ajax({
    type: "POST",
    url: "return_cob.php",
    data: "search="+$("#cob").val(),
    cache: false,
    success: function(html)
    {
    var po = $("#cob").position();
    $("#cob_list").css({"left": po.left+"px","top": (po.top+40)+"px"});
    $("#cob_list").html(html).show();
    }
    });
});

    jQuery(document).live("click", function(e) {
    var $clicked = $(e.target);
    if (!$clicked.hasClass("cob")){
    jQuery("#cob_list").fadeOut();
    }

});


    
//cmt_1
$("#cmt_1").keyup(function() {

   $.ajax({
    type: "POST",
    url: "return_cmt_1.php",
    data: "search="+$("#cmt_1").val(),
    cache: false,
    success: function(html)
    {
    var po = $("#cmt_1").position();
    $("#cmt_1_list").css({"left": po.left+"px","top": (po.top+40)+"px"});
    $("#cmt_1_list").html(html).show();
    }
    });
});

    jQuery(document).live("click", function(e) {
    var $clicked = $(e.target);
    if (!$clicked.hasClass("cmt_1")){
    jQuery("#cmt_1_list").fadeOut();
    }

});
 //cmt_2
$("#cmt_2").keyup(function() {

   $.ajax({
    type: "POST",
    url: "return_cmt_2.php",
    data: "search="+$("#cmt_2").val(),
    cache: false,
    success: function(html)
    {
    var po = $("#cmt_2").position();
    $("#cmt_2_list").css({"left": po.left+"px","top": (po.top+40)+"px"});
    $("#cmt_2_list").html(html).show();
    }
    });
});

    jQuery(document).live("click", function(e) {
    var $clicked = $(e.target);
    if (!$clicked.hasClass("cmt_2")){
    jQuery("#cmt_2_list").fadeOut();
    }

});
//cmt_3
$("#cmt_3").keyup(function() {

   $.ajax({
    type: "POST",
    url: "return_cmt_3.php",
    data: "search="+$("#cmt_3").val(),
    cache: false,
    success: function(html)
    {
    var po = $("#cmt_3").position();
    $("#cmt_3_list").css({"left": po.left+"px","top": (po.top+40)+"px"});
    $("#cmt_3_list").html(html).show();
    }
    });
});

    jQuery(document).live("click", function(e) {
    var $clicked = $(e.target);
    if (!$clicked.hasClass("cmt_3")){
    jQuery("#cmt_3_list").fadeOut();
    }

});

//cmt_4
$("#cmt_4").keyup(function() {

   $.ajax({
    type: "POST",
    url: "return_cmt_4.php",
    data: "search="+$("#cmt_4").val(),
    cache: false,
    success: function(html)
    {
    var po = $("#cmt_4").position();
    $("#cmt_4_list").css({"left": po.left+"px","top": (po.top+40)+"px"});
    $("#cmt_4_list").html(html).show();
    }
    });
});

    jQuery(document).live("click", function(e) {
    var $clicked = $(e.target);
    if (!$clicked.hasClass("cmt_4")){
    jQuery("#cmt_4_list").fadeOut();
    }

});

});

	