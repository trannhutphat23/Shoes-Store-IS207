function ShowDropdown(element) {
    $('li ol').not($(element).next('ol')).slideUp();
    $(element).next('ol').slideToggle();
}

function routerPage(url) {
    document.getElementById('frame').src = url
}