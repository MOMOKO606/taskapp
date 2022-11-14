<?= $this->extend('layouts/default') ?>

<?= $this->section('title') ?>Profile<?= $this->endSection() ?>

<?= $this->section('content') ?>

<h1>Profile</h1>

<?php if ($user->profile_image): ?>

    <img src="<?= site_url('/profile/image') ?>" width="200" height="200" alt="profile image">

    <a href="<?= site_url('/profileimage/delete') ?>">Delete profile image</a>

<?php else: ?>
<!--如果用户没传头像，则显示public/images/下的默认头像-->
<!--    <img src="--><?//= site_url('images/blank_profile.png') ?><!--" width="200" height="200" alt="profile image">-->
    <!--如果用户没传头像，调用https://robohash.org/，根据用户名hash出一个随机头像-->
    <img src="https://robohash.org/YOUR-TEXT.png" width="200" height="200" alt="profile image" >

<?php endif; ?>

<dl>
    <dt>Name</dt>
    <dd><?= esc($user->name) ?></dd>

    <dt>email</dt>
    <dd><?= esc($user->email) ?></dd>
</dl>

<a href="<?= site_url("/profile/edit") ?>">Edit</a>

<a href="<?= site_url("/profile/editpassword") ?>">Change password</a>

<a href="<?= site_url("/profileimage/edit") ?>">Change profile image</a>

<?= $this->endSection() ?>
