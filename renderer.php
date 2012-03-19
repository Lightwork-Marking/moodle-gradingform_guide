<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * @package    gradingform
 * @subpackage guide
 * @copyright  2012 Dan Marsden <dan@danmarsden.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Grading method plugin renderer
 */
class gradingform_guide_renderer extends plugin_renderer_base {

    /**
     * This function returns html code for displaying criterion. Depending on $mode it may be the
     * code to edit guide, to preview the guide, to evaluate somebody or to review the evaluation.
     *
     * This function may be called from display_guide() to display the whole guide, or it can be
     * called by itself to return a template used by JavaScript to add new empty criteria to the
     * guide being designed.
     * In this case it will use macros like {NAME}, {LEVELS}, {CRITERION-id}, etc.
     *
     * When overriding this function it is very important to remember that all elements of html
     * form (in edit or evaluate mode) must have the name $elementname.
     *
     * Also JavaScript relies on the class names of elements and when developer changes them
     * script might stop working.
     *
     * @param int $mode guide display mode @see gradingform_guide_controller
     * @param string $elementname the name of the form element (in editor mode) or the prefix for div ids (in view mode)
     * @param array|null $criterion criterion data
     * @param string $levelsstr evaluated templates for this criterion levels
     * @param array|null $value (only in view mode) teacher's feedback on this criterion
     * @return string
     */
    public function criterion_template($mode, $options, $elementname = '{NAME}', $criterion = null, $value = null) {
        if ($criterion === null || !is_array($criterion) || !array_key_exists('id', $criterion)) {
            $criterion = array('id' => '{CRITERION-id}',
                               'description' => '{CRITERION-description}',
                               'sortorder' => '{CRITERION-sortorder}',
                               'class' => '{CRITERION-class}',
                               'descriptionmarkers' => '{CRITERION-descriptionmarkers}',
                               'shortname' => '{CRITERION-shortname}',
                               'maxscore' => '{CRITERION-maxscore}');
        } else {
            foreach (array('sortorder', 'description', 'class', 'shortname', 'descriptionmarkers', 'maxscore') as $key) {
                // set missing array elements to empty strings to avoid warnings
                if (!array_key_exists($key, $criterion)) {
                    $criterion[$key] = '';
                }
            }
        }
        $criteriontemplate = html_writer::start_tag('tr', array('class' => 'criterion'. $criterion['class'],
            'id' => '{NAME}-criteria-{CRITERION-id}'));
        if ($mode == gradingform_guide_controller::DISPLAY_EDIT_FULL) {
            $criteriontemplate .= html_writer::start_tag('td', array('class' => 'controls'));
            foreach (array('moveup', 'delete', 'movedown') as $key) {
                $value = get_string('criterion'.$key, 'gradingform_guide');
                $button = html_writer::empty_tag('input', array('type' => 'submit',
                    'name' => '{NAME}[criteria][{CRITERION-id}]['.$key.']',
                    'id' => '{NAME}-criteria-{CRITERION-id}-'.$key, 'value' => $value, 'title' => $value, 'tabindex' => -1));
                $criteriontemplate .= html_writer::tag('div', $button, array('class' => $key));
            }
            $criteriontemplate .= html_writer::end_tag('td'); // .controls
            $criteriontemplate .= html_writer::empty_tag('input', array('type' => 'hidden',
                'name' => '{NAME}[criteria][{CRITERION-id}][sortorder]', 'value' => $criterion['sortorder']));

            $shortname = html_writer::empty_tag('input', array('type'=> 'text',
                'name' => '{NAME}[criteria][{CRITERION-id}][shortname]',  'value' => htmlspecialchars($criterion['shortname'])));
            $shortname = html_writer::tag('div', $shortname, array('class'=>'criterionname'));
            $description = html_writer::tag('textarea', htmlspecialchars($criterion['description']),
                array('name' => '{NAME}[criteria][{CRITERION-id}][description]', 'cols' => '10', 'rows' => '5'));
            $description = html_writer::tag('div', $description, array('class'=>'criteriondesc'));

            $descriptionmarkers = html_writer::tag('textarea', htmlspecialchars($criterion['descriptionmarkers']),
                array('name' => '{NAME}[criteria][{CRITERION-id}][descriptionmarkers]', 'cols' => '10', 'rows' => '5'));
            $descriptionmarkers = html_writer::tag('div', $descriptionmarkers, array('class'=>'criteriondescmarkers'));

            $maxscore = html_writer::empty_tag('input', array('type'=> 'text',
                'name' => '{NAME}[criteria][{CRITERION-id}][maxscore]', 'size' => '3',
                'value' => htmlspecialchars($criterion['maxscore'])));
            $maxscore = html_writer::tag('div', $maxscore, array('class'=>'criterionmaxscore'));
        } else {
            if ($mode == gradingform_guide_controller::DISPLAY_EDIT_FROZEN) {
                $criteriontemplate .= html_writer::empty_tag('input', array('type' => 'hidden',
                    'name' => '{NAME}[criteria][{CRITERION-id}][sortorder]', 'value' => $criterion['sortorder']));
                $criteriontemplate .= html_writer::empty_tag('input', array('type' => 'hidden',
                    'name' => '{NAME}[criteria][{CRITERION-id}][shortname]', 'value' => $criterion['shortname']));
                $criteriontemplate .= html_writer::empty_tag('input', array('type' => 'hidden',
                    'name' => '{NAME}[criteria][{CRITERION-id}][description]', 'value' => $criterion['description']));
                $criteriontemplate .= html_writer::empty_tag('input', array('type' => 'hidden',
                    'name' => '{NAME}[criteria][{CRITERION-id}][descriptionmarkers]', 'value' => $criterion['descriptionmarkers']));
                $criteriontemplate .= html_writer::empty_tag('input', array('type' => 'hidden',
                    'name' => '{NAME}[criteria][{CRITERION-id}][maxscore]', 'value' => $criterion['maxscore']));
            }
            $shortname   = html_writer::tag('div', $criterion['shortname'],
                array('class'=>'criterionshortname', 'name' => '{NAME}[criteria][{CRITERION-id}][shortname]'));
            $description = html_writer::tag('div', $criterion['description'],
                array('class'=>'criteriondescription', 'name' => '{NAME}[criteria][{CRITERION-id}][descriptionmarkers]'));
            $descriptionmarkers   = html_writer::tag('div', $criterion['descriptionmarkers'],
                array('class'=>'criteriondescriptionmarkers', 'name' => '{NAME}[criteria][{CRITERION-id}][descriptionmarkers]'));
            $maxscore   = html_writer::tag('div', $criterion['maxscore'],
                array('class'=>'criteriondescriptionmarkers', 'name' => '{NAME}[criteria][{CRITERION-id}][maxscore]'));
        }
        $descriptionclass = 'description';
        if (isset($criterion['error_description'])) {
            $descriptionclass .= ' error';
        }

        $displayremark = ($mode != gradingform_guide_controller::DISPLAY_VIEW);
        $title = html_writer::tag('label', get_string('criterion', 'gradingform_guide'),
            array('for'=>'{NAME}[criteria][{CRITERION-id}][shortname]', 'class' => 'criterionnamelabel'));
        $title .= $shortname;
        if ($mode == gradingform_guide_controller::DISPLAY_EDIT_FULL ||
            $mode == gradingform_guide_controller::DISPLAY_PREVIEW) {
            $title .= html_writer::tag('label', get_string('descriptionstudents', 'gradingform_guide'),
                array('for'=>'{NAME}[criteria][{CRITERION-id}][description]'));
            $title .= $description;
            $title .= html_writer::tag('label', get_string('descriptionmarkers', 'gradingform_guide'),
                array('for'=>'{NAME}[criteria][{CRITERION-id}][descriptionmarkers]'));
            $title .= $descriptionmarkers;
            $title .=  html_writer::tag('label', get_string('maxscore', 'gradingform_guide'),
                array('for'=>'{NAME}[criteria][{CRITERION-id}][maxscore]'));
            $title .= $maxscore;
        } else if ($mode == gradingform_guide_controller::DISPLAY_PREVIEW_GRADED ||
                   $mode == gradingform_guide_controller::DISPLAY_VIEW) {
            $title .= $description;
        } else {
            $title .= $descriptionmarkers;
        }
        $criteriontemplate .= html_writer::tag('td', $title, array('class' => $descriptionclass,
            'id' => '{NAME}-criteria-{CRITERION-id}-shortname'));

        if ($displayremark) {
            $currentremark = '';
            $currentscore = '';
            if (isset($value['remark'])) {
                $currentremark = $value['remark'];
            }
            if (isset($value['score'])) {
                $currentscore = $value['score'];
            }
            if ($mode == gradingform_guide_controller::DISPLAY_EVAL) {
                $input = html_writer::tag('textarea', htmlspecialchars($currentremark),
                    array('name' => '{NAME}[criteria][{CRITERION-id}][remark]', 'cols' => '45', 'rows' => '5',
                          'class' => 'markingguideremark'));
                $criteriontemplate .= html_writer::tag('td', $input, array('class' => 'remark'));
                $score = html_writer::tag('label', get_string('score', 'gradingform_guide'),
                    array('for'=>'{NAME}[criteria][{CRITERION-id}][score]'));
                $score .= html_writer::empty_tag('input', array('type'=> 'text',
                    'name' => '{NAME}[criteria][{CRITERION-id}][score]',
                    'size' => '3', 'value' => htmlspecialchars($currentscore)));
                $score .= '/'.$maxscore;

                $criteriontemplate .= html_writer::tag('td', $score, array('class' => 'score'));
            } else if ($mode == gradingform_guide_controller::DISPLAY_EVAL_FROZEN) {
                $criteriontemplate .= html_writer::empty_tag('input', array('type' => 'hidden',
                    'name' => '{NAME}[criteria][{CRITERION-id}][remark]', 'value' => $currentremark));
            } else if ($mode == gradingform_guide_controller::DISPLAY_REVIEW ||
                $mode == gradingform_guide_controller::DISPLAY_VIEW) {
                $criteriontemplate .= html_writer::tag('td', $currentremark, array('class' => 'remark'));
                if (!empty($options['showmarkspercriterionstudents'])) {
                    $criteriontemplate .= html_writer::tag('td', htmlspecialchars($currentscore). ' / '.$maxscore, array('class' => 'score'));
                }
            }
        }
        $criteriontemplate .= html_writer::end_tag('tr'); // .criterion

        $criteriontemplate = str_replace('{NAME}', $elementname, $criteriontemplate);
        $criteriontemplate = str_replace('{CRITERION-id}', $criterion['id'], $criteriontemplate);
        return $criteriontemplate;
    }

