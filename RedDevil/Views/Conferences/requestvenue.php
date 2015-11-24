<?php /** @var \RedDevil\ViewModels\VenueRequestViewModel[] $model */
use RedDevil\ViewHelpers\CSFRToken;
use RedDevil\ViewHelpers\Form;
use RedDevil\ViewHelpers\SubmitButton;
use RedDevil\ViewHelpers\TextField;

?>

<div class="col-md-4">
    <h2>Send Venue Request</h2>
    <?php
    ?>
    <div class="panel panel-default">
        <div class="panel-heading"><strong>Choose venue</strong></div>
        <ul class="list-group">
            <?php
            foreach($model as $venue) {
                $form = new Form('add-venue-request-form', '/conferences/addvenuerequest');
                $form->setAttribute('method', 'post');
                $form->setNewLineAfter(false);
                $form->setAttribute('action', '/conferences/addvenuerequest');

                $form->addTextField(TextField::create()
                    ->setAttribute('id', 'conferenceId')
                    ->setAttribute('hidden', 'hidden')
                    ->setNewLineAfter(false)
                    ->setNewLineBefore(false)
                    ->setAttribute('name', 'conferenceId')
                    ->setAttribute('value', $venue->getConferenceId()));
                $form->addTextField(TextField::create()
                    ->setAttribute('id', 'venueId')
                    ->setAttribute('name', 'venueId')
                    ->setAttribute('hidden', 'hidden')
                    ->setNewLineAfter(false)
                    ->setNewLineBefore(false)
                    ->setAttribute('value', $venue->getVenueId()));
                $form->addSubmitButton(SubmitButton::create()
                    ->setAttribute('class', 'btn btn-link')
                    ->setNewLineAfter(false)
                    ->setNewLineBefore(false)
                    ->setAttribute('value', $venue->getVenueTitle()));
                $form->addCSRFToken(CSFRToken::create()
                    ->setNewLineAfter(false)
                    ->setNewLineBefore(false)
                    ->setAttribute('name', 'ValidationToken'));

                $form->render();
            }
            ?>
        </ul>
    </div>
</div>