import $ from 'jquery';
import 'autocomplete.js/dist/autocomplete.jquery';
import '../../css/algolia-autocomplete.scss';

export default function($elements, dataKey, displayKey){
    $elements.each( function() {
        var autocompleteUrl = $(this).data('autocomplete-url');

        $(this).autocomplete({ hint: false }, [
        {
            source: function (query, cb) {
                $.ajax({
                    url: autocompleteUrl + '?query='+ query
                }).then(function (data) {
                    if(dataKey){
                        data = data[dataKey];
                    }
                        cb(data);
                    }
                );
            },
            displayKey: displayKey,
            debounce: 300
        }
    ]).on('autocomplete:selected', function(event, suggestion, dataset, context) {
        console.log(event, suggestion, dataset, context);
    });
    });

};
