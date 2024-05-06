// https://stackoverflow.com/questions/3034874/sequencing-ajax-requests/3035268
/*
 * jQuery.ajaxQueue - A queue for ajax requests
 *
 * (c) 2011 Corey Frang
 * Dual licensed under the MIT and GPL licenses.
 *
 * Requires jQuery 1.5+
 */
(function ($) {
    // jQuery on an empty object, we are going to use this as our Queue
    var ajaxQueue = $({});

    $.ajaxQueue = function (ajaxOpts) {
        var jqXHR,
            dfd = $.Deferred(),
            promise = dfd.promise();

        // queue our ajax request
        ajaxQueue.queue(doRequest);

        // add the abort method
        promise.abort = function (statusText) {
            // proxy abort to the jqXHR if it is active
            if (jqXHR) {
                return jqXHR.abort(statusText);
            }

            // if there wasn't already a jqXHR we need to remove from queue
            var queue = ajaxQueue.queue(),
                index = $.inArray(doRequest, queue);

            if (index > -1) {
                queue.splice(index, 1);
            }

            // and then reject the deferred
            dfd.rejectWith(ajaxOpts.context || ajaxOpts, [promise, statusText, ""]);

            return promise;
        };

        // run the actual query
        function doRequest(next) {
            // if (typeof ajaxOpts.data !== "undefined") ajaxOpts.data[CSRF_NAME] = $("#csrf_hash").val(); // von mir hinzugefügt (27.12.2022)
            ajaxOpts.data[CSRF_NAME] = CSRF[CSRF_NAME]; // von mir hinzugefügt (02.11.2023)
            ajaxOpts.data.ajax_id = ajaxOpts.ajax_id; // von mir hinzugefügt (18.11.2023)
            jqXHR = $.ajax(ajaxOpts).done(dfd.resolve).fail(dfd.reject).then(next, next);
        }

        return promise;
    };
})(jQuery);
