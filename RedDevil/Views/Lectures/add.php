<?php /** @var \RedDevil\InputModels\Lecture\LectureInputModel $model */
use RedDevil\ViewHelpers\ActionLink;
use RedDevil\ViewHelpers\CSFRToken;
use RedDevil\ViewHelpers\DateField;
use RedDevil\ViewHelpers\DateTimeField;
use RedDevil\ViewHelpers\Form;
use RedDevil\ViewHelpers\Label;
use RedDevil\ViewHelpers\SubmitButton;
use RedDevil\ViewHelpers\TextArea;
use RedDevil\ViewHelpers\TextField;
?>

<div class="col-md-7">
    <h2>Add Lecture</h2>
    <ul>
        <?php foreach($model->getErrors() as $error) :?>
            <li>
                <?php echo $error->getMessage(); ?>
            </li>
        <?php  endforeach;  ?>
    </ul>
    <?php
    $form = new Form('add-lecture-form', 'lectures/add/' . $model->getConferenceId());
    $form->setAttribute('method', 'post');
    $form->setAttribute('action', '/lectures/add/' . $model->getConferenceId());

    $form->addTextField(TextField::create()
        ->setAttribute('class', 'form-control')
        ->setAttribute('id', 'title')
        ->addLabel('Title', true)
        ->setAttribute('name', 'title'));
    $form->addLabel(Label::create()
        ->setNewLineAfter(false)
        ->setData("Description")
        ->setAttribute('class', 'control-label')
        ->setAttribute('for', 'description')
    );
    $form->addTextArea(TextArea::create()
        ->setAttribute('class', 'form-control')
        ->setAttribute('id', 'description')
        ->setAttribute('name', 'description'));
    $form->addDateTimeField(DateTimeField::create()
        ->setAttribute('class', 'form-control')
        ->setAttribute('id', 'startDate')
        ->addLabel('Start date', true)
        ->setAttribute('name', 'startDate'));
    $form->addDateTimeField(DateTimeField::create()
        ->setAttribute('class', 'form-control')
        ->setAttribute('id', 'endDate')
        ->addLabel('End date', true)
        ->setAttribute('name', 'endDate'));
    $form->addTextField(TextField::create()
        ->setAttribute('hidden', 'hidden')
        ->setAttribute('name', 'conferenceId')
        ->setAttribute('value', $model->getConferenceId())
    );
    $form->addSubmitButton(SubmitButton::create()
        ->setAttribute('class', 'btn btn-default')
        ->setNewLineAfter(false)
        ->setAttribute('value', 'Create'));
    $form->addActionLink(ActionLink::create()
        ->setNewLineBefore(false)
        ->setAttribute('id', 'cancel')
        ->setAttribute('href', '/conferences/details/' . $model->getConferenceId())
        ->setData('Cancel')
        ->setAttribute('class', 'btn btn btn-primary'));
    $form->addCSRFToken(CSFRToken::create()
        ->setAttribute('name', 'ValidationToken'));
    $form->render();
    ?>
</div>