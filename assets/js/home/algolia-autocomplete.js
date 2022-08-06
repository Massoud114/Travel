import algoliasearch from "algoliasearch/lite";
import instantsearch from 'instantsearch.js';
import { connectSearchBox, connectHits } from 'instantsearch.js/es/connectors'
import '../../css/algolia-autocomplete.css'

const searchClient = algoliasearch(
	"GKEXJDWHO8",
	"f4951197020df61392b55c1ffa9ecfcf"
);
const search = instantsearch({
	indexName: "airport-codes",
	searchClient,
});

// Element instanciation
const suggestInputs = document.getElementsByClassName('suggest-input');
const searchWrappers = document.getElementsByClassName("search-input");
const autocomBoxes = document.getElementsByClassName("autocom-box");
const icons = document.getElementsByClassName("icon");
const iataValues = document.getElementsByClassName("iata");

for (let i = 0; i < 2; i++) {
	// Récupération des éléments correspondants
	let icon = icons[i]
	let searchWrapper = searchWrappers[i]
	let suggestInput = suggestInputs[i]
	let autocomBox = autocomBoxes[i]
	let iataValue = iataValues[i]


	icon.onclick = () => {
		searchWrapper.classList.remove("active");
		suggestInput.value = ""
	};

	// Create a render function
	const renderSearchBox = (renderOptions, isFirstRender) => {
		const { query, refine, clear, isSearchStalled, widgetParams } = renderOptions;

		if (isFirstRender) {
			suggestInput.addEventListener('input', event => {
				refine(event.target.value);
				searchWrapper.classList.add("active");
			});
		}
		// widgetParams.container.querySelector('input').value = query;
	};

	const renderHits = (renderOptions, isFirstRender) => {
		const { hits, widgetParams } = renderOptions;

		widgetParams.container.innerHTML = null;

		if (renderOptions.results && hits.length === 0) {
			widgetParams.container.innerHTML = `Aucun résultat trouvé pour ${renderOptions.results.query}`;
		}
		else {
			hits.map((hit) => {
				let li = document.createElement('li')
				li.innerText = `${hit.name}, ${hit.city}, ${hit.country}`;
				li.addEventListener('click', event => {
					suggestInput.value = `${hit.name}, ${hit.city}, ${hit.country}`;
					suggestInput.setAttribute("data-country", hit.country)
					iataValue.value = `${hit.code}`
					searchWrapper.classList.remove("active");
				})
				widgetParams.container.appendChild(li)
			})
		}
	};

	// Create the custom widget
	const customHits = connectHits(renderHits);

// Instantiate the custom widget
	search.addWidgets([
		customHits({
			container: autocomBox
		}),
	]);

// create custom widget
	const customSearchBox = connectSearchBox(
		renderSearchBox
	);

// instantiate custom widget
	search.addWidgets([
		customSearchBox({
			container: searchWrapper,
			showReset: false,
			autofocus: false,
		}),
	]);
}

export default search;
