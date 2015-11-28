<?php
use RedDevil\ViewHelpers\ActionLink;
use RedDevil\ViewHelpers\CSFRToken;
use RedDevil\ViewHelpers\Form;
use RedDevil\ViewHelpers\SubmitButton;
use RedDevil\ViewHelpers\TextField;
?>
<div class="col-md-9">
    <h2>Add hall</h2>

    <?php
    $form = new Form('add-hall-form', '/venues/createhall');
    $form->setAttribute('method', 'post');
    $form->setAttribute('action', '/venues/createhall');

    $form->addTextField(TextField::create()
        ->setAttribute('id', 'id')
        ->setAttribute('name', 'venueId')
        ->setAttribute('value', $model)
        ->setAttribute('hidden', 'hidden'));
    $form->addTextField(TextField::create()
        ->setAttribute('class', 'form-control')
        ->setAttribute('id', 'title')
        ->addLabel('Name', true)
        ->setAttribute('name', 'title'));
    $form->addTextField(TextField::create()
        ->setAttribute('class', 'form-control')
        ->setAttribute('id', 'capacity')
        ->addLabel('Capacity', true)
        ->setAttribute('name', 'capacity'));
    $form->addSubmitButton(SubmitButton::create()
        ->setAttribute('class', 'btn btn-default')
        ->setNewLineAfter(false)
        ->setAttribute('value', 'Create'));
    $form->addActionLink(ActionLink::create()
        ->setNewLineBefore(false)
        ->setAttribute('id', 'cancel')
        ->setAttribute('href', '/venues/own')
        ->setData('Cancel')
        ->setAttribute('class', 'btn btn btn-primary'));
    $form->addCSRFToken(CSFRToken::create()
        ->setAttribute('name', 'ValidationToken'));

    $form->render();
    ?>
</div>