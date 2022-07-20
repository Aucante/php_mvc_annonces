<?php

namespace App\Controllers;

use App\Core\Form;
use App\Models\UsersModel;

class UsersController extends Controller
{

    /**
     * Connection users
     */
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

    /**
     * Registration users
     */
    public function registration()
    {
        if (Form::validate($_POST, ['email', 'password'])){
            $email = strip_tags($_POST['email']);
            $pass = password_hash($_POST['password'], PASSWORD_ARGON2I);

            $user = new UsersModel();

            $user->setEmail($email)
                ->setPassword($pass);

            $user->create();
        }

        $form = new Form();

        $form->startForm()
            ->addLabelFor('email', 'E-mail :')
            ->addInput('email', 'email', ['class' => 'form-control', 'id' => 'email'])
            ->addLabelFor('pass', 'Mot de passe :')
            ->addInput('password', 'password', ['id' => 'pass', 'class' => 'form-control'])
            ->addButton('M\'inscrire', ['class' => 'btn btn-primary'])
            ->endForm();

        $this->render('users/registration', ['registerForm' => $form->create()]);
    }
}