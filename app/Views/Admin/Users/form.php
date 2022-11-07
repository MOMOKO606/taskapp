<div>
    <label for="name">Name</label>
    <!--old()表示上次输入的表单， esc()表示过滤掉含有代码的危险输入。    -->
    <input type="text" name="name" id="name" value="<?= old('name', esc($user->name)) ?>">
</div>

<div>
    <label for="email">email</label>
    <input type="text" name="email" id="email" value="<?= old('email', esc($user->email)) ?>">
</div>

<div>
    <label for="password">Password</label>
    <input type="password" name="password">
    <?php if ($user->id): ?>
        <p>Leave blank to keep existing password</p>
    <?php endif; ?>
</div>

<div>
    <label for="password_confirmation">Repeat password</label>
    <input type="password" name="password_confirmation">
</div>
<div>
    <label for="is_active">
        <?php if ($user->id == current_user()->id): ?>
            <input type="checkbox" checked disabled> active

        <?php else: ?>

            <input type="hidden" name="is_active" value="0">

            <input type="checkbox" id="is_active" name="is_active" value="1"
                   <?php if (old('is_active', $user->is_active)): ?>checked<?php endif; ?>> active
        <?php endif; ?>
    </label>
</div>
<div>
    <label for="is_admin">
        <?php if ($user->id == current_user()->id): ?>
            <input type="checkbox" checked disabled> administrator

        <?php else: ?>
            <!--小技巧：让checkbox不打勾时传回值。    -->
            <input type="hidden" name="is_admin" value="0">
            <!--检查展示用户是否是admin user并给出default值        -->
            <input type="checkbox" id="is_admin" name="is_admin" value="1"
                   <?php if (old('is_admin', $user->is_admin)): ?>checked<?php endif; ?>> administrator
        <?php endif; ?>
    </label>
</div>



