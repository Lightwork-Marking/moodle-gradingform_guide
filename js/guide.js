M.gradingform_guide = {};

/**
 * This function is called for each guide on page.
 */
M.gradingform_guide.init = function(Y, options) {
    var currentfocus = null;
    var collapsedwidth = null;
    var shortwidth = null;
    Y.all('.markingguideremark').each(function (node) {
        node.on('blur', function(ev) {
            currentfocus = node;
        });
    });
    Y.all('.markingguidecomment').each(function (node) {
        node.on('click', function(ev) {
            currentfocus.setContent(currentfocus.get('innerHTML') + '\n' + node.get('innerHTML'));
            currentfocus.focus();
        });
    });

    Y.all('.showmarkerdesc input[type=radio]').each(function(node) {
        node.on('click', function(ev) {
            if (node.get('value')=='false') {
                Y.all('.criteriondescriptionmarkers').each(function(node) {
                    node.addClass('hide')
                })
            } else {
                Y.all('.criteriondescriptionmarkers').each(function(node) {
                    node.removeClass('hide')
                })
            }
        });
    })

};