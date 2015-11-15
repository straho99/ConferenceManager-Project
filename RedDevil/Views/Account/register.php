<?php /** @var \RedDevil\InputModels\Account\RegisterInputModel $model */?>
<h2>Register</h2>

<div class="row">
    <div class="form-group">
        <?php
        use RedDevil\ViewHelpers\ActionLink;
        use RedDevil\ViewHelpers\CSFRToken;
        use RedDevil\ViewHelpers\Form;
        use RedDevil\ViewHelpers\PasswordField;
        use RedDevil\ViewHelpers\SubmitButton;
        use RedDevil\ViewHelpers\TextField;

        $form = new Form('register-form', 'home/index');
        $form->setAttribute('method', 'post');
        $form->setAttribute('action', '/account/register');

        $form->addTextField(TextField::create()
            ->setAttribute('class', 'form-control')
            ->setAttribute('id', 'username')
            ->addLabel('Username', true)
            ->setAttribute('name', 'username'));
        $form->addTextField(TextField::create()
            ->setAttribute('class', 'form-control')
            ->setAttribute('id', 'email')
            ->addLabel('Email', true)
            ->setAttribute('name', 'email'));
        $form->addTextField(TextField::create()
            ->setAttribute('class', 'form-control')
            ->setAttribute('id', 'fullname')
            ->addLabel('Full name', true)
            ->setAttribute('name', 'fullname'));
        $form->addTextField(TextField::create()
            ->setAttribute('class', 'form-control')
            ->setAttribute('id', 'telephone')
            ->addLabel('Telephone', true)
            ->setAttribute('name', 'telephone'));
        $form->addPasswordField(PasswordField::create()
            ->setAttribute('class', 'form-control')
            ->setAttribute('id', 'password')
            ->addLabel('Password', true)
            ->setAttribute('name', 'password'));
        $form->addPasswordField(PasswordField::create()
            ->setAttribute('class', 'form-control')
            ->setAttribute('id', 'confirmPassword')
            ->addLabel('Confirm password', true)
            ->setAttribute('name', 'confirmPassword'));
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