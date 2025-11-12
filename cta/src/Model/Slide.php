<?php
namespace CTA\Model;

class Slide {
    private $id;
    private $title;
    private $description;
    private $buttonText;
    private $form;

    public function __construct($id, $title, $description, $buttonText, array $form = []) {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->buttonText = $buttonText;
        $this->form = array_merge([
            'name_placeholder' => 'Your Name',
            'email_placeholder' => 'Your Email',
            'submit_label' => 'Submit',
        ], $form);
    }

    public function getId() { return $this->id; }
    public function getTitle() { return $this->title; }
    public function getDescription() { return $this->description; }
    public function getButtonText() { return $this->buttonText; }
    public function getForm(): array { return $this->form; }
}
