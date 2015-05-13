<?php

namespace Insa\Guests\Models;

use Jenssegers\Mongodb\Model;

class Invite extends Model
{
    public $dates = ['lastInvite'];
}
