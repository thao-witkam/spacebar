import $ from 'jquery';
import Dropzone from 'dropzone';
import 'dropzone/dist/dropzone.css';

import Sortable from 'sortable';
import autocomplete from './components/algolia-autocomplete';


Dropzone.autoDiscover = false;


$(document).ready(function () {
    const $autoComplete = $('.js-user-autocomplete');
    if(!$autoComplete.is(':disabled')){
        autocomplete($autoComplete, 'users', 'email');
    }

    var locationSelect = $('.js-article-form-location');
    var specificLocationTarget = $('.js-specific-location-target');

    locationSelect.on('change', function (e) {
        $.ajax({
            url: locationSelect.data('specific-location-url'),
            data: {
                location: locationSelect.val()
            },
            success: function (html) {
                if (!html) {
                    specificLocationTarget.find('select').remove();
                    specificLocationTarget.addClass('d-none');
                    return;
                }

                specificLocationTarget.html(html)
                    .removeClass('d-none');
            }
        });
    });
});