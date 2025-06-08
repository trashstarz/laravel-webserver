window.onscroll = function() {
  var backToTopButton = document.getElementById("backToTop");
  if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
    backToTopButton.style.display = "block"; // Show button
  } else {
    backToTopButton.style.display = "none"; // Hide button
  }
};

function scrollToTop() {
  window.scrollTo({
    top: 0,
    behavior: "smooth" 
  });
}

