'use strict';

const ajax = require('@codexteam/ajax');

/**
 * Simple form submittion helper
 */
module.exports = (() => {
  const showToken = (token) => {
    const form = document.getElementById('projectForm');
    const message = document.createElement('DIV');

    form.innerHTML = '';
    message.innerHTML = '<p>Access token for your project:</p>' +
                        `<p><b>${token}</b></p>` +
                        '<p>Read the <a href=\"https://github.com/codex-team/capella#upload-api\">upload API</a> docs page.</p>';

    form.appendChild(message);
  };

  /**
   * Send an AJAX request
   */
  const sendForm = (data) => {
    ajax.post({
      url: '',
      data: data,
      type: ajax.contentType.FORM
    })
      .then((response) => {
        if (response.body && response.body.token) {
          showToken(response.body.token);
        }
      })
      .catch((errorResponse) => {
        console.error(errorResponse);
      });
  };

  /**
   * Check for a non-valid fields
   *
   * @todo create form validation
   */
  const validateForm = (data) => {
    sendForm(data);
  };

  /**
   * Get data from from fields directly
   */
  const getForm = () => {
    let data = {
      name: document.getElementById('name') ? document.getElementById('name').value : '',
      email: document.getElementById('email') ? document.getElementById('email').value : '',
      description: document.getElementById('description') ? document.getElementById('description').value : '',
    };

    validateForm(data);
  };

  /**
   * Init method
   */
  const init = () => {
    const submitButton = document.getElementById('submitFormButton');

    if (submitButton) {
      submitButton.addEventListener('click', getForm, false);
    }
  };

  return {
    init
  };
})();