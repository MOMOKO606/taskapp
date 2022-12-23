<h1><?= lang('Signup.activation') ?></h1>

<p><?= lang('Signup.activation_message') ?></p>

<!--链接跳转回Signup controller，token是输入参数-->
<p><a href="<?= site_url("/signup/activate/$token") ?>"><?= lang('Signup.activate_link') ?></a></p>
