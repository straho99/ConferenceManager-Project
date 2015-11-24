<?php /** @var \RedDevil\ViewModels\ConferenceDetailsViewModel $model */ ?>
<div class="btn-group" role="group" aria-label="">
    <?php
    use RedDevil\ViewHelpers\ActionLink;

    ActionLink::create()
        ->setAttribute('href', '/lectures/add/' . $model->getId())
        ->setAttribute('class', 'btn btn-default')
        ->setNewLineAfter(false)
        ->setData('Add Lecture')
        ->render();
    ActionLink::create()
        ->setAttribute('href', '/conferences/'. $model->getId() . '/requestvenue')
        ->setAttribute('class', 'btn btn-default')
        ->setNewLineAfter(false)
        ->setData('Book Venue')
        ->render();
    ActionLink::create()
        ->setAttribute('href', '/conferences/delete/' . $model->getId())
        ->setAttribute('class', 'btn btn-default')
        ->setNewLineAfter(false)
        ->setData('Delete Conference')
        ->render();
    ?>
</div>