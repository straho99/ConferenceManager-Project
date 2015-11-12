        <?php

        namespace SoftUni\Models;

        class Role
        {
	const COL_ID = 'id';
	const COL_TITLE = 'title';

	private $id;
	private $title;

	public function __construct($title, $id = null)
	{
		$this->setId($id);
		$this->setTitle($title);
	}

	/**
	* @return mixed
	*/
	public function getId()
	{
		return $this->id;
	}

	/**
	* @param $id
	* @return $this
	*/
	public function setId($id)
	{
		$this->id = $id;
		
		return $this;
	}


	/**
	* @return mixed
	*/
	public function getTitle()
	{
		return $this->title;
	}

	/**
	* @param $title
	* @return $this
	*/
	public function setTitle($title)
	{
		$this->title = $title;
		
		return $this;
	}

}