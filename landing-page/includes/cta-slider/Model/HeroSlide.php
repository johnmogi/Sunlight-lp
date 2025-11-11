<?php
namespace LandingPage\CTASlider\Model;

/**
 * Value object representing a single hero slide
 */
class HeroSlide {
    private $id;
    private $preTitle;
    private $title;
    private $subtitle;
    private $description;
    private $subtext;
    private $ctaIcon;
    private $ctaText;
    private $formId;
    private $formTitle;
    private $formDescription;
    private $projectSlug;
    private $projectName;
    private $nonceName;
    private $backgroundGradient;
    private $backgroundImage;

    public function __construct(array $data) {
        $this->id = $data['id'];
        $this->preTitle = $data['pre_title'];
        $this->title = $data['title'];
        $this->subtitle = $data['subtitle'];
        $this->description = $data['description'];
        $this->subtext = $data['subtext'];
        $this->ctaIcon = $data['cta_icon'];
        $this->ctaText = $data['cta_text'];
        $this->formId = $data['form_id'];
        $this->formTitle = $data['form_title'];
        $this->formDescription = $data['form_description'];
        $this->projectSlug = $data['project_slug'];
        $this->projectName = $data['project_name'];
        $this->nonceName = $data['nonce_name'];
        $this->backgroundGradient = $data['background_gradient'];
        $this->backgroundImage = $data['background_image'];
    }

    public function getId() { return $this->id; }
    public function getPreTitle() { return $this->preTitle; }
    public function getTitle() { return $this->title; }
    public function getSubtitle() { return $this->subtitle; }
    public function getDescription() { return $this->description; }
    public function getSubtext() { return $this->subtext; }
    public function getCtaIcon() { return $this->ctaIcon; }
    public function getCtaText() { return $this->ctaText; }
    public function getFormId() { return $this->formId; }
    public function getFormTitle() { return $this->formTitle; }
    public function getFormDescription() { return $this->formDescription; }
    public function getProjectSlug() { return $this->projectSlug; }
    public function getProjectName() { return $this->projectName; }
    public function getNonceName() { return $this->nonceName; }
    public function getBackgroundGradient() { return $this->backgroundGradient; }
    public function getBackgroundImage() { return $this->backgroundImage; }
    public function getSlideClass() { return 'slide-' . $this->id; }
}
