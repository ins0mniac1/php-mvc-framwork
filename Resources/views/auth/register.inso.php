<?php
use App\Core\form\Form;
use App\Models\Auth\User;

/** @var User $model */
/** @var $errors */

if (empty($errors)) {
    $errors = null;
}

?>

<div class="w-50 mx-auto mt-5">
    <h2>
        Register for free:
    </h2>
</div>


<?php $form = Form::begin('', 'w-50 mx-auto mt-5') ;?>
    <?php $form->setErrors($errors) ;?>
    <div class="d-flex justify-content-between gap-5    ">
        <div class="w-50 mr-2">
            <?= $form->inputField($model, 'Firstname', 'firstname') ;?>
        </div>
        <div class="w-50 ml-2">
            <?= $form->inputField($model, 'Lastname', 'lastname') ;?>
        </div>
    </div>
    <?= $form->inputField($model, 'Email', 'email',  'email') ;?>
    <?= $form->inputField($model,  'Password', 'password', 'password') ;?>
    <?= $form->inputField($model,  'Confirm Password', 'confirmPassword', 'password') ;?>
    <?= $form->button('Register', 'submit', 'btn btn-primary') ;?>
<?= Form::end() ;?>
