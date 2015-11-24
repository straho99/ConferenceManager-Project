<?php /** @var \RedDevil\ViewModels\SpeakerInvitationViewModel[] $model */
use RedDevil\ViewHelpers\CSFRToken;
use RedDevil\ViewHelpers\Form;
use RedDevil\ViewHelpers\SubmitButton;
use RedDevil\ViewHelpers\TextField;

?>

<div class="col-md-4">
    <h2>Send Speaker Invitation</h2>
    <?php
    ?>
    <div class="panel panel-default">
        <div class="panel-heading"><strong>Choose speaker</strong></div>
        <ul class="list-group">
            <?php
            foreach($model as $invitation) {
                $form = new Form('add-venue-request-form', '/lectures/sendinvitation');
                $form->setAttribute('method', 'post');
                $form->setNewLineAfter(false);
                $form->setAttribute('action', '/lectures/sendinvitation');

                $form->addTextField(TextField::create()
                    ->setAttribute('id', 'speakerId')
                    ->setAttribute('hidden', 'hidden')
                    ->setNewLineAfter(false)
                    ->setNewLineBefore(false)
                    ->setAttribute('name', 'speakerId')
                    ->setAttribute('value', $invitation->getSpeakerId()));
                $form->addTextField(TextField::create()
                    ->setAttribute('id', 'lectureId')
                    ->setAttribute('name', 'lectureId')
                    ->setAttribute('hidden', 'hidden')
                    ->setNewLineAfter(false)
                    ->setNewLineBefore(false)
                    ->setAttribute('value', $invitation->getLectureId()));
                $form->addTextField(TextField::create()
                    ->setAttribute('id', 'conferenceId')
                    ->setAttribute('name', 'conferenceId')
                    ->setAttribute('hidden', 'hidden')
                    ->setNewLineAfter(false)
                    ->setNewLineBefore(false)
                    ->setAttribute('value', $invitation->getConferenceId()));
                $form->addSubmitButton(SubmitButton::create()
                    ->setAttribute('class', 'btn btn-link')
                    ->setNewLineAfter(false)
                    ->setNewLineBefore(false)
                    ->setAttribute('value', $invitation->getSpeakerUserName()));
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