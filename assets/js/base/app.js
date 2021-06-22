import axios from "axios";

const jQuery = require('jquery');

// Additional imports for templates
import 'bootstrap'
import '../../css/bootstrap.min.css'

import '@fortawesome/fontawesome-free/css/all.css';
import '@fortawesome/fontawesome-free/js/all.js';

import './custom.js'
import './sticky-sidebar.js'
import './jquery-ui.js'

import '../../sass/style.scss'
import '../../sass/responsive.scss'
import '../../sass/travlez-jquery-ui.scss'

function authenticate() {
	const credentials = new URLSearchParams()
	credentials.append('client_id', '1tGzxd3fKVzoGHKGczSPLSeI1iFvqeuX')
	credentials.append('client_secret', 'y79k0sQJvFbZMc7J')
	credentials.append('grant_type', 'client_credentials')
	const config = {
		headers: {
			'Content-Type': 'application/x-www-form-urlencoded'
		}
	}

	return axios.post("https://test.api.amadeus.com/v1/security/oauth2/token", credentials, config)
		.then(response => response.data)
		.then(({access_token, expires_in}) => {
			window.localStorage.setItem("authToken", access_token)
			window.localStorage.setItem("expireAt", (new Date().getTime() + expires_in * 1000).toString())
			axios.defaults.headers["Authorization"] = "Bearer " + access_token
		})
}

function setup() {
	if (isAuthenticated()) {
		const token = window.localStorage.getItem("authToken")
		axios.defaults.headers["Authorization"] = "Bearer " + token
	} else {
		authenticate().then(r => r)
	}
}

function isAuthenticated() {
	const token = window.localStorage.getItem("authToken")
	if (token) {
		const expireAt = window.localStorage.getItem("expireAt")
		return expireAt > new Date().getTime();
	}
	return false
}

setup()

export {
	setup
}

