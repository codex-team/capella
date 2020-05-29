'use strict';

const ajax = require('@codexteam/ajax');

/**
 * Simple form submittion helper
 */
module.exports = (function () {
  /**
   * Clear a form element and create a response message with a token
   *
   * @param {string} token
   */
  const showToken = function (token) {
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
   *
   * @param {string} data.name - project's name
   * @param {string} data.description - usage description
   * @param {string} data.email - contact email
   */
  const sendForm = function (data) {
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
   *
   * @param {string} data.name - project's name
   * @param {string} data.description - usage description
   * @param {string} data.email - contact email
   */
  const validateForm = function (data) {
    sendForm(data);
  };

  /**
   * Get data from form fields directly and validate it
   */
  const getForm = function () {
    const nameField = document.getElementById('name');
    const descriptionField = document.getElementById('description');
    const emailField = document.getElementById('email');

    let data = {
      name: nameField ? nameField.value : '',
      description: descriptionField ? descriptionField.value : '',
      email: emailField ? emailField.value : '',
    };

    validateForm(data);
  };

  /**
   * Init method
   * Find button element and add event listener
   */
  const init = function () {
    const submitButton = document.getElementById('submitFormButton');

    if (submitButton) {
      submitButton.addEventListener('click', getForm, false);
    }
  };

  return {
    init
  };
})();