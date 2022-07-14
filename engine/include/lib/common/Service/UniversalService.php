<?php

class UniversalService
{

    // Reverse of nl2br function(removing html tags) 
    public function br2nl($input) {
        return preg_replace('/<br\\s*?\/??>/i', '', $input);
    }

}
