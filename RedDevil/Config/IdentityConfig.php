<?php

namespace RedDevil\Config;

class IdentityConfig {

    const UPDATE_IDENTITY = true;

    const CURRENT_USER_MODEL = "\\RedDevil\\Core\\Identity\\IdentityUser";

    public static $DEFAULT_USER_ROLES = array(
        'user',
        'conferenceOwner',
        'venueOwner',
        'admin'
    );
}