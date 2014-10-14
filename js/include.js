$(document).ready(fillCommonTags);

function fillCommonTags() {
  $("header").first().load("header.html");
  $("nav").first().load("nav.html");
};