<?php

namespace Util;

use Core\Model;
use Core\SingletonBase;
use DateInterval;
use DateTime;
use Repository\TokenRepository;

class Token extends SingletonBase {

  private string $ciphering = "AES-128-CTR";
  private string $iv = "1234567890123332";

  public function generateTokenReset($id) {
    $expireAt = (new DateTime)->add(new DateInterval("PT30000S"))->getTimestamp();
    $guid =  sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535)) . "_" . $expireAt . "_" . $id;
    //$resultToken = Model::query("SELECT * FROM `reset` WHERE id=$id AND expire > NOW() LIMIT 1");
    $resultToken = TokenRepository::Instance()->getTokenById($id);
    if (!$resultToken) {
      $token = openssl_encrypt(
        $guid,
        $this->ciphering,
        $_ENV["SECRET"],
        0,
        $this->iv
      );
      TokenRepository::Instance()->deleteTokenExpired();
      $expire = (new DateTime)->add(new DateInterval("PT300S"))->format("Y-m-d H:i:s");
      TokenRepository::Instance()->createToken($id, $token, $expire);
      //Model::query("DELETE FROM reset WHERE expire < NOW()");
      //Model::query("INSERT INTO `reset` VALUES ($id,'$token', NOW() + INTERVAL 300 SECOND)");

      return $token;
    }

    return $resultToken->token;
  }
  public function encrypt($payload) {
    return openssl_encrypt(
      $payload,
      $this->ciphering,
      $_ENV["SECRET"],
      0,
      $this->iv
    );
  }
  public function decrypt($token) {
    return openssl_decrypt(
      $token,
      $this->ciphering,
      $_ENV["SECRET"],
      0,
      $this->iv
    );
  }
  public function verfiy($token) {
    //$resultDecrypt = $this->decrypt($token);
    $result = TokenRepository::Instance()->verifyToken($token);
    if ($result)
      return ["status" => true];
    return ["message" => "Request invalid", "status" => false];

    // $isValid = !strpos(urlencode($resultDecrypt), "%");
    // if ($isValid) {
    //   $tokenComponents = explode("_", $resultDecrypt);
    //   if (count($tokenComponents) === 3) {
    //     $expireAt = (int)$tokenComponents[1];
    //     $now = (new DateTime())->getTimestamp();
    //     if ($now < (int)$expireAt) return ["status" => true];
    //     return ["message" => "Request is expired", "status" => false];
    //   }
    // }
    // return ["message" => "Request invalid", "status" => false];
  }

  public function generatePayload($token) {
    $isValid = $this->verfiy($token);
    if ($isValid["status"]) {
      $resultDecrypt = explode("_", $this->decrypt($token));

      return ["payload" => $resultDecrypt[2], "status" => true];
    }
    return ["message" => "Invalid token", "status" => false];
  }
}
