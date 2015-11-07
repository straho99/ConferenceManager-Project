<h1>Ajax forms test</h1>

<?php

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

$ajaxForm = new \RedDevil\ViewHelpers\AjaxForm(
    'test-form',
    '/experiment/processAjaxRequest',
    '#result-container');

$ajaxForm->addTextField(\RedDevil\ViewHelpers\TextField::create()
    ->setAttribute('name', 'username')
    ->setAttribute('id', 'username'));

$ajaxForm->addTextField(\RedDevil\ViewHelpers\PasswordField::create()
    ->setAttribute('name', 'password')
    ->setAttribute('id', 'password'));

$ajaxForm->addCheckbox(\RedDevil\ViewHelpers\CheckBox::create()
    ->setAttribute('name', 'checkbox1')
    ->setAttribute('id', 'checkbox1')
    ->setAttribute('value', 'subscribe')
    ->setData('Subscribe to our news')
);
$ajaxForm->addCheckbox(\RedDevil\ViewHelpers\CheckBox::create()
    ->setAttribute('name', 'checkbox2')
    ->setAttribute('id', 'checkbox2')
    ->setAttribute('value', 'whatever')
    ->setData('Whatever')
);

$ajaxForm->addRadioButton(\RedDevil\ViewHelpers\RadioButton::create()
    ->setAttribute('name', 'gender')
    ->setAttribute('value', 'male')
    ->setAttribute('id', 'gender')
    ->setData('Male')
    ->setNewLineBefore(true));

$ajaxForm->addRadioButton(\RedDevil\ViewHelpers\RadioButton::create()
    ->setAttribute('name', 'gender')
    ->setAttribute('value', 'female')
    ->setAttribute('id', 'female')
    ->setData('Female'));

$ajaxForm->addTextArea(\RedDevil\ViewHelpers\TextArea::create()
    ->setAttribute('name', 'area')
    ->setAttribute('id', 'area'));

$ajaxForm->addDropDown(
    \RedDevil\ViewHelpers\DropDown::create()
        ->setAttribute('name', 'people')
        ->setAttribute('id', 'dropdown')
        ->setData($people, 'age', 'name', 18)
        ->setNewLineBefore(true)
        ->setDefault('--people--')
);

$ajaxForm->addCSRFToken(
    \RedDevil\ViewHelpers\CSFRToken::create()
        ->setAttribute('name', 'ValidationToken')
        ->setAttribute('id', 'ValidationToken')
);

$ajaxForm->addButton(\RedDevil\ViewHelpers\Button::create()
    ->setAttribute('name', 'login')
    ->setAttribute('id', 'login')
    ->setAttribute('value', 'login')
    ->setData('Login'));
$ajaxForm->render();


?>

<div id="result-container">

</div>
