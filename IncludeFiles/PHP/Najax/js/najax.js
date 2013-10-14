var NAJAX_ERROR_USER = 0x400;
var NAJAX_ERROR_TIMEOUT = 0x401;

var najax = {};

najax.errorHandler = null;

najax.callbacks = {};

najax.callbacks.table = {};
najax.callbacks.count = 0;

najax.events = {};

najax.events.table = [];
najax.events.postTable = [];

najax.events.timeout = 5000;

najax.events.startInterval = 250;
najax.events.refreshInterval = 2000;

najax.events.status = 0;

najax.observers = [];

najax.asyncCall = function() {};

najax.getError = function(errorCode, errorMessage)
{
	return {

		code	:	errorCode,

		message	:	errorMessage
	}
};

najax.getXmlHttp = function()
{
	var xmlHttp = null;

	try {

		xmlHttp = new XMLHttpRequest();

	} catch (e) {

		var progIds = ['MSXML2.XMLHTTP', 'Microsoft.XMLHTTP', 'MSXML2.XMLHTTP.5.0', 'MSXML2.XMLHTTP.4.0', 'MSXML2.XMLHTTP.3.0'];

		var success = false;

		for (var iterator = 0; (iterator < progIds.length) && ( ! success); iterator ++) {

			try {

				xmlHttp = new ActiveXObject(progIds[iterator]);

				success = true;

			} catch (e) {}
		}

		if ( ! success ) {

			return null;
		}
	}

	return xmlHttp;
};

najax.clone = function(target, source)
{
	var wipeKeys = [];

	for (var key in target.__meta) {

		if (typeof(source[key]) == 'undefined') {

			wipeKeys.push(key);
		}
	}

	if (wipeKeys.length > 0) {

		for (var iterator = 0; iterator < wipeKeys.length; iterator ++) {

			target[wipeKeys[iterator]] = null;
		}
	}

	for (var key in source.__meta) {

		if (source[key] == null) {

			target[key] = null;

		} else {

			target[key] = source[key];
		}
	}

	target.__meta = source.__meta;

	target.__size = source.__size;

	target.__timeout = source.__timeout;
};

najax.serialize = function(data)
{
	if (data == null) {

		return 'N;';
	}

	var type = typeof(data);

	var code = '';

	if (type == 'boolean') {

		code += 'b:' + (data ? 1 : 0) + ';';

	} else if (type == 'number') {

		if (Math.round(data) == data) {

			code += 'i:' + data + ';';

		} else {

			code += 'd:' + data + ';';
		}

	} else if (type == 'string') {

		var length = data.length;

		for (var iterator = 0; iterator < data.length; iterator ++) {

			var asciiCode = data.charCodeAt(iterator);

			if ((asciiCode >= 0x00000080) && (asciiCode <= 0x000007FF)) {

				length += 1;

			} else if ((asciiCode >= 0x00000800) && (asciiCode <= 0x0000FFFF)) {

				length += 2;

			} else if ((asciiCode >= 0x00010000) && (asciiCode <= 0x001FFFFF)) {

				length += 3;

			} else if ((asciiCode >= 0x00200000) && (asciiCode <= 0x03FFFFFF)) {

				length += 4;

			} else if ((asciiCode >= 0x04000000) && (asciiCode <= 0x7FFFFFFF)) {

				length += 5;
			}
		}

		code += 's:' + length + ':"' + data + '";';

	} else if (type == 'object') {

		if (typeof(data.__class) == 'undefined') {

			var length = 0;

			if (
			(typeof(data.length) == 'number') &&
			(data.length > 0) &&
			(typeof(data[0]) != 'undefined')) {

				for (var iterator = 0; iterator < data.length; iterator ++) {

					code += najax.serialize(iterator);

					code += najax.serialize(data[iterator]);
				}

				length = data.length;

			} else {

				for (var key in data) {

					if (/^[0-9]+$/.test(key)) {

						code += najax.serialize(parseInt(key));

					} else {

						code += najax.serialize(key);

					}

					code += najax.serialize(data[key]);

					length ++;
				}
			}

			code = 'a:' + length + ':{' + code + '}';

		} else {

			code += 'O:' + data.__class.length + ':"' + data.__class + '":' + data.__size + ':{';

			if (data.__meta != null) {

				for (var key in data.__meta) {

					code += najax.serialize(key);

					code += najax.serialize(data[key]);
				}
			}

			code += '}';
		}

	} else {

		code = 'N;'
	}

	return code;
};

