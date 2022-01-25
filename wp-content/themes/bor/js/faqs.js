var faqs_search;
var openFirstResultTimer;
let isFirstRender = true;
document.addEventListener("DOMContentLoaded", setInitialStateFromQueryParams);

initializeAlgolia();




function openFirstResult() {
	openFirstResultTimer = setTimeout(() => {
		const results = document.querySelector('.faq__result__question');
		results.click();
	}, 500);

}


function initializeAlgolia() {
	faqs_search = instantsearch({
		indexName: "faqs",
		searchClient,
		searchFunction(helper) {
			if (!isFirstRender) {
				setQueryParams(helper.state);
			}
			clearTimeout(openFirstResultTimer);
			helper.search();
			openFirstResult();
			isFirstRender = false;
		},
	});

	// Create the render function
	const renderHits = (renderOptions, isFirstRender) => {
		const {
			hits,
			widgetParams
		} = renderOptions;
		widgetParams.container.innerHTML = `

  ${hits
	.map(
	  (item) =>
		`<div class="faq__result">
			<div onclick="toggleFAQ('${item.objectID}-FAQ')" class="row cursor-pointer">
				<div class="col-11">
					<h3  class="faq__result__question">
						${instantsearch.highlight({
							attribute: "what_is_the_faq",
							hit: item,
						})}
					</h3>
				</div>
				<div class="col-1">
					<div class="flex-vertical-center">
						<i id="${item.objectID}-FAQ-icon" class="color-orange fa fa-chevron-up"></i>
					</div>
				</div>
			</div>
			<div id="${item.objectID}-FAQ" class="faq__result__answer">
				${htmlEntities(item.what_is_the_answer)}
			</div>
		  </div>
		`
	)
	.join("")}
`;
	};

	// Create the custom widget
	const faqCustomHits = instantsearch.connectors.connectHits(renderHits);


	// Create the render function
	const renderMenu = (renderOptions, isFirstRender) => {
		const {
			items,
			refine
		} = renderOptions;

		const container = document.querySelector('#faqTags');
		container.innerHTML = `
			<div class="row">
				${items.map(item => `
							<div class="col-md-6 mt-2">
								<h6 class="${item.isRefined ? 'selected' : ''}">
									<a class="unformatted" data-value="${item.value}">
										${item.label}
									</a> 
								</h6>
							</div>`
						)
						.join('')}

			 </div>`;

		[...container.querySelectorAll('a')].forEach(element => {
			element.addEventListener('click', event => {
				event.preventDefault();
				refine(event.currentTarget.dataset.value);
			});
		});
	};

	const faqCustomMenu = instantsearch.connectors.connectMenu(renderMenu);


	faqs_search.addWidgets([

		instantsearch.widgets.searchBox({
			container: "#faqSearchBox",
			placeholder: "Search",
			showSubmit: true
		}),
		instantsearch.widgets.pagination({
			container: '#pagination',
		}),

		faqCustomMenu({
			container: document.querySelector('#faqTags'),
			attribute: 'tags',
			sortBy: ["name:asc"]

		}),

		faqCustomHits({
			container: document.querySelector("#faqHits"),
		})
	]);


	faqs_search.start();

}


function htmlEntities(str) {
	var returnString = String(str).replace(/<span style="font-weight: 400;">/g, '').replace(/&nbsp;/g, '<br /><br />');
	return returnString;

}

function toggleFAQ(id) {
	const faq = document.getElementById(id);
	const icon = document.getElementById(`${id}-icon`);
	faq.classList.toggle('faq__result__answer--open');
	icon.classList.toggle('fa-chevron-up');
	icon.classList.toggle('fa-chevron-down');

}

function clearParams(params) {
	window.history.replaceState(null, null, '?');
}
function setInitialStateFromQueryParams() {
	const queryParamsString = window.location.search;
	const queryObject = getQueryParamsObjectFromString(queryParamsString);
	const tags = queryObject["tags"];
	const query = queryObject["query"];
	const page = queryObject['refine'];


	if (tags) {
		const valArray = tags.split(";");
		valArray.forEach(facet => {
			faqs_search.helper.addHierarchicalFacetRefinement(
				"tags",
				facet
			);
		})

	}

	if (query) {
		faqs_search.helper.setQuery(query);
	}


	if (page) {
		faqs_search.helper.setPage(page);
	}
	faqs_search.helper.search();
}

// Functions for manually setting queries
function setQueryParams(state) {
	/** We set query params based on algolia state so that a user
	 * can share and return to this state.
	 */

	let queryParamString = '?';

	const page = state.page;

	if (page) {
		queryParamString = `${queryParamString}refine=${page}&`;
	}

	const tags = state.hierarchicalFacetsRefinements.tags.join(";");
	if (tags) {
		queryParamString = `${queryParamString}tags=${tags}&`;
	}

	const query = state.query;
	if (query) {
		queryParamString = `${queryParamString}query=${query}&`;
	}

	window.history.replaceState(null, null, queryParamString);
}

function getQueryParamsObjectFromString(queryString) {
	const withoutQuestion = queryString.replace("?", "");
	const arrayOfProps = withoutQuestion.split("&");
	const obj = arrayOfProps.reduce((obj, prop) => {
		const [key, value] = prop.split("=");
		obj[key] = decodeURIComponent(value);
		return obj;
	}, {});
	return obj;
}