    /**
     * This function returns html code for displaying criterion. Depending on $mode it may be the
     * code to edit guide, to preview the guide, to evaluate somebody or to review the evaluation.
     *
     * This function may be called from display_guide() to display the whole guide, or it can be
     * called by itself to return a template used by JavaScript to add new empty criteria to the
     * guide being designed.
     * In this case it will use macros like {NAME}, {LEVELS}, {CRITERION-id}, etc.
     *
     * When overriding this function it is very important to remember that all elements of html
     * form (in edit or evaluate mode) must have the name $elementname.
     *
     * Also JavaScript relies on the class names of elements and when developer changes them
     * script might stop working.
     *
     * @param int $mode guide display mode @see gradingform_guide_controller
     * @param string $elementname the name of the form element (in editor mode) or the prefix for div ids (in view mode)
     * @param array|null $criterion criterion data
     * @param string $levelsstr evaluated templates for this criterion levels
     * @param array|null $value (only in view mode) teacher's feedback on this criterion
     * @return string
     */
    public function comment_template($mode, $elementname = '{NAME}', $comment = null) {
        if ($comment === null || !is_array($comment) || !array_key_exists('id', $comment)) {
            $comment = array('id' => '{COMMENT-id}',
                'description' => '{COMMENT-description}',
                'sortorder' => '{COMMENT-sortorder}',
                'class' => '{COMMENT-class}');
        } else {
            foreach (array('sortorder', 'description', 'class') as $key) {
                // set missing array elements to empty strings to avoid warnings
                if (!array_key_exists($key, $comment)) {
                    $criterion[$key] = '';
                }
            }
        }
        $criteriontemplate = html_writer::start_tag('tr', array('class' => 'criterion'. $comment['class'],
            'id' => '{NAME}-comments-{COMMENT-id}'));
        if ($mode == gradingform_guide_controller::DISPLAY_EDIT_FULL) {
            $criteriontemplate .= html_writer::start_tag('td', array('class' => 'controls'));
            foreach (array('moveup', 'delete', 'movedown') as $key) {
                $value = get_string('comments'.$key, 'gradingform_guide');
                $button = html_writer::empty_tag('input', array('type' => 'submit',
                    'name' => '{NAME}[comments][{COMMENT-id}]['.$key.']', 'id' => '{NAME}-comments-{COMMENT-id}-'.$key,
                    'value' => $value, 'title' => $value, 'tabindex' => -1));
                $criteriontemplate .= html_writer::tag('div', $button, array('class' => $key));
            }
            $criteriontemplate .= html_writer::end_tag('td'); // .controls
            $criteriontemplate .= html_writer::empty_tag('input', array('type' => 'hidden',
                'name' => '{NAME}[comments][{COMMENT-id}][sortorder]', 'value' => $comment['sortorder']));
            $description = html_writer::tag('textarea', htmlspecialchars($comment['description']),
                array('name' => '{NAME}[comments][{COMMENT-id}][description]', 'cols' => '10', 'rows' => '5'));
            $description = html_writer::tag('div', $description, array('class'=>'criteriondesc'));
        } else {
            if ($mode == gradingform_guide_controller::DISPLAY_EDIT_FROZEN) {
                $criteriontemplate .= html_writer::empty_tag('input', array('type' => 'hidden',
                    'name' => '{NAME}[comments][{COMMENT-id}][sortorder]', 'value' => $comment['sortorder']));
                $criteriontemplate .= html_writer::empty_tag('input', array('type' => 'hidden',
                    'name' => '{NAME}[comments][{COMMENT-id}][description]', 'value' => $comment['description']));
            }
            if ($mode == gradingform_guide_controller::DISPLAY_EVAL) {
                $description = html_writer::tag('span', htmlspecialchars($comment['description']),
                    array('name' => '{NAME}[comments][{COMMENT-id}][description]', 'title' => get_string('clicktocopy', 'gradingform_guide'),
                          'id' => '{NAME}[comments][{COMMENT-id}]', 'class'=>'markingguidecomment'));
            } else {
                $description = $comment['description'];
            }
        }
        $descriptionclass = 'description';
        if (isset($comment['error_description'])) {
            $descriptionclass .= ' error';
        }
        $criteriontemplate .= html_writer::tag('td', $description, array('class' => $descriptionclass,
            'id' => '{NAME}-comments-{COMMENT-id}-description'));
        $criteriontemplate .= html_writer::end_tag('tr'); // .criterion

        $criteriontemplate = str_replace('{NAME}', $elementname, $criteriontemplate);
        $criteriontemplate = str_replace('{COMMENT-id}', $comment['id'], $criteriontemplate);
        return $criteriontemplate;
    }
    /**
     * This function returns html code for displaying guide template (content before and after
     * criteria list). Depending on $mode it may be the code to edit guide, to preview the guide,
     * to evaluate somebody or to review the evaluation.
     *
     * This function is called from display_guide() to display the whole guide.
     *
     * When overriding this function it is very important to remember that all elements of html
     * form (in edit or evaluate mode) must have the name $elementname.
     *
     * Also JavaScript relies on the class names of elements and when developer changes them
     * script might stop working.
     *
     * @param int $mode guide display mode @see gradingform_guide_controller
     * @param string $elementname the name of the form element (in editor mode) or the prefix for div ids (in view mode)
     * @param string $criteriastr evaluated templates for this guide's criteria
     * @return string
     */
    protected function guide_template($mode, $options, $elementname, $criteriastr, $commentstr) {
        $classsuffix = ''; // CSS suffix for class of the main div. Depends on the mode
        switch ($mode) {
            case gradingform_guide_controller::DISPLAY_EDIT_FULL:
                $classsuffix = ' editor editable';
                break;
            case gradingform_guide_controller::DISPLAY_EDIT_FROZEN:
                $classsuffix = ' editor frozen';
                break;
            case gradingform_guide_controller::DISPLAY_PREVIEW:
            case gradingform_guide_controller::DISPLAY_PREVIEW_GRADED:
                $classsuffix = ' editor preview';
                break;
            case gradingform_guide_controller::DISPLAY_EVAL:
                $classsuffix = ' evaluate editable';
                break;
            case gradingform_guide_controller::DISPLAY_EVAL_FROZEN:
                $classsuffix = ' evaluate frozen';
                break;
            case gradingform_guide_controller::DISPLAY_REVIEW:
                $classsuffix = ' review';
                break;
            case gradingform_guide_controller::DISPLAY_VIEW:
                $classsuffix = ' view';
                break;
        }

        $guidetemplate = html_writer::start_tag('div', array('id' => 'guide-{NAME}',
            'class' => 'clearfix gradingform_guide'.$classsuffix));
        $guidetemplate .= html_writer::tag('table', $criteriastr, array('class' => 'criteria', 'id' => '{NAME}-criteria'));
        if ($mode == gradingform_guide_controller::DISPLAY_EDIT_FULL) {
            $value = get_string('addcriterion', 'gradingform_guide');
            $input = html_writer::empty_tag('input', array('type' => 'submit', 'name' => '{NAME}[criteria][addcriterion]',
                'id' => '{NAME}-criteria-addcriterion', 'value' => $value, 'title' => $value));
            $guidetemplate .= html_writer::tag('div', $input, array('class' => 'addcriterion'));
        }

        if (!empty($commentstr)) {
            $guidetemplate .= html_writer::tag('label', get_string('comments', 'gradingform_guide'),
                array('for' => '{NAME}-comments', 'class' => 'commentheader'));
            $guidetemplate .= html_writer::tag('table', $commentstr, array('class' => 'comments', 'id' => '{NAME}-comments'));
        }
        if ($mode == gradingform_guide_controller::DISPLAY_EDIT_FULL) {
            $value = get_string('addcomment', 'gradingform_guide');
            $input = html_writer::empty_tag('input', array('type' => 'submit', 'name' => '{NAME}[comments][addcomment]',
                'id' => '{NAME}-comments-addcomment', 'value' => $value, 'title' => $value));
            $guidetemplate .= html_writer::tag('div', $input, array('class' => 'addcomment'));
        }

        $guidetemplate .= $this->guide_edit_options($mode, $options);
        $guidetemplate .= html_writer::end_tag('div');

        return str_replace('{NAME}', $elementname, $guidetemplate);
    }

