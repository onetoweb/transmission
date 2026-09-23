<?php

namespace Onetoweb\TransMission\Config;

enum BaseHref: string
{
    case STAGING = 'https://staging.trans-mission.nl/api';
    case LIVE = 'https://api.trans-mission.nl/api';
}
