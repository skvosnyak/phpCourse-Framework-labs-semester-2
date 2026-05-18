<?php
namespace MyProject\View;

class View
{
  private $templatesPath;

  public function __construct(string $templatesPath)
  {
    $this->templatesPath = $templatesPath;
  }

  public function renderHtml(string $templateName, array $vars = [], ?string $title = null)
  {
    if ($title !== null) {
      $vars['pageTitle'] = $title;
    }
    $vars['templatesPath'] = $this->templatesPath;
    extract($vars);
    include $this->templatesPath . '/' . $templateName;
  }
}