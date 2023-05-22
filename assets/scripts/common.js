Inputmask.extendDefinitions({
	'A': {validator: "[а-яА-Я]", casing: "title"}
});

Inputmask.extendDefinitions({
	'Z': {validator: "[а-яА-Я\\s]"}
});

const sp = window.location.origin;
const apip = sp+'/api';

async function post(formData, fileUrl, nextFunc) {
	const requestOptions = {
		method: 'POST',
		body: formData
	};
	
	return await fetch(fileUrl, requestOptions)
		.then(response => response.json())
		.then(data => nextFunc(data))
		.catch(error => console.log(error));
}
