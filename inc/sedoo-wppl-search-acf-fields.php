<?php
if( function_exists('acf_add_local_field_group') ):
    acf_add_local_field_group(array(
        'key' => 'group_5ec4f0d0a2427',
        'title' => 'Libellé des contenus',
        'fields' => array(
            array(
                'key' => 'field_5ec4f0dc6a696',
                'label' => 'Articles',
                'name' => 'sedoo_search_lib_articles',
                'type' => 'text',
                'instructions' => 'Renseignez ici le nom qui remplacera l\'intitulé \'Article\' dans les filtres de recherche',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'maxlength' => '',
            ),
            array(
                'key' => 'field_5ec4f0f86a697',
                'label' => 'Pages',
                'name' => 'sedoo_search_lib_pages',
                'type' => 'text',
                'instructions' => 'Renseignez ici le nom qui remplacera l\'intitulé \'Page\' dans les filtres de recherche',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'maxlength' => '',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'acf-options-parametres',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
    ));


    acf_add_local_field_group(array(
        'key' => 'group_5ec4f3d8ec4b3',
        'title' => 'Ordre des types de contenu',
        'fields' => array(
            array(
                'key' => 'field_5ec4f3da19995',
                'label' => 'Liste ordonnée des types de contenu',
                'name' => 'sedoo_search_repeat',
                'type' => 'repeater',
                'instructions' => 'Les type de contenus non ordonnés dans le tableau ci dessous seront classés en derniers. Utiliser le bouton Ajouter un Element pour ordonner un type de contenu',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'collapsed' => '',
                'min' => 0,
                'max' => 0,
                'layout' => 'table',
                'button_label' => '',
                'sub_fields' => array(
                    array(
                        'key' => 'field_5ec4f7d919996',
                        'label' => 'Types de contenu',
                        'name' => 'sedoo_search_post_type',
                        'type' => 'select',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'choices' => array(
                        ),
                        'default_value' => array(
                        ),
                        'allow_null' => 0,
                        'multiple' => 0,
                        'ui' => 0,
                        'return_format' => 'value',
                        'ajax' => 0,
                        'placeholder' => '',
                    ),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'acf-options-parametres',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
    ));

endif;
?>