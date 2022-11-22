<?php

namespace Controller;

use Core\Controller;
use Core\Model;
use Core\Request;
use Core\Response;
use Model\UserModel;

class HomeController extends Controller
{
  private Model $model;

  private static self $instance;

  public function __construct()
  {
    $this->model = new UserModel();
  }

  public static function Instance(): self
  {
    if (!isset(self::$instance)) {
      self::$instance = new self();
    }
    return self::$instance;
  }

  public function home(Request $request, Response $response)
  {
    $this->render('home', [
      'title' => 'Photo list',
      'titlePage' => 'Memory Album System - 1100 Photo List',
    ]);
  }
  public function qrcode(Request $request, Response $response)
  {
    $this->render('qrcode', [
      'title' => 'QR Code',
      'titlePage' => 'Memory Album System - 1300 QR code Print sheet',
    ]);
  }

  public function settings(Request $request, Response $response)
  {
    $this->render('settings', [
      'title' => 'Settings',
      'titlePage' => 'Memory Album System - 1400 Settings',
    ]);
  }


  public function uploadExhibition(Request $request, Response $response)
  {
    $this->render('uploadExhibition', [
      'title' => 'Upload Exhibition',
      'titlePage' => 'Memory Album System - 1400 Settings',
    ]);
  }
}
