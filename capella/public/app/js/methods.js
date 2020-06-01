'use strict';

/**
 * Class with helpers
 */
export default class Methods {
  /**
     * Get cookie value by name
     *
     * @param {string} name
     * @returns {string}
     */
  static getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);

    if (parts.length === 2) return parts.pop().split(';').shift();
  }
}