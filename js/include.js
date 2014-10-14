$(document).ready(fillCommonTags);

function fillCommonTags() {
  $("header").first().load("header.html");
  $("nav").first().load("nav.html");
};

/* Protects your partially-filled custom order form. */
function closeEditorWarning() {
    return 'It looks like you have been editing something -- if you leave before submitting your changes will be lost.';
}
if (document.getElementById('ordering')) {
    window.onbeforeunload = closeEditorWarning;
}