<?php /** @var \RedDevil\ViewModels\LectureViewModel $model */ ?>
<div class="btn-group" role="group" aria-label="">
    <?php
    use RedDevil\ViewHelpers\ActionLink;

    ActionLink::create()
        ->setAttribute('href', '/conferences/' . $model->getConferenceId() . '/lectures/' . $model->getId() . '/invite')
        ->setAttribute('class', 'btn btn-default')
        ->setNewLineAfter(false)
        ->setData('Invite Speaker')
        ->render();
    ActionLink::create()
        ->setAttribute('href', '/lectures/addbreak')
        ->setAttribute('class', 'btn btn-default')
        ->setNewLineAfter(false)
        ->setData('Add Break')
        ->render();
    ActionLink::create()
        ->setAttribute('href', '/lectures/delete')
        ->setAttribute('class', 'btn btn-default')
        ->setNewLineAfter(false)
        ->setData('Delete Lecture')
        ->render();
    ?>
</div>