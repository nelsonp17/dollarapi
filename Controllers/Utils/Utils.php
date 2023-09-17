<?php

namespace Controllers\Utils;

use Carbon\Carbon;

class Utils {
    public function currentDate(){
        return Carbon::now();
    }
}

