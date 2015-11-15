<h2>Login</h2>

<div class="row">
    <div class="form-group">
<?php
use RedDevil\ViewHelpers\ActionLink;
use RedDevil\ViewHelpers\CSFRToken;
use RedDevil\ViewHelpers\Form;
use RedDevil\ViewHelpers\PasswordField;
use RedDevil\ViewHelpers\SubmitButton;
use RedDevil\ViewHelpers\TextField;

$form = new Form('login-form', 'home/index');
$form->setAttribute('method', 'post');
$form->setAttribute('action', '/account/login');

$form->addTextField(TextField::create()
    ->setAttribute('class', 'form-control')
    ->setAttribute('id', 'username')
    ->addLabel('Username', true)
    ->setAttribute('name', 'username'));
$form->addPasswordField(PasswordField::create()
    ->setAttribute('class', 'form-control')
    ->setAttribute('id', 'password')
    ->addLabel('Password', true)
    ->setAttribute('name', 'password'));
$form->addSubmitButton(SubmitButton::create()
    ->setAttribute('class', 'btn btn-default')
    ->setNewLineAfter(false)
    ->setData('Login'));
$form->addActionLink(ActionLink::create()
    ->setNewLineBefore(false)
    ->setAttribute('id', 'cancel')
    ->setAttribute('href', 'home/index')
    ->setData('Cancel')
    ->setAttribute('class', 'btn btn btn-primary'));
$form->addCSRFToken(CSFRToken::create()
    ->setAttribute('name', 'validation-token'));

$form->render();
?>
    </div>
</div>