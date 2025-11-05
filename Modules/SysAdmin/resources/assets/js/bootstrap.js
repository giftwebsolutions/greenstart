/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import $ from 'jquery'
window.jQuery = window.$ = $

import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;

import * as Popper from '@popperjs/core';
window.Popper = Popper.defaults;
import moment from "moment";
window.moment = moment();

import tempusDominus from '@eonasdan/tempus-dominus/dist/js/tempus-dominus';
window.tempusDominus = tempusDominus;

import '@nextapps-be/livewire-sortablejs';

import CodeMirror from 'codemirror';
import 'codemirror/mode/xml/xml'; // Example mode
import 'codemirror/addon/edit/matchbrackets';
window.CodeMirror = CodeMirror;

import axios from 'axios';
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

