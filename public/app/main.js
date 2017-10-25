const f = require('./js/dirToRename/fileToChange');

require('./css/main.css');

module.exports = (() => {

    const init = () => {

        f();

    };

    return {
        init
    };

})();
