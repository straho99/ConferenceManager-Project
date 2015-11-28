<?php
namespace RedDevil\Services;

abstract class SearchResult
{
    public abstract function getResultText();

    public abstract function getResultUrl();
}

?>