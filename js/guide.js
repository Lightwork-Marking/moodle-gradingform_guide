M.gradingform_guide = {};

/**
 * This function is called for each guide on page.
 */
M.gradingform_guide.init = function(Y, options) {
    var currentfocus = null;
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
    Y.all('.criteria .markingguideremark').each( function(node) {M.gradingform_guide.editmode(node, false)} );

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

// switch the criterion item to edit mode or switch back
M.gradingform_guide.editmode = function(el, editmode) {
    var ta = el
        // if we need to show the input fields, set the width/height for textarea so it fills the cell
    try {
        if (ta.get('name').indexOf('[score]') > 1) {
            ta.setStyle('width', '25px');
        } else {
            var width = parseFloat(ta.get('parentNode').getComputedStyle('width'))-10,
                height = parseFloat(ta.get('parentNode').getComputedStyle('height'))
            ta.setStyle('width', Math.max(width,50)+'px')
            ta.setStyle('height', Math.max(height,20)+'px')
        }
    }
    catch (err) {
        // this browser do not support 'computedStyle', leave the default size of the textbox
    }
}