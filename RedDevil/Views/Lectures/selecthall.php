<?php /** @var \RedDevil\ViewModels\AddHallViewModel[] $model */
use RedDevil\ViewHelpers\CSFRToken;
use RedDevil\ViewHelpers\Form;
use RedDevil\ViewHelpers\SubmitButton;
use RedDevil\ViewHelpers\TextField;
?>

<div class="col-md-5">
    <h2>Select Hall</h2>
    <?php foreach($model as $hall) : ?>
        <div class="panel panel-default">
            <div class="panel-body">
                <?php
                echo '<strong>Hall: </strong>' . $hall->getHallTitle();
                echo "<br/>";
                echo '<strong>With capacity: </strong>' . $hall->getCapacity();
                ?>

                <?php
                $form = new Form('select-hall-form', '/lectures/addhall');
                $form->setAttribute('method', 'post');
                $form->setAttribute('class', 'pull-right');
                $form->setNewLineAfter(false);
                $form->setNewLineBefore(false);
                $form->setAttribute('action', '/lectures/addhall');

                $form->addTextField(TextField::create()
                    ->setAttribute('id', 'hallId')
                    ->setAttribute('name', 'hallId')
                    ->setAttribute('hidden', 'hidden')
                    ->setNewLineAfter(false)
                    ->setNewLineBefore(false)
                    ->setAttribute('value', $hall->getHallId()));
                $form->addTextField(TextField::create()
                    ->setAttribute('id', 'lectureId')
                    ->setAttribute('name', 'lectureId')
                    ->setAttribute('hidden', 'hidden')
                    ->setNewLineAfter(false)
                    ->setNewLineBefore(false)
                    ->setAttribute('value', $hall->getLectureId()));
                $form->addTextField(TextField::create()
                    ->setAttribute('id', 'conferenceId')
                    ->setAttribute('name', 'conferenceId')
                    ->setAttribute('hidden', 'hidden')
                    ->setNewLineAfter(false)
                    ->setNewLineBefore(false)
                    ->setAttribute('value', $hall->getConferenceId()));
                $form->addSubmitButton(SubmitButton::create()
                    ->setAttribute('class', 'btn btn-success')
                    ->setNewLineAfter(false)
                    ->setNewLineBefore(false)
                    ->setAttribute('value', 'Select'));
                $form->addCSRFToken(CSFRToken::create()
                    ->setNewLineAfter(false)
                    ->setNewLineBefore(false)
                    ->setAttribute('name', 'ValidationToken'));
                $form->render();
                ?>
            </div>
        </div>
    <?php endforeach; ?>
    </div>

