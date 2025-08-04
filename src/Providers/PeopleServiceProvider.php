<?php

namespace People\Providers;

use Illuminate\Support\Facades\View;
use People\Fields\People as PeopleField;
use People\Fields\Partials\People as PeopleBuilderField;
use People\View\Composers\People as PeopleComposer;
use Log1x\AcfComposer\AcfComposer;
use StoutLogic\AcfBuilder\FieldsBuilder;
use App\Fields\Partials\Clones\Builder;

class PeopleServiceProvider implements Provider
{
    public static $parent_layout_key;

    protected function providers()
    {
        return [
            RegisterAssets::class,
            RegisterPostType::class,
        ];
    }

    public function register()
    {
        $people_key = 'people';  // Variable value
        self::$parent_layout_key = 'builder_builder_' . $people_key;

        foreach ($this->providers() as $service) {
            (new $service)->register();
        }
    }

    public function boot()
    {
        // Register Fields
        $composer = app(AcfComposer::class);
        $people = new PeopleField($composer);
        $people->compose();

        add_filter('acf/load_field/name=builder', function ($field) {
            if (isset($field['layouts'])) {
                $people_builder = new PeopleBuilderField();

                $layout = [
                    'key' => 'field_'.self::$parent_layout_key,
                    'name' => 'people',
                    'label' => 'People',
                    'display' => 'block',
                    'sub_fields' => $people_builder->register()['fields'],
                    'min' => '',
                    'max' => '',
                    'acfe_flexible_render_template' => false,
                    'acfe_flexible_render_style' => false,
                    'acfe_flexible_render_script' => false,
                    'acfe_flexible_thumbnail' => false,
                    'acfe_flexible_settings' => false,
                    'acfe_flexible_settings_size' => 'medium',
                    'acfe_flexible_modal_edit_size' => false,
                    'acfe_flexible_category' => false,
                ];

                $field['layouts'][] = $layout;
            }
            // dd($field);
            return $field;
        });

        // Register views
        View::addLocation(dirname(dirname(__DIR__)) . '/resources/views');

        View::composer('partials.builder.people', PeopleComposer::class);

    }
}
