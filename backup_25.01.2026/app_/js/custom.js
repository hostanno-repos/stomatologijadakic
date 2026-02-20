/* loader hide */
$(window).on('load', function() {
    $('#loader_').fadeOut( "slow", function() {
      // Animation complete.
    });
});

/*raspored zuba selekcija*/

$(".raspored-zuba-selectable img").click(function(){
  $(".raspored-zuba-selectable img").css("filter", "drop-shadow(0px 0px 1px black)");
  $(this).css("filter","invert(0.5)");
  var valueToUseInSelect = $(this).attr('zubToSelect');
  var inputString = "";
  switch(valueToUseInSelect.charAt(0)){
    case "1":
      inputString = inputString+"Gore desno";
      break;
    case "2":
      inputString = inputString+"Gore lijevo";
      break;
    case "3":
      inputString = inputString+"Dole lijevo";
      break;
    case "4":
      inputString = inputString+"Dole desno";
      break;
  }
  switch(valueToUseInSelect.charAt(1)){
    case "1":
      inputString = inputString+" jedinica";
      break;
    case "2":
      inputString = inputString+" dvojka";
      break;
    case "3":
      inputString = inputString+" trojka";
      break;
    case "4":
      inputString = inputString+" četvorka";
      break;
    case "5":
      inputString = inputString+" petica";
      break;
    case "6":
      inputString = inputString+" šestica";
      break;
    case "7":
      inputString = inputString+" sedmica";
      break;
    case "8":
      inputString = inputString+" osmica";
      break;
  }
  
  $("input[name=intervencije_zub]").val(valueToUseInSelect);
  $("span#intervencije_zub").html(inputString);

});

$(".checkboxesZubi input").click(function(){

  var thisCheckboxValue = $(this).attr("value");

  if(thisCheckboxValue == "Jedan zub"){
    $(".zubiOverlay").css('display', 'none');
  }else{
    $(".zubiOverlay").css('display', 'flex');
    $("input[name=intervencije_zub]").val(thisCheckboxValue);
    $("span#intervencije_zub").html(thisCheckboxValue);
    $(".raspored-zuba-selectable img").css("filter", "drop-shadow(0px 0px 1px black)");
  }

  if($(this).prop('checked') == false){
    $(".zubiOverlay").css('display', 'flex');
    $("input[name=intervencije_zub]").val("");
    $("span#intervencije_zub").html("");
    $(".raspored-zuba-selectable img").css("filter", "drop-shadow(0px 0px 1px black)");
  }else{
    $(".checkboxesZubi input").prop('checked', false);
    $(this).prop('checked', true);
  }

});

/* prikaz ili skrivanje sekcija na kartonu */

/* pročitaj cookie i prikaži sekciju koja je upisana u cookie */
$(document).ready(function(){
  var getCookieSectionActive = $.cookie("selectedSection");
  $("#"+getCookieSectionActive).addClass("elementActive");
  getCookieSectionActive = getCookieSectionActive.replace('element','opener');
  $("#"+getCookieSectionActive).addClass("sectionActive");
});

/* izmjena sekcije klikom na dugme */
$(".sectionOpener").click(function(){
  if($(this).hasClass('sectionActive')){
    //$(this).removeClass('sectionActive');
    //var thisID = $(this).attr("id");
    //thisID = thisID.replace('opener','element');
    //$("#"+thisID).removeClass("elementActive");
    //$.cookie("selectedSection", "");
    //alert($.cookie("selectedSection"));
  }else{
    if ($(".sectionActive")[0]){
        var activeID = $('.sectionActive').attr("id");
        activeID = activeID.replace('opener','element');
        $("#"+activeID).removeClass("elementActive");
        $('.sectionActive').removeClass('sectionActive');
        $(this).addClass('sectionActive');
        var thisID = $(this).attr("id");
        thisID = thisID.replace('opener','element');
        $("#"+thisID).addClass("elementActive");
        $.cookie("selectedSection", thisID);
        //alert($.cookie("selectedSection"));
    } else {
        $(this).addClass('sectionActive');
        var thisID = $(this).attr("id");
        thisID = thisID.replace('opener','element');
        $("#"+thisID).addClass("elementActive");
        $.cookie("selectedSection", thisID);
        //alert($.cookie("selectedSection"));
    }    
  }
});

/* reset podešavanja sekcije kad otvorimo novi karton */
$(".clearCookieSectionActive").click(function(){
  $.cookie("selectedSection", "elementKarton");
});

/* edit intervencije */

//XML REQUEST
function showEditIntervencije(str) {
  if (str == "") {
      document.getElementById("polja_tip_intervencije").innerHTML = "";
      return;
  } else {
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
          document.getElementById("polja_tip_intervencije").innerHTML = this.responseText;
      }
      };
      xmlhttp.open("GET","class/intervencije.php?get_edit_tip_intervencije="+str,true);
      xmlhttp.send();
  }
}

//FILL THE POPUP BUTTONS
$(".edit-intervencije>i").click(function(){
  var dataID_ = $(this).attr("dataID_");
  var dataLink = $(this).attr("dataLink");
  $("input#dataID_").val(dataID_);
  $("#confirmDeleteKategorija").attr('href', dataLink);
});

//GET DATA FOR DELETING INTERVENCIJE
$(".delete-object").click(function(){
  var dataID_ = $(this).attr("dataID_");
  var dataLink = $(this).attr("dataLink");
  //$("input#dataID_").val(dataID_);
  $("#submit_delete_tip_intervencije").attr('href', dataLink);
});

//GETTING ID FROM SELECT
$(".gettingIdSelect").change(function(){
  var doktorIdSelectValue = $(this).find(":selected").val();
  $(this).prev('input').val(doktorIdSelectValue);
});