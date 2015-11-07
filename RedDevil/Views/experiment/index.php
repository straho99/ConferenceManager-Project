<?php

use RedDevil\ViewHelpers\UnorderedListViewHelper;
use RedDevil\ViewHelpers\LiViewHelper;


$people = [
  [
      'name' => 'gogo',
      'age' => 12
  ],
    [
        'name' => 'tosho',
        'age' => 18
    ],
    [
        'name' => 'pesho',
        'age' => 25
    ],
    [
        'name' => 'mimka',
        'age' => 33
    ],

];

$myForm = new \RedDevil\ViewHelpers\Form('my-form');
$myForm->Open();

\RedDevil\ViewHelpers\TextField::create()
    ->setAttribute('id', 'username')
    ->setAttribute('name', 'username')
    ->addLabel('Username: ')
    ->setAttribute('value', 'username')
    ->render();

\RedDevil\ViewHelpers\PasswordField::create()
    ->setAttribute('id', 'test')
    ->setData('name', 'test')
    ->addLabel('Pass: ')
    ->render();

\RedDevil\ViewHelpers\RadioButton::create()
    ->setAttribute('name', 'gender')
    ->setAttribute('value', 'male')
    ->setData('Male')
    ->setNewLineBefore(true)
    ->render();
\RedDevil\ViewHelpers\RadioButton::create()
    ->setAttribute('name', 'gender')
    ->setAttribute('value', 'female')
    ->setData('Female')
    ->render();

\RedDevil\ViewHelpers\CheckBox::create()
    ->setAttribute('name', 'vehicle')
    ->setAttribute('value', 'car')
    ->setData('Car')
    ->setNewLineBefore(true)
    ->render();
\RedDevil\ViewHelpers\CheckBox::create()
    ->setAttribute('name', 'vehicle')
    ->setAttribute('value', 'truck')
    ->setData('Truck')
    ->render();
\RedDevil\ViewHelpers\CheckBox::create()
    ->setAttribute('name', 'vehicle')
    ->setAttribute('value', 'bike')
    ->setData('Bike')
    ->render();

\RedDevil\ViewHelpers\TextArea::create()
    ->setAttribute('rows', 10)
    ->setAttribute('cols', 50)
    ->setData('Enter detailed info here')
    ->setNewLineBefore(true)
    ->render();

\RedDevil\ViewHelpers\DropDown::create()
    ->setAttribute('name', 'people')
    ->setData($people, 'age', 'name', 18)
    ->setNewLineBefore(true)
    ->setDefault('--people--')
    ->render();

$list = new \RedDevil\ViewHelpers\UnorderedListViewHelper();

foreach ($people as $person) {
    $list->addLiItem(LiViewHelper::create()
        ->setData($person['name']));
}

$list->render();

\RedDevil\ViewHelpers\SubmitButton::create()
    ->setAttribute('value', 'Enter')
    ->setNewLineBefore(true)
    ->render();

$myForm->Close();
?>