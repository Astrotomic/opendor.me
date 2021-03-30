import Fuse from 'fuse.js';

const AlpineFuse = {
    start() {
        if (!window.Alpine) {
            throw new Error('Alpine is required for `alpine-fuse` to work.')
        }

        Alpine.addMagicProperty('fuse', () => {
            return function (list, options) {
                if (typeof list === 'function') {
                    list = list()
                }

                return Promise.resolve(list)
                    .then(items => new Fuse(items, options));
            }
        })
    }
};

const deferrer = window.deferLoadingAlpine || ((callback) => callback());

window.deferLoadingAlpine = function (callback) {
    AlpineFuse.start();

    deferrer(callback)
};

export default AlpineFuse