    /**
     * Generates html template to view/edit the guide options. Expression {NAME} is used in
     * template for the form element name
     *
     * @param int $mode
     * @param array $options
     * @return string
     */
    protected function guide_edit_options($mode, $options) {
        if ($mode != gradingform_guide_controller::DISPLAY_EDIT_FULL
            && $mode != gradingform_guide_controller::DISPLAY_EDIT_FROZEN
            && $mode != gradingform_guide_controller::DISPLAY_PREVIEW) {
            // Options are displayed only for people who can manage
            return;
        }
        $html = html_writer::start_tag('div', array('class' => 'options'));
        $html .= html_writer::tag('div', get_string('guideoptions', 'gradingform_guide'), array('class' => 'optionsheading'));
        $attrs = array('type' => 'hidden', 'name' => '{NAME}[options][optionsset]', 'value' => 1);
        foreach ($options as $option => $value) {
            $html .= html_writer::start_tag('div', array('class' => 'option '.$option));
            $attrs = array('name' => '{NAME}[options]['.$option.']', 'id' => '{NAME}-options-'.$option);
            switch ($option) {
                case 'sortlevelsasc':
                    // Display option as dropdown
                    $html .= html_writer::tag('span', get_string($option, 'gradingform_guide'), array('class' => 'label'));
                    $value = (int)(!!$value); // make sure $value is either 0 or 1
                    if ($mode == gradingform_guide_controller::DISPLAY_EDIT_FULL) {
                        $selectoptions = array(0 => get_string($option.'0', 'gradingform_guide'),
                            1 => get_string($option.'1', 'gradingform_guide'));
                        $valuestr = html_writer::select($selectoptions, $attrs['name'], $value, false, array('id' => $attrs['id']));
                        $html .= html_writer::tag('span', $valuestr, array('class' => 'value'));
                        // TODO add here button 'Sort levels'
                    } else {
                        $html .= html_writer::tag('span', get_string($option.$value, 'gradingform_guide'),
                            array('class' => 'value'));
                        if ($mode == gradingform_guide_controller::DISPLAY_EDIT_FROZEN) {
                            $html .= html_writer::empty_tag('input', $attrs + array('type' => 'hidden', 'value' => $value));
                        }
                    }
                    break;
                default:
                    if ($mode == gradingform_guide_controller::DISPLAY_EDIT_FROZEN && $value) {
                        $html .= html_writer::empty_tag('input', $attrs + array('type' => 'hidden', 'value' => $value));
                    }
                    // Display option as checkbox
                    $attrs['type'] = 'checkbox';
                    $attrs['value'] = 1;
                    if ($value) {
                        $attrs['checked'] = 'checked';
                    }
                    if ($mode == gradingform_guide_controller::DISPLAY_EDIT_FROZEN ||
                        $mode == gradingform_guide_controller::DISPLAY_PREVIEW) {
                        $attrs['disabled'] = 'disabled';
                        unset($attrs['name']);
                    }
                    $html .= html_writer::empty_tag('input', $attrs);
                    $html .= html_writer::tag('label', get_string($option, 'gradingform_guide'), array('for' => $attrs['id']));
                    break;
            }
            $html .= html_writer::end_tag('div'); // .option
        }
        $html .= html_writer::end_tag('div'); // .options
        return $html;
    }

