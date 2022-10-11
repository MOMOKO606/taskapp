<?php

namespace  App\Controllers;

class Migrate extends BaseController{
    public function getIndex(){
        //  Mimic the command line.
        $migrate = \Config\Services::migrations();
        try{
            $migrate -> latest();
            echo("migrated");

        }catch (\Exception $e){
            echo $e -> getMessage();
        }
    }
}
