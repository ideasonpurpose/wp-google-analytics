<?php

namespace ideasonpurpose;

// mock WP's add_action for testing. Calls whatever function is passed
function add_action($tag, $function_to_add, $priority = 10, $accepted_args = 1)
{
    return call_user_func($function_to_add);
}

$logged_in = true;

function is_user_logged_in()
{
    global $logged_in;
    return $logged_in;
}
