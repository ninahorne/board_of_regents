const searchClient = algoliasearch(
  "L1FLYTXGGK",
  "65d958e57e130f9ab14bfa0dfa0123f1"
);

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
  indexName: "useful-college-links",
  searchClient,
  searchFunction(helper) {
    // Ensure we only trigger a search when there's a query
    const container = document.querySelector("#usefulCollegeLinksResults");
    container.style.display = helper.state.query === "" ? "none" : "";

    helper.search();
  },
});
// Create the render function
const renderHits = (renderOptions, isFirstRender) => {
  const { hits, widgetParams } = renderOptions;

  widgetParams.container.innerHTML = `
    <form class="ais-Hits" method="POST">
      ${hits
        .map(
          (item) =>
            `<label onclick="clickMarker( \`${item.campus}\`)" class="useful-college-links__search-result">
              ${instantsearch.highlight({ attribute: "campus", hit: item })}
            </label>
            <input class="d-none" type="radio" name="postID" value="${item.objectID}" />
            `
        )
        .join("")}
    </form>
  `;
};

// Create the custom widget
const customHits = instantsearch.connectors.connectHits(renderHits);


useful_links_search.addWidgets([
  instantsearch.widgets.searchBox({
    container: "#usefulCollegeLinksSearchBox",
    placeholder: "Search for a college",
  }),

  instantsearch.widgets.refinementList({
    container: "#usefulCollegeLinksTagsList",
    attribute: "tags",
    limit: 5,
    showMore: true,
  }),

  customHits({
    container: document.querySelector("#usefulCollegeLinksHits"),

  }),
]);

useful_links_search.start();