najax.setErrorHandler = function(handler)
{
	if (
	(handler != null) &&
	(typeof(handler) == 'function')) {

		najax.errorHandler = handler;

		return true;
	}

	return false;
};

najax.restoreErrorHandler = function()
{
	najax.errorHandler = null;

	return true;
};

najax.throwException = function(error, throwArguments)
{
	if (typeof(throwArguments) != 'undefined') {

		var sender = throwArguments[0];

		var method = throwArguments[1];

		method = 'on' + method.charAt(0).toUpperCase() + method.substr(1) + 'Error';

		if (najax.invokeMethod(sender, method, [error])) {

			return false;
		}
	}

	if (
	(najax.errorHandler != null) &&
	(typeof(najax.errorHandler) == 'function')) {

		najax.errorHandler(error);

		return false;
	}

	throw error;
};

najax.invokeMethod = function(obj, method, invokeArguments)
{
	if (
	(obj == null) ||
	(typeof(obj) != 'object')) {

		return false;
	}

	var type = eval('typeof(obj.' + method + ')');

	if (type == 'function') {

		var invokeCode = 'obj.' + method + '(';

		if (typeof(invokeArguments) != 'undefined') {

			for (var iterator = 0; iterator < invokeArguments.length; iterator ++) {

				invokeCode += 'invokeArguments[' + iterator + ']';

				if (iterator < invokeArguments.length - 1) {

					invokeCode += ', ';
				}
			}
		}

		invokeCode += ')';

		return eval(invokeCode);
	}

	return false;
};

