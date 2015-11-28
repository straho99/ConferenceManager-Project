<?php /** @var \RedDevil\ViewModels\LectureViewModel $model */ ?>
<div class="btn-group-xs" role="group" aria-label="">
    <?php
    use RedDevil\ViewHelpers\ActionLink;

    ActionLink::create()
        ->setAttribute('href', '/conferences/' . $model->getConferenceId() . '/lectures/' . $model->getId() . '/invite')
        ->setAttribute('class', 'btn btn-default')
        ->setNewLineAfter(false)
        ->setData('Invite Speaker')
        ->render();
    ActionLink::create()
        ->setAttribute('href', '/lectures/' . $model->getId() . '/halls' )
        ->setAttribute('class', 'btn btn-default')
        ->setNewLineAfter(false)
        ->setData('Select Hall')
        ->render();
    ActionLink::create()
        ->setAttribute('href', '/lectures/' . $model->getId() . '/addbreak')
        ->setAttribute('class', 'btn btn-default')
        ->setNewLineAfter(false)
        ->setData('Add Break')
        ->render();
    ActionLink::create()
        ->setAttribute('href', '/lectures/' . $model->getId() . '/delete/confirm')
        ->setAttribute('class', 'btn btn-danger')
        ->setNewLineAfter(true)
        ->setData('Delete Lecture')
        ->render();
    ?>
    <br/>
</div>