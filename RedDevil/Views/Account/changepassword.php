<?php /** @var \RedDevil\InputModels\Account\ChangePasswordInputModel $model */?>
<h2>Change password</h2>

<div class="row">
    <div class="form-group">
        <?php
        use RedDevil\ViewHelpers\ActionLink;
        use RedDevil\ViewHelpers\CSFRToken;
        use RedDevil\ViewHelpers\Form;
        use RedDevil\ViewHelpers\PasswordField;
        use RedDevil\ViewHelpers\SubmitButton;
        use RedDevil\ViewHelpers\TextField;

        $form = new Form('change-password-form', 'account/changePassword');
        $form->setAttribute('method', 'post');
        $form->setAttribute('action', '/account/changePassword');

        $form->addPasswordField(PasswordField::create()
            ->setAttribute('class', 'form-control')
            ->setAttribute('id', 'currentPassword')
            ->addLabel('Current password', true)
            ->setAttribute('name', 'currentPassword'));
        $form->addPasswordField(PasswordField::create()
            ->setAttribute('class', 'form-control')
            ->setAttribute('id', 'newPassword')
            ->addLabel('New password', true)
            ->setAttribute('name', 'newPassword'));
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