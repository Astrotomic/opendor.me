import '@ryangjchandler/alpine-clipboard';
import './alpine/fuse';
import 'alpinejs';

window.components = {};

document.addEventListener("DOMContentLoaded", function(event) {
    if ('#newAuth' === location.hash) {
        history.pushState("", document.title, window.location.pathname + window.location.search);
    }
});
