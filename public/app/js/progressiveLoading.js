/**
  * progressiveLoading
  * Module enabling low-quality blurred background Image placeholder,
  * while high-quality image is loaded
  *
  * @usage
  * <div class="js-full-image" data-src="/path/to/your/high-quality-image.jpg">
  *   <div class="js-blur-image"></div>
  * </div>
  */

module.exports = function () {
  /**
   * progressiveLoading Initialization
   *
   * Reveal low-quality Image with class '.js-blur-image'
   * Find high-quality src and create new Image object with it
   * While new Image is loading, maintain blurred filter over it
   * When loading is finished, remove blur
   *
   */
  let init = function () {
    let CLASSES = {
      blurImageClass: '.js-blur-image',
      fullImageClass: '.js-full-image',
      isLoadedClass: 'js-image-loaded'
    };

    let STYLES = {
      blurredStyle: 'blur(5px)',
      transitionStyle: 'filter 1.5s',
      backgroundColor: '#11173e',
      backgroundTransparent: 'transparent',
      removeStyle:'none'
    };

    let DELAY = 500;

    let blurImage = document.querySelector(CLASSES.blurImageClass);

    document.addEventListener('DOMContentLoaded', function () {
      /**
       * If Image with blurImageClass is not found, return
       */
      if (!blurImage) return null;
      /**
       * Find high-quality image with class fullImageClass and get target src from its data-src=''
       * Create new Image object with src
       *
       * Add blurred filter to low-quality Image preview
       */
      let fullImage = document.querySelector(CLASSES.fullImageClass),
          fullImageUrl = fullImage.getAttribute('data-src'),
          img = new Image();

      img.src = fullImageUrl;
      blurImage.style.filter = STYLES.blurredStyle;
      blurImage.style.transition = STYLES.transitionStyle;

      /**
       * When high-quality Image is loaded
       */
      img.onload = function () {
        /**
         * Add to fullImage isLoadedClass
         */
        fullImage.classList.add(CLASSES.isLoadedClass),
        /**
         * Add violet background color and background image
         */
        fullImage.style.backgroundColor = STYLES.backgroundColor;
        fullImage.style.backgroundImage = 'url(' + fullImageUrl + ')';
        /**
         * After DELAY make low-quality preview transparent
         * Remove blurred filter to make transition smooth
         */
        setTimeout(function () {
          blurImage.style.backgroundColor = STYLES.backgroundTransparent;
          blurImage.style.backgroundImage = STYLES.removeStyle;
          blurImage.style.filter = STYLES.removeStyle;
        }, DELAY);
      };
    });
  };

  return {
    init: init
  };
}();
