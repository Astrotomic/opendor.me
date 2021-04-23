import '@ryangjchandler/alpine-clipboard';
import 'alpinejs';

window.components = {};

import algoliasearch from 'algoliasearch/lite';
import instantsearch from 'instantsearch.js';
import { connectAutocomplete } from 'instantsearch.js/es/connectors'
import { searchBox, stats, hits, refinementList, currentRefinements, hitsPerPage, pagination } from 'instantsearch.js/es/widgets'

window.algolia = {
    searchClient: algoliasearch(window.ALGOLIA_ID, window.ALGOLIA_KEY),
    instantsearch,
    connectors: {
        connectAutocomplete,
    },
    widgets: {
        searchBox,
        stats,
        hits,
        refinementList,
        currentRefinements,
        hitsPerPage,
        pagination,
    }
};
