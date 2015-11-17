<?php /** @var \RedDevil\InputModels\Conference\ConferenceInputModel $model */
use RedDevil\ViewHelpers\ActionLink;
use RedDevil\ViewHelpers\CSFRToken;
use RedDevil\ViewHelpers\DateField;
use RedDevil\ViewHelpers\Form;
use RedDevil\ViewHelpers\Label;
use RedDevil\ViewHelpers\SubmitButton;
use RedDevil\ViewHelpers\TextArea;
use RedDevil\ViewHelpers\TextField;
?>

<div class="col-md-7">
    <h2>Add conference</h2>
    <ul>
        <?php foreach($model->getErrors() as $error) :?>
            <li>
                <?php echo $error->getMessage(); ?>
            </li>
        <?php  endforeach;  ?>
    </ul>
    <?php
    $form = new Form('add-conference-form', 'home/index');
    $form->setAttribute('method', 'post');
    $form->setAttribute('action', '/conferences/add');

    $form->addTextField(TextField::create()
        ->setAttribute('class', 'form-control')
        ->setAttribute('id', 'title')
        ->addLabel('Title', true)
        ->setAttribute('name', 'title'));
    $form->addDateField(DateField::create()
        ->setAttribute('class', 'form-control')
        ->setAttribute('id', 'startDate')
        ->addLabel('Start date', true)
        ->setAttribute('name', 'startDate'));
    $form->addDateField(DateField::create()
        ->setAttribute('class', 'form-control')
        ->setAttribute('id', 'endDate')
        ->addLabel('End date', true)
        ->setAttribute('name', 'endDate'));
    $form->addSubmitButton(SubmitButton::create()
        ->setAttribute('class', 'btn btn-default')
        ->setNewLineAfter(false)
        ->setAttribute('value', 'Create'));
    $form->addActionLink(ActionLink::create()
        ->setNewLineBefore(false)
        ->setAttribute('id', 'cancel')
        ->setAttribute('href', '/conferences/own')
        ->setData('Cancel')
        ->setAttribute('class', 'btn btn btn-primary'));
    $form->addCSRFToken(CSFRToken::create()
        ->setAttribute('name', 'ValidationToken'));

    $form->render();
    ?>
</div>
