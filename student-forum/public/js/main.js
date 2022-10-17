function clickHamburger() {

  $(".hamburger").toggleClass("is-active");

 if($(".au-nav-mobile").css("display")=="block") {
   $(".au-nav-mobile").fadeOut();
 } else {
   $(".au-nav-mobile").fadeIn();

 }
}

 function openNext(element) {
  if ($(element).next().css("display")=="block") {
    $(element).next().fadeOut();
  } else {
    $(element).next().fadeIn();
  }
}
