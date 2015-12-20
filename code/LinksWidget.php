<?php

class LinksWidget extends Widget
{

    private static $db        = array(
    );
    private static $many_many = array(
        'Links' => 'Link'
    );

    /**
     * @var string
     */
    private static $title = "Links widget";

    /**
     * @var string
     */
    private static $cmsTitle = "Widget to display a list of links";

    /**
     * @var string
     */
    private static $description = "Display a list of links on pages.";

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->addFieldToTab("Root.Main", new TextField('WidgetLabel', 'Widget Label'), "Enabled");
        $fields->addFieldToTab("Root.Main", new TextField('WidgetName', 'Widget Name'), "Enabled");
        if ($this->ID) {
            $config            = GridFieldConfig_RelationEditor::create();
            $config->getComponentByType('GridFieldDataColumns')->setDisplayFields(array(
                'Title'                => 'Title',
                'OpenInNewWindow.Nice' => 'Open In New Window'
            ));
            $relatedPagesField = new GridField(
                    'Links', // Field name
                    'Links', // Field title
                    $this->Links(), $config
            );
            $fields->addFieldToTab('Root.Links', $relatedPagesField);
        } else {
            $relatedPagesField = TextField::create('RelatedPage')->setTitle('Related page')->setDisabled(true)->setValue('You can add pages once you have saved the record for the first time.');
            $fields->addFieldToTab('Root.Main', $relatedPagesField);
        }

        return $fields;
    }

    public function Title()
    {
        return $this->WidgetLabel;
    }

    public function Form()
    {
        $form = false;
        if ($this->FormPage()) {
            $result = new UserDefinedForm_Controller($this->FormPage());
            $result->init();
            $form   = $result->Form();
        }
        return $form;
    }
}
