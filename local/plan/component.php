<?php

require_once(dirname(dirname(dirname(__FILE__))).'/config.php');
require_once($CFG->dirroot.'/local/plan/lib.php');
require_once($CFG->dirroot.'/local/js/lib/setup.php');


//
// Load parameters
//
$id = required_param('id', PARAM_INT); // plan id
$componentname = required_param('c', PARAM_ALPHA); // component type
$submitted = optional_param('submitbutton', null, PARAM_TEXT); // form submitted


//
// Load plan, component and check permissions
//
$plan = new development_plan($id);

if (!dp_can_view_users_plans($plan->userid)) {
    print_error('error:nopermissions', 'local_plan');
}

$component = $plan->get_component($componentname);


//
// Perform actions
//
if($submitted && confirm_sesskey()) {
    $component->process_settings_update();
}

$component->process_action_hook();


//
// Display header
//
$component->pre_header_hook();

$currenttab = $componentname;
$navlink = array('name' => get_string($component->component.'plural', 'local_plan'), 'link' => '', 'type' => 'title');
$is_component = true;
include($CFG->dirroot.'/local/plan/header.php');

print $component->display_picker();

print '<form id="dp-component-update" action="'.$component->get_url().'" method="POST">';
print '<input type="hidden" id="sesskey" name="sesskey" value="'.sesskey().'" />';

print '<div id="dp-component-update-table">'.$component->display_list().'</div>';

if ($component->can_update_settings(LP_CHECK_ITEMS_EXIST)) {
    $show = true;
}
else {
    $show = false;
}

print '<div id="dp-component-update-submit" style="display: '.($show ? 'block' : 'none').';"><input type="submit" name="submitbutton" value="'.get_string('updatesettings', 'local_plan').'" /></div>';

print '</form>';
print_container_end();

print <<<HEREDOC
<script type="text/javascript">

    $(function() {
        $('[id^=duedate_{$componentname}]').datepicker(
            {
                dateFormat: 'dd/mm/y',
                showOn: 'button',
                buttonImage: '{$CFG->wwwroot}/local/js/images/calendar.gif',
                buttonImageOnly: true
            }
        );
    });
</script>
HEREDOC;

print_footer();