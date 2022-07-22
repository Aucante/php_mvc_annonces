<?php

namespace App\Controllers;

use App\Core\Form;
use App\Models\AdsModel;
use App\Models\UsersModel;

class AdsController extends Controller
{
    public function index()
    {
        $adsModel = new AdsModel();

        $ads = $adsModel->findAll();

        $this->render('ads/index', compact('ads'));
    }

    /**
     * @param int $id $id Id de l'annonce
     * $return void
     */
    public function read(int $id)
    {
        $adsModel = new AdsModel();

        $ad = $adsModel->findById($id);

        $this->render('ads/read', compact('ad'));
    }

    public function add()
    {
        if (isset($_SESSION['user']) && !empty($_SESSION['user']['email'])){

            if (Form::validate($_POST, ['title', 'description'])){
                // Form is full
                // Protect against XSS attacks
                // Strips-tags removes html code
                $title = strip_tags($_POST['title']);
                $description = strip_tags($_POST['description']);
                // Recuperate user
                $userModel = new UsersModel();
                $user = $userModel->findOneByEmail(strip_tags($_SESSION['user']['email']));
                $userModel->hydrate($user);

                $ad = new AdsModel();
                $ad->setTitle($title)
                    ->setDescription($description)
                    ->setUsersId($userModel->getId())
                    ->setActive(true)
                ;

                $ad->create();

                // Redirect
                $_SESSION['message'] = "Votre annonce a été ajoutée avec succès";
                header('Location: /');
                exit();
            }else{

            }

            $form = new Form();

            $form->startForm()
                ->addLabelFor('title', 'Titre de l\'annonce')
                ->addInput('text', 'title', ['id' => 'titre', 'class' => 'form-control'])
                ->addLabelFor('description', 'Texte de l\'annonce')
                ->addInput('text', 'description', ['id' => 'description', 'class' => 'form-control'])
                ->addButton('Valider', ['class' => 'btn btn-primary mt-2'])
            ;
            $this->render('ads/add', ['form' => $form->create()]);
        }else{
            $_SESSION['error'] = "Vous devez être connecté pour accéder à cette page";
            header("Location: /users/login");
            exit();
        }
    }
}