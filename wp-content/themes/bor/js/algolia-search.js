const searchClient = algoliasearch(
  "L1FLYTXGGK",
  "65d958e57e130f9ab14bfa0dfa0123f1"
);

initializeHeaderAlgolia();

function initializeHeaderAlgolia() {
  const search = instantsearch({
    indexName: "generic-page-search",
    searchClient,
    searchFunction(helper) {
      // Ensure we only trigger a search when there's a query
      helper.search();
    },
  });

  search.addWidgets([
    instantsearch.widgets.searchBox({
      container: "#algoliaSearch",
      placeholder: "Begin typing to search...",
    }),

    instantsearch.widgets.configure({
      attributesToSnippet: ["details"]
    }),

    instantsearch.widgets.hits({
      container: "#hits",
      templates: {
        item: `
          <article>
          
            <a class="unformatted" href="{{ url_params }}">
            <h3>
            <strong>
              {{#helpers.highlight}}
              { "attribute": "title", "highlightedTagName": "mark" }
              {{/helpers.highlight}}
            </strong>
            </h3>
            </a>
            {{#details}}
              <div class="my-3">{{#helpers.snippet}}{ "attribute": "details", "highlightedTagName": "mark" }{{/helpers.snippet}}...</div>
            {{/details}}
          </article>
          `,
      },
    }),
  ]);

  search.start();
}
