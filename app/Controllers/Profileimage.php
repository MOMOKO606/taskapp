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


        $size = $file->getSizeByUnit('mb');

        if ($size > 2) {

            return redirect()->back()
                ->with('warning', 'File too large (max 2MB)');
        }

        $type = $file->getMimeType();
        // 用in_array来判断$type是不是png或jpeg的。
        if ( ! in_array($type, ['image/png', 'image/jpeg'])) {

            return redirect()->back()
                ->with('warning', 'Invalid file format (PNG or JPEG only)');
        }
        //  设定上传文件的上层文件夹名。
        $path = $file->store('profile_images');
        //  得到上传文件的完整路径。
        $path = WRITEPATH . 'uploads/' . $path;
        //  用image class调整图片大小。
        service('image')
            ->withFile($path)
            ->fit(200, 200, 'center')
            ->save($path);

        $user = service('auth')->getCurrentUser();
        //  找到文件名并把他存到user中
        $user->profile_image = $file->getName();

        $model = new \App\Models\UserModel;
        //  再把user更新到model中
        //  如果不想添加model config中的allowedfields，则用临时禁用protect的方法。
        $model->protect(false)
            ->save($user);

        return redirect()->to("/profile/show")
            ->with('info', 'Image uploaded successfully');
    }

    //  从show点击delete，跳转到前端确认界面。
    public function getDelete()
    {
        return view('Profileimage/delete');
    }

    //  前端确认删除 / 取消，做相应处理并跳转回来。
    public function postDelete()
    {
        if ($this->request->getMethod() === 'post') {

            $user = service('auth')->getCurrentUser();

            $path = WRITEPATH . 'uploads/profile_images/' . $user->profile_image;

            if (is_file($path)) {

                unlink($path);
            }

            $user->profile_image = null;

            $model = new \App\Models\UserModel;

            $model->protect(false)
                ->save($user);

            return redirect()->to('/profile/show')
                ->with('info', 'Image deleted');
        }
    }
}


