module.exports = (function () {
  var mainContainer = document.getElementsByClassName('capella');

  var init = function () {
    mainContainer[0].classList.toggle('capella--dark', false);
    mainContainer[0].classList.toggle('capella--loading', false);
  };

  var dragNdrop = function () {
    mainContainer[0].classList.toggle('capella--loading', false);
    mainContainer[0].classList.add('capella--dark');
  };
  var progress = function (percents) {
    var progressBar = document.getElementsByClassName('js-capella__uploading-progress');

    mainContainer[0].classList.toggle('capella--dark', false);

    mainContainer[0].classList.add('capella--loading');

    progressBar[0].setAttribute('value', percents);
  };

  return {

    init : init,
    progress : progress,
    dragNdrop : dragNdrop

  };
}());