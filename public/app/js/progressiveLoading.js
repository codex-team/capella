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
      blurImage.style.filter = 'blur(25px) opacity(0.6)';
      blurImage.style.transition = 'filter 1.5s';

      img.onload = function () {
        fullImage.classList.add('js-image-loaded'),

        fullImage.style.backgroundImage = 'url(' + fullImageUrl + ')';

        setTimeout(function () {
          blurImage.style.background = 'transparent';
          blurImage.style.filter = 'none';
        }, 500);
      };
    });
  };

  return {
    init: init
  };
}();
