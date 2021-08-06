const searchClient = algoliasearch(
  "L1FLYTXGGK",
  "65d958e57e130f9ab14bfa0dfa0123f1"
);


		
initializeHeaderAlgolia();
			

function initializeHeaderAlgolia() {

  const search = instantsearch({
    indexName: "dev_board-of-regents",
    searchClient,
    searchFunction(helper) {
      // Ensure we only trigger a search when there's a query
      if (helper.state.query) {
        helper.search();
      }
    },
  });

  search.addWidgets([
    instantsearch.widgets.searchBox({
      container: "#algoliaSearch",
    }),

    instantsearch.widgets.refinementList({
      container: "#tags-list",
      attribute: "tags",
      limit: 5,
      showMore: true,
    }),

    instantsearch.widgets.hits({
      container: "#hits",
      templates: {
        item: `
          <article>
            <a href="{{ url }}">
            <strong>
              {{#helpers.highlight}}
              { "attribute": "title", "highlightedTagName": "mark" }
              {{/helpers.highlight}}
            </strong>
            </a>
            {{#content}}
            <p>{{#helpers.snippet}}{ "attribute": "content", "highlightedTagName": "mark" }{{/helpers.snippet}}</p>
            {{/content}}
          </article>
          `,
      },
    }),
  ]);

  search.start();
}