    /**
     * This function returns html code for displaying guide. Depending on $mode it may be the code
     * to edit guide, to preview the guide, to evaluate somebody or to review the evaluation.
     *
     * It is very unlikely that this function needs to be overriden by theme. It does not produce
     * any html code, it just prepares data about guide design and evaluation, adds the CSS
     * class to elements and calls the functions level_template, criterion_template and
     * guide_template
     *
     * @param array $criteria data about the guide design
     * @param int $mode guide display mode @see gradingform_guide_controller
     * @param string $elementname the name of the form element (in editor mode) or the prefix for div ids (in view mode)
     * @param array $values evaluation result
     * @return string
     */
    public function display_guide($criteria, $comments, $options, $mode, $elementname = null, $values = null) {
        $criteriastr = '';
        $commentstr = '';
        $cnt = 0;
        foreach ($criteria as $id => $criterion) {
            $criterion['class'] = $this->get_css_class_suffix($cnt++, count($criteria) -1);
            $criterion['id'] = $id;
            if (isset($values['criteria'][$id])) {
                $criterionvalue = $values['criteria'][$id];
            } else {
                $criterionvalue = null;
            }
            $criteriastr .= $this->criterion_template($mode, $options, $elementname, $criterion, $criterionvalue);
        }
        $cnt = 0;
        $commentstr = '';
        //check if comments should be displayed
        if ($mode == gradingform_guide_controller::DISPLAY_EDIT_FULL ||
            $mode == gradingform_guide_controller::DISPLAY_PREVIEW ||
            $mode == gradingform_guide_controller::DISPLAY_EVAL ||
            $mode == gradingform_guide_controller::DISPLAY_EVAL_FROZEN) {

            foreach ($comments as $id => $comment) {
                $comment['id'] = $id;
                $comment['class'] = $this->get_css_class_suffix($cnt++, count($comments) -1);
                $commentstr  .= $this->comment_template($mode, $elementname, $comment);
            }
        }
        return $this->guide_template($mode, $options, $elementname, $criteriastr, $commentstr);
    }

