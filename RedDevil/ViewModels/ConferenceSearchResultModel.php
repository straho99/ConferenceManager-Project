<?php
use RedDevil\Contract\ISearchResult;
use RedDevil\Models\Conference;

class ConferenceSearchResultModel implements ISearchResult
{
    private $id;

    private $title;

    private $ownerUsername;

    private $startDate;

    private $endDate;

    public function __construct(Conference $model)
    {
        $this->id = $model->getId();
        $this->title = $model->getTitle();
        $this->startDate = $model->getStartDate();
        $this->endDate = $model->getEndDate();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getOwnerUsername()
    {
        return $this->title;
    }

    public function setOwnerUsername($ownerUsername)
    {
        $this->ownerUsername = $ownerUsername;
    }

    public function getStartDate()
    {
        return $this->startDate;
    }

    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
    }

    public function getResultText()
    {
        return "Conference titled '$this->title', organised by $this->ownerUsername, starts on $this->startDate, ends on: $this->endDate.";
    }

    public function getResultUrl()
    {
        return "/conferences/details/" . $this->Id;
    }
}