najax.call = function(obj, method, callArguments)
{
	if (
	(obj == null) ||
	(typeof(obj) != 'object') ||
	(typeof(obj.__class) != 'string')) {

		return false;
	}

	var methodCallback = null;

	var methodArgs = [];

	for (var iterator = 0; iterator < callArguments.length; iterator ++) {

		methodArgs.push(callArguments[iterator]);
	}

	if (
	(methodArgs.length > 0) &&
	(typeof(methodArgs[methodArgs.length - 1]) == 'function')) {

		methodCallback = methodArgs[methodArgs.length - 1];

		methodArgs.pop();
	}

	var xmlHttp = najax.getXmlHttp();

	var requestBody = {

		source		:	obj,

		className	:	obj.__class,

		method		:	method,

		arguments	:	methodArgs
	};

	najax.notifyObservers('call', requestBody);

	requestBody.source = najax.serialize(requestBody.source);
	requestBody.arguments = najax.serialize(requestBody.arguments);

	requestBody = najax.serialize(requestBody);

	var url = obj.__url;

	if (url.indexOf('?') < 0) {

		url += '?';

	} else {

		url += '&';
	}

	url += 'najaxCall=true';

	if (methodCallback != null) {

		xmlHttp.open('POST', url, true);

	} else {

		xmlHttp.open('POST', url, false);
	}

	var callId = null;

	var callTimeout = obj.getTimeout();

	if (callTimeout != null) {

		callId = najax.callbacks.count;
	}

	najax.callbacks.count ++;

	var requestCompleted = function() {

		if (callId != null) {

			if (eval('najax.callbacks.table.call' + callId + '.timeout')) {

				return false;
			}

			eval('window.clearTimeout(najax.callbacks.table.call' + callId + '.id)');

			eval('najax.callbacks.table.call' + callId + ' = null');
		}

		if (xmlHttp.status != 200) {

			return najax.throwException(najax.getError(xmlHttp.status, xmlHttp.statusText), [obj, method]);

		} else {

			if (xmlHttp.responseText == null) {

				return najax.throwException(najax.getError(xmlHttp.status, 'Empty response.'), [obj, method]);
			}

			if (xmlHttp.responseText.length < 1) {

				return najax.throwException(najax.getError(xmlHttp.status, 'Empty response.'), [obj, method]);
			}

			try {

				eval('var najaxResponse = ' + xmlHttp.responseText + ';');

			} catch(e) {

				return najax.throwException(najax.getError(xmlHttp.status, 'Invalid response.'), [obj, method]);
			}

			if (typeof(najaxResponse.exception) != 'undefined') {

				return najax.throwException(najax.getError(NAJAX_ERROR_USER, najaxResponse.exception), [obj, method]);
			}

			if (najax.notifyObservers('callCompleted', najaxResponse)) {

				obj.__clone(najaxResponse.returnObject);

				if (typeof(najaxResponse.output) != 'undefined') {

					obj.__output = najaxResponse.output;

				} else {

					obj.__output = null;
				}

				return {

					returnValue	:	najaxResponse.returnValue
				};
			}
		}

		return false;
	};

	try {

		xmlHttp.setRequestHeader('Content-Length', requestBody.length);

		xmlHttp.setRequestHeader('Content-Type', 'text/plain; charset=UTF-8');

		xmlHttp.setRequestHeader('Accept-Charset', 'UTF-8');

	} catch (e) {}

	if (methodCallback != null) {

		xmlHttp.onreadystatechange = function() {

			if (xmlHttp.readyState == 4) {

				var response = requestCompleted();

				if (typeof(response.returnValue) != 'undefined') {

					methodCallback(response.returnValue);
				}
			}
		}
	}

	if (callTimeout != null) {

		eval('najax.callbacks.table.call' + callId + ' = {}');

		eval('najax.callbacks.table.call' + callId + '.timeout = false');

		eval('najax.callbacks.table.call' + callId + '.source = obj');

		eval('najax.callbacks.table.call' + callId + '.id = '
		+ 'window.setTimeout(\'najax.callbacks.table.call' + callId + '.timeout = true; '
		+ 'najax.throwException(najax.getError(NAJAX_ERROR_TIMEOUT, "Timeout."), [najax.callbacks.table.call' + callId + '.source, "' + method + '"]);\', callTimeout)');
	}

	xmlHttp.send(requestBody);

	if (methodCallback == null) {

		var response = requestCompleted();

		if (typeof(response.returnValue) != 'undefined') {

			return response.returnValue;
		}

		return null;

	} else {

		return true;
	}
};

najax.catchEvent = function(obj, eventArguments)
{
	if (eventArguments.length < 2) {

		eventArguments[1] = null;
	}

	var eventData = {

		listener	:	obj,

		event		:	eventArguments[0],

		filter		:	eventArguments[1]
	};

	najax.events.table.push(eventData);

	najax.events.tableLength ++;

	if (najax.events.status < 1) {

		najax.events.status = 1;

		window.setTimeout('najax.dispatchEvents()', najax.events.startInterval);
	}

	return true;
};

najax.ignoreEvent = function(obj, eventArguments)
{
	if (najax.events.tableLength < 1) {

		return false;
	}

	if (eventArguments.length < 2) {

		eventArguments[1] = null;
	}

	for (var iterator = najax.events.table.length - 1; iterator >= 0; iterator --) {

		var event = najax.events.table[iterator];

		if (
		(event.listener.__uid == obj.__uid) &&
		(event.event == eventArguments[0]) &&
		(event.filter == eventArguments[1])) {

			najax.events.table[iterator] = null;

			najax.events.tableLength --;

			break;
		}
	}

	return true;
};

