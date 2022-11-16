<?php
use App\Core\form\Form;
use App\Models\Home\Contact;

/** @var Contact $model */
/** @var $errors */

if (empty($errors)) {
    $errors = null;
}

?>

<div class="w-50 mx-auto mt-5 underline">
    <h2>
        Contact to us:
    </h2>
</div>

<?php $form = Form::begin('', 'w-50 mx-auto mt-5') ;?>
<?php $form->setErrors($errors) ;?>
<?= $form->inputField($model, 'Subject', 'subject',  'text') ;?>
<?= $form->inputField($model, 'Enter your email', 'sender',  'email') ;?>
<?= $form->textareaField($model,  'Message', 'about') ;?>
<?= $form->button('Send', 'submit', 'btn btn-primary') ;?>
<?= Form::end() ;?>
