$(document.body).on('click', 'img[aria-view=true]', (function () {
    $("#full-image").attr("src", $(this).attr("src"));
    $('#image-viewer').show();
}));

$("#image-viewer .close").on('click', (function () {
    $('#image-viewer').hide();
}));
