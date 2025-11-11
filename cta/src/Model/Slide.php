<?php
namespace CTA\Model;

class Slide {
    private $id;
    private $title;
    private $description;
    private $buttonText;

    public function __construct($id, $title, $description, $buttonText) {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->buttonText = $buttonText;
    }

    public function getId() { return $this->id; }
    public function getTitle() { return $this->title; }
    public function getDescription() { return $this->description; }
    public function getButtonText() { return $this->buttonText; }
}
