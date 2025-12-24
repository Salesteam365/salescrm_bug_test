
"use strict";
(() => {
  window.addEventListener('scroll', stickyFn);
  let navbar = document.getElementById("sidebar");
  let sticky = navbar.offsetTop;
  function stickyFn() {
    if (window.scrollY >= 75) {
      navbar.classList.add("sticky-pin")
    } else {
      navbar.classList.remove("sticky-pin");
    }
  }
  window.addEventListener('scroll', stickyFn);
  window.addEventListener('DOMContentLoaded', stickyFn);
})();
