<?php

namespace People\Fields\Partials;

use StoutLogic\AcfBuilder\FieldsBuilder;
use People\Providers\PeopleServiceProvider;

class People
{
    protected $fields;

    public function __construct()
    {
        $parent_layout_key = PeopleServiceProvider::$parent_layout_key;
        $subfield_key = 'people';
        $final_key = $parent_layout_key . '_' . $subfield_key;

        $this->fields = new FieldsBuilder($final_key);

        $this->fields
            ->addTaxonomy('groups', [
                'label' => 'Show people from',
                'required' => 0,
                '_name' => 'groups',
                'taxonomy' => 'group',
                'field_type' => 'checkbox',
                'add_term' => 0,
                'return_format' => 'object',
            ]);
    }

    /**
     * Get the built fields for the partial
     *
     * @return array
     */
    public function register(): array
    {
        return $this->fields->build();
    }
}