<?php

namespace App\Controllers;

use App\Core\Form;

class UsersController extends Controller
{
    public function login(){
        $form = new Form();

        $form->startForm()
            ->addLabelFor('email', 'Email :')
            ->addInput('email', 'email', ['class' => 'form-control', 'id' => 'email'])
            ->addLabelFor('pass', 'Mot de passe')
            ->addInput('password', 'password', ['id' => 'pass', 'class' => 'form-control'])
            ->addButton('Me connecter', ['class' => 'btn btn-primary mt-3'])
            ->endForm();

        $this->render('users/login', ['loginForm' => $form->create()]);
    }
}