
// Dragover and Dragenter events need to have 'preventDefault' called
// in order for the 'drop' event to register.

dropContainer.ondragover = dropContainer.ondragenter = function(evt) {
    evt.preventDefault();
};
//Drag and drop function
dropContainer.ondrop = function(evt) {
    // pretty simple -- but not for IE :(
    fileInput.files = evt.dataTransfer.files;
    evt.preventDefault();
};
