import '@ryangjchandler/alpine-clipboard';
import 'alpinejs';

window.components = {};

import algoliasearch from 'algoliasearch/lite';
import instantsearch from 'instantsearch.js';
import { connectAutocomplete } from 'instantsearch.js/es/connectors'

window.algolia = {
    searchClient: algoliasearch(window.ALGOLIA_ID, window.ALGOLIA_KEY),
    instantsearch,
    connectors: {
        connectAutocomplete,
    }
};
