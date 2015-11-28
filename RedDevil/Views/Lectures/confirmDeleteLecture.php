<div class="col-md-7">
    <form action="<?php echo '/lectures/' . $model['lectureId'] . '/delete'; ?>" method="POST">
        <?php
        \RedDevil\ViewHelpers\CSFRToken::create()->setAttribute('name', 'ValidationToken')->render();
        ?>
        <h4>Are you sure you want to delete the lecture?</h4>
        <input type="submit" class="btn btn-danger" value="Delete"/>
        <a href="<?php echo '/conferences/details/' . $model['conferenceId']; ?>" class="btn btn-info">Cancel</a>
    </form>
</div>