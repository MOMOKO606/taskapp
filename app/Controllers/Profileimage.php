<?php

namespace App\Controllers;

class Profileimage extends BaseController
{
    public function getEdit()
    {
        return view('Profileimage/edit');
    }

    public function postUpdate()
    {
        $file = $this->request->getFile('image');

        if ( ! $file->isValid()) {

            $error_code = $file->getError();

            if ($error_code == UPLOAD_ERR_NO_FILE) {

                return redirect()->back()
                    ->with('warning', 'No file selected');
            }

            throw new \RuntimeException($file->getErrorString() . " " . $error_code);

        }
    }
}


