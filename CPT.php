<?php

class CPT{

    public function __construct(){
        
        add_action('init', 'CPT::register_post_type');
        add_action('init', 'CPT::trying_to_show_cf');

    }


    public function register_post_type()
    {
        $labels = array(
               
                'name' => _x('DIXBPO CS', 'post type general name'),
                'singular_name' => _x('Membros', 'post type singular name'),
                'add_new' => _x('Add New', 'Membros item'),
                'add_new_item' => __('Adicionar novo Membro'),
                'edit_item' => __('Editar Membros'),
                'new_item' => __('Novo Item Membros'),
                'view_item' => __('Visualizar Item Membros'),
                'search_items' => __('Procurar Membros'),
                'not_found' =>  __('Nada encontrado'),
                'not_found_in_trash' => __('Nada encontrado no lixo'),
                'parent_item_colon' => ''
            );
        
        $args = array(
                'labels' => $labels,
                'public' => true,
                'publicly_queryable' => true,
                'show_ui' => true,
                'query_var' => true,
                'menu_icon' => 'dashicons-book-alt',
                'rewrite' => true,
                'capability_type' => 'post',
                'hierarchical' => false,
                'menu_position' => null,
                'supports' => array('title', 'editor', 'excerpt', 'author', 'revisions','custom-fiels', 'thumbnail','post-formats', 'page-attributes'),
              );
        
        register_post_type('membros', $args);
    }

}