najax.queueDispatchEvents = function(time)
{
	if (typeof(time) == 'undefined') {

		time = najax.events.refreshInterval;
	}

	window.setTimeout('najax.dispatchEvents()', time);
};

najax.dispatchEvents = function()
{
	if (najax.events.tableLength < 1) {

		najax.events.status = 0;

		return false;
	}

	if (
	(typeof(najax.events.callbackUrl) != 'string') ||
	(typeof(najax.events.lastRefresh) != 'number')) {

		najax.events.status = 0;

		return false;
	}

	najax.events.status = 1;

	var eventsData = [];

	for (var iterator = 0; iterator < najax.events.table.length; iterator ++) {

		var event = najax.events.table[iterator];

		if (event != null) {

			eventsData.push({

				className	:	event.listener.__class,

				event		:	event.event,

				filter		:	event.filter
			});
		}
	}

	var xmlHttp = najax.getXmlHttp();

	var requestBody = najax.serialize({

		eventsCallback	:	true,

		time			:	najax.events.lastRefresh,

		data			:	eventsData
	});

	var url = najax.events.callbackUrl;

	if (url.indexOf('?') < 0) {

		url += '?';

	} else {

		url += '&';
	}

	url += 'najaxCall=true';

	xmlHttp.open('POST', url, true);

	var callId = najax.callbacks.count ++;

	var requestCompleted = function() {

		if (eval('najax.callbacks.table.call' + callId + '.timeout')) {

			return false;
		}

		eval('window.clearTimeout(najax.callbacks.table.call' + callId + '.id)');

		eval('najax.callbacks.table.call' + callId + ' = null');

		if (xmlHttp.status != 200) {

			najax.queueDispatchEvents();

			return false;

		} else {

			if (xmlHttp.responseText == null) {

				najax.queueDispatchEvents();

				return false;
			}

			if (xmlHttp.responseText.length < 1) {

				najax.queueDispatchEvents();

				return false;
			}

			try {

				eval('var najaxResponse = ' + xmlHttp.responseText + ';');

			} catch(e) {

				najax.queueDispatchEvents();

				return false;
			}

			if (typeof(najaxResponse) != 'object') {

				najax.queueDispatchEvents();

				return false;
			}

			if (najax.notifyObservers('dispatchEventsCompleted', najaxResponse)) {

				for (var serverIterator = 0; serverIterator < najaxResponse.result.length; serverIterator ++) {

					var serverEvent = najaxResponse.result[serverIterator];

					for (var clientIterator = 0; clientIterator < najax.events.table.length; clientIterator ++) {

						var clientEvent = najax.events.table[clientIterator];

						if (clientEvent != null) {

							if (
							(serverEvent.event == clientEvent.event) &&
							(serverEvent.className.toLowerCase() == clientEvent.listener.__class.toLowerCase()) &&
							(serverEvent.filter == clientEvent.filter)) {

								eval('if (typeof(clientEvent.listener.' + clientEvent.event + ') == "function") { '
								+ 'clientEvent.listener.' + clientEvent.event + '(serverEvent.eventData.sender, serverEvent.eventData.data) }');
							}
						}
					}

					if (serverEvent.time > najax.events.lastRefresh) {

						najax.events.lastRefresh = serverEvent.time;
					}
				}

				najax.queueDispatchEvents();

				return true;
			}
		}

		return false;
	};

	try {

		xmlHttp.setRequestHeader('Content-Length', requestBody.length);

		xmlHttp.setRequestHeader('Content-Type', 'text/plain; charset=UTF-8');

		xmlHttp.setRequestHeader('Accept-Charset', 'UTF-8');

	} catch (e) {}

	xmlHttp.onreadystatechange = function() {

		if (xmlHttp.readyState == 4) {

			najax.events.status = 3;

			requestCompleted();

			najax.events.status = 1;
		}
	};

	eval('najax.callbacks.table.call' + callId + ' = {}');

	eval('najax.callbacks.table.call' + callId + '.timeout = false');

	eval('najax.callbacks.table.call' + callId + '.id = '
	+ 'window.setTimeout(\'najax.callbacks.table.call' + callId + '.timeout = true; '
	+ 'najax.queueDispatchEvents();\', najax.events.timeout)');

	najax.events.status = 2;

	xmlHttp.send(requestBody);

	return true;
};

