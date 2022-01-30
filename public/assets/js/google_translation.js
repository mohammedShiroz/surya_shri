function googleTranslateElementInit() {
    new google.translate.TranslateElement({pageLanguage: 'en'}, 'google_translate_element');
}
function change_des_lag(){
    var nLang = document.getElementById("des_lag").value;
    var evt = document.createEvent("HTMLEvents");
    evt.initEvent("change", false, true);
    $('.goog-te-combo').val(nLang)[0].dispatchEvent(evt);
}
