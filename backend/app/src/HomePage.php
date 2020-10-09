<?php 

namespace Test;

use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
// use App\src\Article\Article;
// use Stageverslag\test\Article;

use Page;

class HomePage extends Page {
    private static $db = [];

    private static $has_many = [
        'Posts' => Post::class,
    ];

    private static $owns = [
        'Posts'
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->addFieldToTab('Root.Tabs', GridField::create(
            'Posts',
            'Posts',
            $this->Posts(),
            GridFieldConfig_RecordEditor::create()
        ));
        return $fields;
    }
}