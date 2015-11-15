<?php

namespace RedDevil\Config;

class IdentityConfig {

    const UPDATE_IDENTITY = false;

    const CURRENT_USER_MODEL = "\\RedDevil\\Core\\Identity\\CMUser";

    public static $DEFAULT_USER_ROLES = array(
        'user',
        'conferenceOwner',
        'venueOwner',
        'admin'
    );
}