<?php
/**
 * Class defining a report builder parameter
 *
 * A parameter is a restriction that can be applied to a report
 * by adding a certain field to the URL. If a report has a
 * parameter option enabled, then adding this to the url:
 *
 * <code>report.php?id=X&name=[value]</code>
 *
 * will add a restriction that limits the results to those with
 * the field $field equal to [value].
 *
 * @copyright Totara Learning Solutions Limited
 * @author Simon Coggins
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License
 * @package totara
 * @subpackage reportbuilder
 */
class rb_param {
    /**
     * Name for the parameter
     *
     * This is the string that must be added to the URL to activate
     * the restriction
     *
     * @access public
     * @var string
     */
    public $name;

    /**
     * Database field to apply the restriction to
     *
     * This should include the join name as a prefix, e.g:
     *
     * <code>course.fullname</code>
     *
     * @access public
     * @var string
     */
    public $field;

    /**
     * One or more join names required to access $field
     *
     * Either a string or an array of strings containing
     * names of {@link rb_join} objects that are required
     * to access the $field field
     *
     * @access public
     * @var mixed
     */
    public $joins;

    /**
     * Value of the parameter as set in the URL
     *
     * @access public
     * @var string
     */
    public $value;

    /**
     * Generate a rb_param instance
     *
     * @param string $name Name of the parameter
     * @paramoptions array Array of {@link rb_param_option}
     *                     objects to search through to
     *                     populate this object
     */
    function __construct($name, $paramoptions) {

        $this->name = $name;

        foreach($paramoptions as $paramoption) {
            if($paramoption->name == $name) {
                $this->field = $paramoption->field;
                $this->joins = $paramoption->joins;
                break;
            }
        }
    }

} // end of rb_param class