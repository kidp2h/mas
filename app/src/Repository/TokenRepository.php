<?php

namespace Repository;

use Core\Repository;
use DateTime;
use Model\Token;

class TokenRepository extends Repository {
  protected static $nameModel = Token::class;

  public function deleteByToken($token) {
    $this->model->where("token", "=", $token)->delete();
  }

  public function deleteById($id) {
    $this->model->where("id", "=", $id)->delete();
  }

  public function getTokenById($id): ?Token {
    return $this->model->select("*")->where("id", "=", $id)->where("expire", ">", (new DateTime())->format("Y-m-d H:i:s"))->findOne();
  }

  public function deleteTokenExpired() {
    return $this->model->where("expire", "<", (new DateTime())->format("Y-m-d H:i:s"))->delete();
  }

  public function createToken($id, $token, $expire) {
    return $this->model->insert(["id" => $id, "token" => $token, "expire" => $expire]);
  }

  public function verifyToken($token) {
    return $this->model->select("*")->where("token", "=", $token)->where("expire", ">", (new DateTime())->format("Y-m-d H:i:s"))->findOne();
  }
}
