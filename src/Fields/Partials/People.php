<?php

namespace People\Fields\Partials;

use Log1x\AcfComposer\Partial;
use StoutLogic\AcfBuilder\FieldsBuilder;

class People extends Partial
{
    /**
     * The partial field group.
     *
     * @return array
     */
    public function fields()
    {
        $Fields = new FieldsBuilder('people');

        $Fields
            ->addTaxonomy('groups', [
                'label' => 'Show people from',
                'taxonomy' => 'people_group',
                'field_type' => 'checkbox',
                'return_format' => 'object',
            ]);

        return $Fields;
    }
}
