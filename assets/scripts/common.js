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

const getSortTabel = ({ target }) => {
	const order = (target.dataset.order = -(target.dataset.order || -1));
	const index = [...target.parentNode.cells].indexOf(target);
	const collator = new Intl.Collator(['en', 'ru'], { numeric: true });
	const comparator = (index, order) => (a, b) => order * collator.compare(
		a.children[index].innerHTML,
		b.children[index].innerHTML
	);
	
	for(const tBody of target.closest('table').tBodies)
		tBody.append(...[...tBody.rows].sort(comparator(index, order)));

	for(const cell of target.parentNode.cells)
		cell.classList.toggle('sorted', cell === target);
};

document.querySelector('.table_sort thead')?.addEventListener('click', function(event) { getSortTabel(event) });
