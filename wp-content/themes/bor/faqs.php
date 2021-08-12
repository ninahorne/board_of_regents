<?php

/**
 * Template Name: FAQ's Page
 */
?>

<?php include('header.php'); ?>
<div id="content">
    <div id="faqs">
        <div class="background__blue faq__background-brush-stroke">
            <div class="container">
                <div class="p-2">
                    <h1 class="color-white">FAQs</h1>
                    <div class="row">
                        <div class="col-md-5">
                            <div class="faq__search">
                                <div class="faq__categories">
                                    <label>Categories</label>

                                    <div class="m-2">
                                        <div id="faqTags"></div>

                                    </div>
                                    <div>
                                        <div id="faqSearchBox"></div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-7">
                            <div id="faqHits"></div>
                            <div id="pagination"></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>




<?php include('footer.php'); ?>
<script>
    var faqs_search;
    var openFirstResultTimer;

    initializeAlgolia();
    checkForQueryParamsAndOpenModal();

    function checkForQueryParamsAndOpenModal() {
        const queryParams = window.location.search;

        if (queryParams) {
            const faq = queryParams.replace('?question=', '');
            const input = document.querySelector('#faqSearchBox .ais-SearchBox-input');
            var decodedFAQ = decodeURI(faq);
            decodedFAQ = decodedFAQ.replace(/%3F/g,' ').replace(/%2F/g, ' ');
            input.value = decodedFAQ;
            faqs_search.helper.state.query = decodedFAQ;
            faqs_search.helper.search();
            clearParams();


        }
    }
 
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
                // Ensure we only trigger a search when there's a query
                // const container = document.querySelector("#faqResults");
                clearTimeout(openFirstResultTimer);
                helper.search();
                openFirstResult();

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
                <div class="row">
                    <div class="col-11">
                        <h3 onclick="toggleFAQ('${item.objectID}-FAQ')" class="faq__result__question">
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
                attribute: 'categories',
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
</script>