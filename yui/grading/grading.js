/**
 * YUI module for the grading interface of the "Random grade" grading method
 *
 * @package    gradingform
 * @subpackage random
 * @author     David Mudrak <david@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
YUI.add('moodle-gradingform_random-grading', function(Y) {

    var GRADING = function() {
        GRADING.superclass.constructor.apply(this, arguments);
    }

    Y.extend(GRADING, Y.Base, {

        initializer : function(params) {
            this.log('Initializing module', 'debug');
            var buttons = Y.all('.gradingform_random-widget-wrapper button');
            // replace the 'Loading...' label with the actual text
            buttons.each(function(button) {
                button.setContent(button.get('value'));
            });
            buttons.on('click', this.process, this);
        },

        /**
         * Logs a message
         *
         * @method log
         * @param {String} message
         * @param {String} level logging level, defaults to 'info'
         */
        log : function(message, level) {
            if (level == null) {
                level = 'info';
            }
            Y.log(message, level, 'moodle-gradingform_random-grading');
        },

        /**
         * Fires the main grading event - the user clicked the "I'm feeling lucky" button
         *
         * @method process
         * @param {Y.Event} e
         */
        process : function(e) {
            e.halt();
            var button = e.currentTarget;
            var wrapper = button.get('parentNode');
            var label = wrapper.one('span');
            var anim = new Y.Anim({
                node: label,
                from: { opacity: 0 },
                to: { opacity: 1 }
            });

            // make the AJAX request and process the response
            var ajaxurl = M.cfg.wwwroot + '/grade/grading/form/random/process.php';
            var ajaxcfg = {
                method : 'POST',
                data : { 'instance' : 36 },
                context : this,
                on : {
                    start: function(transid, args) {
                        label.setContent('<img src="' + M.cfg.loadingicon + '" />');
                        label.set('className', '');
                    },
                    success: function(transid, outcome, args) {
                        try {
                            result = Y.JSON.parse(outcome.responseText);
                        } catch(e) {
                            result = { 'success': false, 'error': 'Can not parse response' };
                        }

                        if (result.success) {
                            label.addClass('success');
                            label.setStyle('opacity', 0);
                            label.setContent(result.cookedgrade);
                            anim.run();
                        } else {
                            label.addClass('error');
                            label.setContent('Error ' + result.error);
                        }
                    },
                    failure: function(transid, outcome, args) {
                        var debuginfo = outcome.statusText;
                        if (M.cfg.developerdebug) {
                            debuginfo += ' (' + ajaxurl + ')';
                        }
                        label.addClass('error');
                        label.setContent(debuginfo);
                    }
                },
            };
            Y.io(ajaxurl, ajaxcfg);
        }

    }, {
        NAME : 'RandomGradingInterface',
        ATTRS : {
                widgetids : {value : []}
        }
    });

    M.gradingform_random = M.gradingform_random || {};

    M.gradingform_random.init_grading = function(params) {
        M.gradingform_random.GRADING = new GRADING(params);
    }

}, '@VERSION@', { requires:['base', 'io', 'anim', 'json-parse'] });
