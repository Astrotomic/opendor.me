/**
 * Do not run this script or any other loadtest ones against opendor.me
 * This script is only here to be used by authorized people.
 *
 * In case you aren't sure if you are authorized - don't use it.
 * It's 99.999% likely that you aren't if you don't know.
 */

import http from 'k6/http';
import {check, sleep} from 'k6';

Array.prototype.random = function () {
    return this.sort(() => 0.5 - Math.random())[Math.floor(Math.random() * this.length)];
};

export let options = {
    stages: [
        {duration: '30s', target: 100},

        {duration: '10s', target: 150},
        {duration: '2m', target: 150},

        {duration: '10s', target: 200},
        {duration: '5m', target: 200},

        {duration: '10s', target: 225},
        {duration: '5m', target: 225},

        {duration: '10s', target: 200},
        {duration: '5m', target: 200},

        {duration: '30s', target: 0},
    ],
};

export default function () {
    let url = [
        'https://opendor.me/',
        'https://opendor.me/',
        'https://opendor.me/',
        'https://opendor.me/',
        'https://opendor.me/',
        'https://opendor.me/',
        'https://opendor.me/',
        'https://opendor.me/',
        'https://opendor.me/',
        'https://opendor.me/',
        'https://opendor.me/faqs',
        'https://opendor.me/faqs',
        'https://opendor.me/sponsors',
        'https://opendor.me/sponsors',
        'https://opendor.me/@Gummibeer',
        'https://opendor.me/@Gummibeer',
        'https://opendor.me/@Gummibeer',
        'https://opendor.me/@Gummibeer',
        'https://opendor.me/@Astrotomic',
        'https://opendor.me/@Astrotomic',
        'https://opendor.me/@Astrotomic',
        'https://opendor.me/@Astrotomic',
    ].random();

    let res = http.get(url);

    check(res, {
        'is status 200': (r) => r.status === 200,
    });

    sleep(1);
}
