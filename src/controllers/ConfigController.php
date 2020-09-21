<?php
namespace src\controllers;

use \core\Controller;
use \src\handlers\UserHandler;

class ConfigController extends Controller {

    private $loggedUser;

    public function __construct() {
        $this->loggedUser = UserHandler::checkLogin();
        if($this->loggedUser === false){
            $this->redirect('/login');
        }
    }

    public function index($atts = []) {
      $flash = '';
      if(!empty($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        $_SESSION['flash'] = '';
      }
        //Detectando o usuario acessado
        $id = $this->loggedUser->id;
        if(!empty($atts['id'])) {
          $id = $atts['id'];
        }

        //Pegando informação do usuario
        $user = UserHandler::getUser($id, true);
        if(!$user) {
          $this->redirect('/');
        }



      $this->render('config', [
        'loggedUser' => $this->loggedUser,
        'user'=>$user,
        'flash'=>$flash
      ]);
    }
    
    public function update() {
      $nome = filter_input(INPUT_POST, 'nome');
      $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
      $birthdate = filter_input(INPUT_POST, 'birthdate');
      $password = filter_input(INPUT_POST, 'password');
      $passwordConfirm = filter_input(INPUT_POST, 'passwordConfirm');
      $city = filter_input(INPUT_POST, 'city');
      $work = filter_input(INPUT_POST, 'work');

        if(isset($birthdate) && !empty($birthdate)) {

          $birthdate = explode('/', $birthdate);
          if(count($birthdate) != 3){
                  $_SESSION['flash'] = 'Data de nascimento inválida!';
                  $this->redirect('/config');
          }
          $birthdate = $birthdate[2].'-'.$birthdate[1].'-'.$birthdate[0];
          if(strtotime($birthdate) === false){
                  $_SESSION['flash'] = 'Data de nascimento inválida!';
                  $this->redirect('/config');               
          }
        }

        if(isset($password) && !empty($password) && isset($passwordConfirm) && !empty($passwordConfirm)) {
          if($password != $passwordConfirm) {
            $_SESSION['flash'] = 'Senhas divergentes!';
            $this->redirect('/config');
          }
        } 
        
        // Avatar
        if(isset($_FILES['avatar']) && !empty($_FILES['avatar']['tmp_name'])) {
          $newAvatar = $_FILES['avatar'];

          if(in_array($newAvatar['type'], ['image/jpeg', 'image/png', 'image/jpg'])) {
            $avatarName = $this->cutImage($newAvatar, 200, 200, 'media/avatars');
            $avatar = $avatarName;
          }
        }

        //Cover
        if(isset($_FILES['cover']) && !empty($_FILES['cover']['tmp_name'])) {
          $newCover = $_FILES['cover'];

          if(in_array($newCover['type'], ['image/jpeg', 'image/png', 'image/jpg'])) {
            $coverName = $this->cutImage($newCover, 820, 310, 'media/covers');
            $cover = $coverName;
          }
        }

        UserHandler::updateUser($nome, $birthdate, $email, $city, $work, $password, $avatar, $cover, $this->loggedUser->id );

        $this->redirect('/config');
    }

    private function cutImage($file, $w, $h, $folder) {
      list($widthOrig, $heightOrig) = getimagesize($file['tmp_name']);
      $ratio = $widthOrig / $heightOrig;

      $newWidth = $w;
      $newHeight = $newWidth / $ratio;

      if($newHeight < $h) {
        $newHeight = $h;
        $newWidth = $newHeight * $ratio;
      }

      $x = $w - $newWidth;
      $y = $h - $newHeight;
      $x = $x < 0 ? $x /2 : $x;
      $y = $y < 0 ? $y /2 : $y;

      $finalImage = imagecreatetruecolor($w, $h);
      switch($file['type']) {
        case 'image/jpeg':
        case 'image/jpg':
          $image = imagecreatefromjpeg($file['tmp_name']);
          break;
        case 'image/png':
          $image = imagecreatefrompng($file['tmp_name']);
          break;
      }

      imagecopyresampled(
        $finalImage,
        $image,
        $x, $y, 0, 0,
        $newWidth, $newHeight,
        $widthOrig, $heightOrig
      );

      $fileName = md5(time().rand(0,9999)).'.jpg';

      imagejpeg($finalImage, $folder.'/'.$fileName);

      return $fileName;

    }
}