najax.queuePostEvent = function(eventId)
{
	if (typeof(najax.events.postTable[eventId]) == 'object') {

		najax.postEvent(najax.events.postTable[eventId].sender, [
		najax.events.postTable[eventId].event,
		najax.events.postTable[eventId].data,
		najax.events.postTable[eventId].filter,
		eventId]);
	}
};

najax.postEvent = function(obj, eventArguments)
{
	if (typeof(najax.events.callbackUrl) != 'string') {

		return false;
	}

	var	eventName = eventArguments[0];
	var eventData = (eventArguments.length > 1) ? eventArguments[1] : null;
	var eventFilter = (eventArguments.length > 2) ? eventArguments[2] : null;

	var eventId = (eventArguments.length > 3) ? eventArguments[3] : najax.events.postTable.length;

	najax.events.postTable[eventId] = {

		sender		:	obj,

		event		:	eventName,

		data		:	eventData,

		filter		:	eventFilter
	};

	var xmlHttp = najax.getXmlHttp();

	var requestBody = najax.serialize({

		eventPost	:	true,

		className	:	obj.__class,

		sender		:	najax.serialize(obj),

		event		:	eventName,

		data		:	eventData,

		filter		:	eventFilter
	});

	var url = najax.events.callbackUrl;

	if (url.indexOf('?') < 0) {

		url += '?';

	} else {

		url += '&';
	}

	url += 'najaxCall=true';

	xmlHttp.open('POST', url, true);

	var requestCompleted = function() {

		if (xmlHttp.status != 200) {

			najax.queuePostEvent(eventId);

			return false;

		} else {

			if (xmlHttp.responseText == null) {

				najax.queuePostEvent(eventId);

				return false;
			}

			if (xmlHttp.responseText.length < 1) {

				najax.queuePostEvent(eventId);

				return false;
			}

			try {

				eval('var najaxResponse = ' + xmlHttp.responseText + ';');

			} catch(e) {

				najax.queuePostEvent(eventId);

				return false;
			}

			if (typeof(najaxResponse) != 'object') {

				najax.queuePostEvent(eventId);

				return false;
			}

			if (najaxResponse.status != true) {

				najax.queuePostEvent(eventId);

				return false;
			}

			if (najax.notifyObservers('postEventCompleted', najaxResponse)) {

				najax.events.postTable[eventId] = null;

				return true;
			}
		}

		return false;
	};

	try {

		xmlHttp.setRequestHeader('Content-Length', requestBody.length);

		xmlHttp.setRequestHeader('Content-Type', 'text/plain; charset=UTF-8');

		xmlHttp.setRequestHeader('Accept-Charset', 'UTF-8');

	} catch (e) {}

	xmlHttp.onreadystatechange = function() {

		if (xmlHttp.readyState == 4) {

			requestCompleted();
		}
	};

	xmlHttp.send(requestBody);

	return true;
};

najax.addObserver = function(observer)
{
	najax.observers.push(observer);

	return true;
};

najax.notifyObservers = function(event)
{
	if (najax.observers.length < 1) {

		return true;
	}

	var eventMethod = 'on' + event.charAt(0).toUpperCase() + event.substr(1);

	var notifyArguments = [];

	for (var iterator = 1; iterator < arguments.length; iterator ++) {

		notifyArguments.push(arguments[iterator]);
	}

	for (var iterator = 0; iterator < najax.observers.length; iterator ++) {

		najax.invokeMethod(najax.observers[iterator], eventMethod, notifyArguments);
	}

	return true;
};