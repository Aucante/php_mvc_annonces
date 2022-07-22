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
                $_SESSION['error'] = !empty($_POST) ? "Le formulaire est incomplet" : "";
                $title = isset($_POST['title']) ? strip_tags($_POST['title']) : '';
                $description = isset($_POST['description']) ? strip_tags($_POST['description']) : '';
            }

            $form = new Form();

            $form->startForm()
                ->addLabelFor('title', 'Titre de l\'annonce')
                ->addInput('text', 'title', ['id' => 'titre', 'class' => 'form-control', 'value' => $title])
                ->addLabelFor('description', 'Texte de l\'annonce')
                ->addInput('text', 'description', ['id' => 'description', 'class' => 'form-control', 'value' => $description])
                ->addButton('Valider', ['class' => 'btn btn-primary mt-2'])
            ;
            $this->render('ads/add', ['form' => $form->create()]);
        }else{
            $_SESSION['error'] = "Vous devez être connecté pour accéder à cette page";
            header("Location: /users/login");
            exit();
        }
    }

    /**
     * Update ad
     * @param int $id
     */
    public function update(int $id){
        if (isset($_SESSION['user']) && !empty($_SESSION['user']['email'])){
            $adsModel = new AdsModel();

            $ad = $adsModel->findById($id);

            if (!$ad) {
                http_response_code(404);
                $_SESSION['error'] = "L'annonce recherchée n'existe pas";
                header('Location: /ads');
                exit;
            }

            $userModel = new UsersModel();
            $user = $userModel->findOneByEmail(strip_tags($_SESSION['user']['email']));
            $userModel->hydrate($user);


            if ((int)$ad->users_id !== $userModel->getId()){
                $_SESSION['error'] = "Vous n'avez pas accès à cette page";
                header('Location: /ads');
                exit();
            }

            // Processing form
            if (Form::validate($_POST, ['title', 'description'])){
                $title = strip_tags($_POST['title']);
                $description = strip_tags($_POST['description']);

                $adEdit = new AdsModel();
                $adEdit->setId($ad->id)
                    ->setTitle($title)
                    ->setDescription($description);

                $adEdit->update();

                // Redirect
                $_SESSION['message'] = "Votre annonce a été ajoutée avec succès";
                header('Location: /');
                exit();
            }


            $form = new Form();

            $form->startForm()
                ->addLabelFor('title', 'Titre de l\'annonce')
                ->addInput('text', 'title', ['id' => 'titre', 'class' => 'form-control', 'value' => $ad->title] )
                ->addLabelFor('description', 'Texte de l\'annonce')
                ->addInput('text', 'description', ['id' => 'description', 'class' => 'form-control', 'value' => $ad->description])
                ->addButton('Valider', ['class' => 'btn btn-primary mt-2'])
            ;

            $this->render('ads/update', ['form' => $form->create()]);

        }else{
            $_SESSION['erreur'] = "Vous devez vous connecter pour ajouter une annonce";
            header('Location: /users/login');
            exit;
        }
    }
}