
/**
 * Function uploads drag and drop object to form
 */
$("#upload").change(function () {
    $('#activite').text('Идет загрузка...');
    document.getElementById("send").click();
});


/**
 * These functions change drag'n'drop windows on depend of situation
 */
$(document).on('dragover', '#filez', function (e) {
    e.preventDefault();
    $(this).css('background-color', 'white');
});
$(document).on('dragleave', '#filez', function (e) {
    $(this).css('background-color', 'white');
});
$(document).on('drop', '#filez', function (e) {
    $('#activite').html('Идет загрузка...');
    $(this).css('background-color', 'white');
});