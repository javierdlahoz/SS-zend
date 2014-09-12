<?php

namespace Application\Facade;

class ApplicationFacade {

    public function getSuccessResponse(){
        return array(
            "success" => true
        );
    }

}