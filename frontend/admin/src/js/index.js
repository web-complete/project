/* eslint-disable no-unused-vars,react/jsx-filename-extension,no-undef */
import React from 'react';
import ReactDOM from 'react-dom';
import normalizeCss from '../assets/css/normalize.css';
import fontAwesomeCss from '../assets/css/font-awesome.min.css';
import ionIconsCss from '../assets/css/ionicons.min.css';
import baseCss from '../assets/css/base.css';
import popupCss from '../assets/css/popup.css';
import loginCss from '../assets/css/login.css';
import App from './components/App';

ReactDOM.render(<App />, document.getElementById('root'));

if (module.hot) {
  module.hot.accept(() => {});
}
