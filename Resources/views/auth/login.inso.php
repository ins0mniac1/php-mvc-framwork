<?php
use App\Core\form\Form;
use App\Models\Auth\User;

/** @var User $model */
/** @var $errors */

if (empty($errors)) {
    $errors = null;
}

?>

<div class="w-50 mx-auto mt-5 underline">
    <h2>
        Login to your account:
    </h2>
</div>

<?php $form = Form::begin('', 'w-50 mx-auto mt-5') ;?>
<?php $form->setErrors($errors) ;?>
<?= $form->inputField($model, 'Email', 'email',  'email') ;?>
<?= $form->inputField($model,  'Password', 'password', 'password') ;?>
<?= $form->button('Login', 'submit', 'btn btn-primary') ;?>
<?= Form::end() ;?>
