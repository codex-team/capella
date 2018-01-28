/**
  * progressiveLoading module allows shows blurred background image,
  * While high-quality image is loaded
  *
  * @usage
  * <div class="js-full-image" data-src="/path/to/your/high-quality-image.jpg">
  *   <div class="js-blur-image"></div>
  * </div>
  *
  * @type {{init}}
  */
module.exports = function () {
  let init = function () {
    let blurImage = document.querySelector('.js-blur-image');

    document.addEventListener('DOMContentLoaded', function () {
      if (!blurImage) return !1;

      let fullImage = document.querySelector('.js-full-image'),
          fullImageUrl = fullImage.getAttribute('data-src'),
          img = new Image();

      img.src = fullImageUrl;

      img.onload = function () {
        fullImage.classList.add('js-image-loaded'),
        fullImage.style.backgroundImage = 'url(' + fullImageUrl + ')';

        blurImage.style.background = 'transparent';
      };
    });
  };

  return {
    init: init
  };
}();