    /**
     * Help function to return CSS class names for element (first/last/even/odd) with leading space
     *
     * @param int $idx index of this element in the row/column
     * @param int $maxidx maximum index of the element in the row/column
     * @return string
     */
    protected function get_css_class_suffix($idx, $maxidx) {
        $class = '';
        if ($idx == 0) {
            $class .= ' first';
        }
        if ($idx == $maxidx) {
            $class .= ' last';
        }
        if ($idx%2) {
            $class .= ' odd';
        } else {
            $class .= ' even';
        }
        return $class;
    }

    /**
     * Displays for the student the list of instances or default content if no instances found
     *
     * @param array $instances array of objects of type gradingform_rubric_instance
     * @param string $defaultcontent default string that would be displayed without advanced grading
     * @param boolean $cangrade whether current user has capability to grade in this context
     * @return string
     */
    public function display_instances($instances, $defaultcontent, $cangrade) {
        $return = '';
        if (count($instances)) {
            $return .= html_writer::start_tag('div', array('class' => 'advancedgrade'));
            $idx = 0;
            foreach ($instances as $instance) {
                $return .= $this->display_instance($instance, $idx++, $cangrade);
            }
            $return .= html_writer::end_tag('div');
        }
        return $return. $defaultcontent;
    }

    /**
     * Displays one grading instance
     *
     * @param gradingform_rubric_instance $instance
     * @param int idx unique number of instance on page
     * @param boolean $cangrade whether current user has capability to grade in this context
     */
    public function display_instance(gradingform_guide_instance $instance, $idx, $cangrade) {
        $criteria = $instance->get_controller()->get_definition()->guide_criteria;
        $options = $instance->get_controller()->get_options();
        $values = $instance->get_guide_filling();
        if ($cangrade) {
            $mode = gradingform_guide_controller::DISPLAY_REVIEW;
        } else {
            $mode = gradingform_guide_controller::DISPLAY_VIEW;
        }

        $output = $this->box($instance->get_controller()->get_formatted_description(), 'gradingform_guide-description').
                  $this->display_guide($criteria, array(), $options, $mode, 'guide'.$idx, $values);
        return $output;
    }


