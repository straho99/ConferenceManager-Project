<?php /** @var \RedDevil\InputModels\Venue\VenueInputModel $model */
use RedDevil\ViewHelpers\ActionLink;
use RedDevil\ViewHelpers\CSFRToken;
use RedDevil\ViewHelpers\DateField;
use RedDevil\ViewHelpers\Form;
use RedDevil\ViewHelpers\SubmitButton;
use RedDevil\ViewHelpers\TextField;
?>

<div class="col-md-7">
    <h2>Add venue</h2>
    <ul>
        <?php foreach($model->getErrors() as $error) :?>
            <li>
                <?php echo $error->getMessage(); ?>
            </li>
        <?php  endforeach;  ?>
    </ul>
    <?php
    $form = new Form('add-venue-form', 'home/index');
    $form->setAttribute('method', 'post');
    $form->setAttribute('action', '/venues/add');

    $form->addTextField(TextField::create()
        ->setAttribute('class', 'form-control')
        ->setAttribute('id', 'title')
        ->addLabel('Name', true)
        ->setAttribute('name', 'title'));
    $form->addTextField(TextField::create()
        ->setAttribute('class', 'form-control')
        ->setAttribute('id', 'description')
        ->addLabel('Description', true)
        ->setAttribute('name', 'description'));
    $form->addTextField(TextField::create()
        ->setAttribute('class', 'form-control')
        ->setAttribute('id', 'address')
        ->addLabel('Address', true)
        ->setAttribute('name', 'address'));
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
