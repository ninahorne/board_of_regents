const searchClient = algoliasearch("L1FLYTXGGK", "65d958e57e130f9ab14bfa0dfa0123f1");

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
    container: "#searchbox",
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

const useful_links_search = instantsearch({
  indexName: "dev_board-of-regents",
  searchClient,
  searchFunction(helper) {
    // Ensure we only trigger a search when there's a query
    if (helper.state.query) {
      helper.search();
    }
  },
});


useful_links_search.addWidgets([
  instantsearch.widgets.searchBox({
    container: "#usefulCollegeLinksSearchBox",
    placeholder: 'Search for a college'
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

useful_links_search.start(); 