    public function display_regrade_confirmation($elementname, $changelevel, $value) {
        $html = html_writer::start_tag('div', array('class' => 'gradingform_guide-regrade'));
        if ($changelevel<=2) {
            $html .= get_string('regrademessage1', 'gradingform_guide');
            $selectoptions = array(
                0 => get_string('regradeoption0', 'gradingform_guide'),
                1 => get_string('regradeoption1', 'gradingform_guide')
            );
            $html .= html_writer::select($selectoptions, $elementname.'[regrade]', $value, false);
        } else {
            $html .= get_string('regrademessage5', 'gradingform_guide');
            $html .= html_writer::empty_tag('input', array('name' => $elementname.'[regrade]', 'value' => 1, 'type' => 'hidden'));
        }
        $html .= html_writer::end_tag('div');
        return $html;
    }
    /**
     * Generates and returns HTML code to display information box about how rubric score is converted to the grade
     *
     * @param array $scores
     * @return string
     */
    public function display_guide_mapping_explained($scores) {
        $html = '';
        if (!$scores) {
            return $html;
        }
        $html .= $this->box(
            html_writer::tag('h4', get_string('guidemapping', 'gradingform_guide')).
                html_writer::tag('div', get_string('guidemappingexplained', 'gradingform_guide', (object)$scores))
            , 'generalbox rubricmappingexplained');
        return $html;
    }
}
