<?php /** @var \RedDevil\ViewModels\SearchResultViewModel[] $model */ ?>
<div class="col-md-9">
    <h2>Search Results</h2>

    <div class="list-group">
        <a href="#" class="list-group-item active">
            Searching in users, conferences and venues.
            Found 
            <?php
            count($model);
            ?>
            result(s)...
        </a>

        foreach ($model as $result)
        {
            <a href="<?php echo $result->getResultUrl(); ?>" class="list-group-item"><?php echo $result->getResultText()?></a>
        }
        if (count($model) == 0)
        {
            <p style="margin-top:1%">
                <strong><em>Nothing found...</em></strong>
            </p>
        }
    </div>
</div>
