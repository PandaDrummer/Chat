<?php
use yii\rbac\Rule;

class AuthorRule extends Rule
{
    public $name = 'author' ;
    public function execute($user, $item, $params)
    {
        // TODO: Implement execute() method.
    }
}