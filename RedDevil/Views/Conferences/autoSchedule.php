<?php /** @var \RedDevil\ViewModels\LectureViewModel[][] $model */
use RedDevil\ViewHelpers\ActionLink;
use RedDevil\ViewHelpers\CSFRToken;
use RedDevil\ViewHelpers\Form;
use RedDevil\ViewHelpers\SubmitButton;
use RedDevil\ViewHelpers\TextField;

?>

<div class="col-md-9">
    <?php
    $i = 1;
    ?>
    <table class="table">
        <thead>
        <?php foreach ($model as $scenario): ?>
            <tr>
                <th>Option #<?php echo $i++ ?></th>
            </tr>
        <?php endforeach; ?>
        </thead>
        <tbody>
        <td>
            <?php foreach ($model as $scenario): ?>
            <?php
            $form = new Form('batch-book-form', '/conferences/batchBook');
            $form->setAttribute('method', 'POST');
            $form->setAttribute('action', '/conferences/batchBook');
            $form->addSubmitButton(SubmitButton::create()
                ->setAttribute('value', 'Book All')
                ->setAttribute('class', 'btn btn-info btn-sm')
            );
            foreach ($scenario as $lecture) {
                $form->addTextField(TextField::create()
                    ->setAttribute('hidden', 'hidden')
                    ->setAttribute('value', $lecture->getId())
                    ->setAttribute('name', 'lectureIds[]'));
                echo "<strong>" . $lecture->getTitle() . "</strong>";
                echo "<br/>";
                echo $lecture->getStartDate();
                echo "<br/>";
                echo $lecture->getEndDate();
                echo "<br/>";
                echo "<br/>";
            }
            $form->addCSRFToken(CSFRToken::create()
                ->setAttribute('name', 'ValidationToken'));
            $form->render();
            ?>

        </td>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>