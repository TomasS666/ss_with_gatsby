<?php 
namespace Test;

use SilverStripe\GraphQL\Scaffolding\Interfaces\ScaffoldingProvider;
use SilverStripe\GraphQL\Scaffolding\Scaffolders\SchemaScaffolder;
use SilverStripe\ORM\DataObject;

use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;

class Post extends DataObject
{
    private static $table_name = 'post';
    private static $db = [
        'Title' => 'Varchar(255)',
        'Content' => 'HTMLText'
    ];

    private static $has_one = [
        'HomePage' => HomePage::class
    ];

    public function onAfterWrite()
{
    parent::onAfterWrite();
    $this->updateGraph();
}

public function onBeforeDelete()
{
    parent::onBeforeDelete();
    $this->updateGraph();
}

public function updateGraph()
{
    parent::onAfterWrite();

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL,"http://localhost:8000/__refresh");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    $server_output = curl_exec($ch);
    
    curl_close ($ch);
}

    // public function provideGraphQLScaffolding(SchemaScaffolder $scaffolder)
    // {
    //     $scaffolder
    //         ->type(Post::class)
    //             ->addFields([
    //                 'Title', 'Content'
    //             ])
    //             ->operation(SchemaScaffolder::READ)
    //                 ->end()
    //             ->operation(SchemaScaffolder::UPDATE)
    //                 ->end()
    //             ->end();

    //     return $scaffolder;
    // }

    public function getCMSFields()
    {
        // $fields = parent::getCMSFields();
        $fields = FieldList::create(
            TextField::create('Title', 'Title'),
            HtmlEditorField::create('Content', 'Content')
        );

        return $fields;
    }
}