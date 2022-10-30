<?php

namespace Core;

class Template {
  private $layout;
  private $view;
  private $data;
  private $sections;
  private $script;
  private $style;
  private $currentSection;
  public function __construct(string $view, array $data) {
    $this->layout = 'main';
    $this->view = $view;
    $this->data = $data;
    $this->sections = [];
    $this->script = '';
    $this->style = '';
  }

  public function layout($layout) {
    $this->layout = $layout;
  }
  public function renderLayout($layout) {
    extract($this->data);
    $path = $this->resolvePath(_DIR_VIEW_ . "Layout/{$layout}.php");
    ob_start();
    require_once $path;
    $contentLayout = ob_get_contents();
    ob_end_clean();
    echo $contentLayout;
  }

  public function renderSection(string $name) {
    echo $this->sections[$name];
  }

  public function renderScript() {
    echo $this->script;
  }

  public function renderAllSection() {
    foreach ($this->sections as $view) {
      echo $view;
    }
  }

  public function startScript() {
    ob_start();
  }

  public function endScript() {
    $script = ob_get_contents();

    ob_end_clean();
    $this->script = $script;
  }

  public function style() {
    ob_start();
  }

  public function endStyle() {
    $style = ob_get_contents();

    ob_end_clean();
    $this->style = $style;
  }

  public function renderStyle() {
    echo $this->style;
  }

  public function section(string $nameSection) {
    $this->currentSection = $nameSection;
    ob_start();
  }

  public function end() {
    if (empty($this->currentSection)) {
      throw new \Exception('There is not a section start');
    }
    $content = ob_get_contents();

    ob_end_clean();

    $this->sections[$this->currentSection] = $content;

    $this->currentSection = null;
  }

  public function resolvePath($path) {
    if (!file_exists($path)) {
      throw new \Exception("$path is not exist");
    }
    return $path;
  }
  public function run() {
    extract($this->data);
    $path = $this->resolvePath(_DIR_VIEW_ . "Page/{$this->view}.php");

    ob_start();
    require_once $path;
    ob_get_contents();

    ob_end_clean();
    if (empty($this->layout)) {
      $this->renderAllSection();
    } else {
      $this->renderLayout($this->layout);
    }
  }
}
