<?php

namespace Repository;

use Core\Model;
use Core\Repository;
use Model\Token;
use Model\User;

class UserRepository extends Repository {
  protected static $nameModel = User::class;

  public function checkUser(string $email, string $password): ?User {
    return $this->model
      ->select('*')
      ->where('email', '=', $email)
      ->where('password', '=', md5($password))
      ->findOne();
  }

  public function register($payload) {
    return $this->model->insert($payload);
  }

  public function getByEmail(string $email): ?User {
    return $this->model
      ->select("*")
      ->where("email", "=", $email)
      ->findOne();
  }
  public function getById(string $id): ?User {
    return $this->model
      ->select("*")
      ->where("id", "=", $id)
      ->findOne();
  }
  public function resetPassword($id, $password) {
    TokenRepository::Instance()->deleteById($id);
    return $this->model
      ->set("password", md5($password))
      ->where("id", "=", $id)
      ->update();
  }

  public function updateSettings($data, $id) {
    $name = $data['fullname'];
    $eventTitle = $data['eventTitle'];
    $welcomeMessage = $data['welcomeMessage'];
    $actionFlag = $data['actionFlag'];
    $QRCodeFlag = $data['QRCodeFlag'];
    $this->model
      ->set("name", $name)
      ->set('eventTitle', $eventTitle)
      ->set('welcomeMessage', $welcomeMessage)
      ->set('actionFlag', $actionFlag)
      ->set('QRCodeFlag', $QRCodeFlag)
      ->where("id", '=', $id);
    if (isset($data['image']))
      return $this->model->set('welcomeImageFilename',  $data['image']->name)->where("id", "=", $id)->update();
    return $this->model->update();
  }
}
