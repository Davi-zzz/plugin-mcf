<?php

class dixbpo_filter_solution
{
    private static $instance;
    const TEXT_DOMAIN = "my custom field";
    const FIELD_PREFIX = 'dixbpo_csa_';
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance == new self();
        }
       
        return self::$instance;
    }

    public function __construct()
    {
        add_action('init', 'dixbpo_filter_solution::filtering_results');
    }

    public static function filtering_results()
    {
        global $wpdb;
        global $post;
        $var1 = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    
        $mypost_id = url_to_postid($var1);
        
        // echo $mypost_id;
            
        if ($mypost_id != 0) {
            $input = isset($_POST['receive-text']) ? $_POST['receive-text'] : '';
            $input2 = isset($_POST['select-filter']) ? $_POST['select-filter'] : '';
            
            if ($input != '' && $input2 == '1') {
                $aux = 'AND wp_posts.post_title LIKE "%'.$input.'%"';
                $sql = 'SELECT DISTINCT wp_posts.post_title, wp_posts.guid, cadeiras.meta_value,posicoes.meta_value as posicoes, posicaocadeira.meta_value as posicaocadeira
                     FROM wp_posts 
                     JOIN wp_postmeta ON (wp_posts.id = wp_postmeta.post_id)
                     JOIN wp_postmeta as cadeiras on (wp_posts.id = cadeiras.post_id AND cadeiras.meta_key ="cadeiras") 
                     JOIN wp_postmeta as posicoes on (wp_posts.id = posicoes.post_id AND posicoes.meta_key = "posicoes")
                     JOIN wp_postmeta as posicaocadeira on (wp_posts.id = posicaocadeira.post_id AND posicaocadeira.meta_key = "posicaocadeira")
                     WHERE (wp_posts.post_type = "membros" AND wp_posts.post_status = "publish")';
                     
                $sql = $sql.$aux;
                $results = $wpdb -> get_results($sql);
                
                
                if (sizeof($results = $wpdb -> get_results($sql)) == 0) {
                    echo "<p> Não foi encontrado nenhum resultado na busca </p>";
                    self::display_fields($results, 1);
                } else {
                    $query = new WP_Query(array( 'post_type' => 'membros' ));
     
                    $query->the_post();
                    self::display_fields($results, 2);
                }
            } elseif ($input != '' && $input2 == '2') {
                $aux = 'AND cadeiras.meta_value LIKE "%'.$input.'%"';
                $sql = 'SELECT DISTINCT wp_posts.post_title, wp_posts.guid, cadeiras.meta_value,posicoes.meta_value as posicoes, posicaocadeira.meta_value as posicaocadeira
                     FROM wp_posts 
                     JOIN wp_postmeta ON (wp_posts.id = wp_postmeta.post_id)
                     JOIN wp_postmeta as cadeiras on (wp_posts.id = cadeiras.post_id AND cadeiras.meta_key ="cadeiras") 
                     JOIN wp_postmeta as posicoes on (wp_posts.id = posicoes.post_id AND posicoes.meta_key = "posicoes")
                     JOIN wp_postmeta as posicaocadeira on (wp_posts.id = posicaocadeira.post_id AND posicaocadeira.meta_key = "posicaocadeira")
                     WHERE (wp_posts.post_type = "membros" AND wp_posts.post_status = "publish")';
                     
                $sql = $sql.$aux;
                $results = $wpdb -> get_results($sql);
                
                if (sizeof($results = $wpdb -> get_results($sql)) == 0) {
                    echo "<p> Não foi encontrado nenhum resultado na busca</p>";
                    self::display_fields($results, 1);
                } else {
                    $query = new WP_Query(array( 'post_type' => 'membros' ));
            
                    $query->the_post();
                    self::display_fields($results, 2);
                }
            } elseif ($input != '' && $input2 == '3') {
                $aux = 'AND posicoes.meta_value LIKE "%'.$input.'%" OR posicaocadeira.meta_value LIKE "%'.$input.'%" ';
                $sql = 'SELECT DISTINCT wp_posts.post_title, wp_posts.guid, cadeiras.meta_value,posicoes.meta_value as posicoes, posicaocadeira.meta_value as posicaocadeira
                     FROM wp_posts 
                     JOIN wp_postmeta ON (wp_posts.id = wp_postmeta.post_id)
                     JOIN wp_postmeta as cadeiras on (wp_posts.id = cadeiras.post_id AND cadeiras.meta_key ="cadeiras") 
                     JOIN wp_postmeta as posicoes on (wp_posts.id = posicoes.post_id AND posicoes.meta_key = "posicoes")
                     JOIN wp_postmeta as posicaocadeira on (wp_posts.id = posicaocadeira.post_id AND posicaocadeira.meta_key = "posicaocadeira")
                     WHERE (wp_posts.post_type = "membros" AND wp_posts.post_status = "publish")';
                     
                $sql = $sql.$aux;
                $results = $wpdb -> get_results($sql);
                
                if (sizeof($results = $wpdb -> get_results($sql)) == 0) {
                    echo "<p> Não foi encontrado nenhum resultado na busca</p>";
                    self::display_fields($results, 1);
                } else {
                    $query = new WP_Query(array( 'post_type' => 'membros' ));
     
                    $query->the_post();
                    self::display_fields($results, 2);
                }
            } else {
                $sql = 'SELECT DISTINCT wp_posts.id as id , imagem.guid as imagem , wp_posts.post_title, wp_posts.guid, cadeiras.meta_value as cadeiras, posicoes.meta_value as posicoes, posicaocadeira.meta_value as posicaocadeira
                FROM wp_posts 
                JOIN wp_postmeta ON (wp_posts.id = wp_postmeta.post_id)
                JOIN wp_postmeta as cadeiras on (wp_posts.id = cadeiras.post_id AND cadeiras.meta_key ="cadeiras") 
                JOIN wp_postmeta as posicoes on (wp_posts.id = posicoes.post_id AND posicoes.meta_key = "posicoes")
                JOIN wp_postmeta as posicaocadeira on (wp_posts.id = posicaocadeira.post_id AND posicaocadeira.meta_key = "posicaocadeira")
                LEFT JOIN wp_posts as imagem on (wp_posts.id = imagem.post_parent AND imagem.post_type = "attachment")
                WHERE (wp_posts.post_type = "membros" AND wp_posts.post_status = "publish") 
                ORDER BY wp_posts.post_title ASC';
                
                $results = $wpdb -> get_results($sql);
                if (sizeof($results = $wpdb -> get_results($sql)) == 0) {
                    echo "<p> Não foi encontrado nenhum resultado na busca</p>";
                    self::display_fields($results, 1);
                } else {
                    $query = new WP_Query(array( 'post_type' => 'membros' ));
     
                    $query->the_post();
                    self::display_fields($results, 2);
                }
            }
        }
    }
    public static function display_fields($array, $tipo)
    {
        if ($tipo == 1) {
            ?>
            <style>
                 #filter_fields{
                        max-width: 800px;
                        display: flex;
                    }
                    #filter_fields > label{
                      margin-top: 5px;

                    }
                    #filter_fields > input[type="radio"]{
                        margin-top: 11px;
                        margin-left: 4px;
                        margin-right: 5px;
                    } 
                    

                    
            </style>
            <div id="filter_result" class="entry-content post-inner thin" style="width:100%">
                <form method="POST">
                            <div id="filter_fields">
                                <input name="receive-text" type="text" placeholder="digite aqui..." />
                                <label for="name">Nome</label>
                                <input type="radio" id="name" name="select-filter" value="1">
                                <label for="chair">Cadeira</label>
                                <input type="radio" id="chair" name="select-filter" value="2">
                                <label for="position">Posição</label>
                                <input type="radio" id="position" name="select-filter" value="3">                
                                <button id="apply_button" type="submit">Aplicar</button>
                            </div>
                        
                  
                </form>
            
            </div>
            <?php
        } else {
            ?>
                            <style>
                                #flex_Image{
                                    display: flex;
                                    flex-wrap: wrap;
                                    max-width: 800px;
                                    

                                }
                                #flex_Image > div{
                                    flex: 1 1 200px;
                                    margin: 10px;
                                    max-width: 200px;
                                   
                                }
                                #flex_Image > div > p {
                                    text-align: center;
                                    font-weigth: bold;
                                }
                                #flex_Image > div > p > a > img {
                                border-style: solid;
                                border-width: 2px;
                                border-radius: 0.2em;
                                width: 120px;
                                height: 200px;
                                max-width: 120px;
                                max-height: 200px;
                                }
                                #filter_fields{
                                    max-width: 800px;
                                    display: flex;
                                }
                                #filter_fields > label{
                                    margin-top: 5px;

                                }
                                #filter_fields > input[type="radio"]{
                                    margin-top: 11px;
                                    margin-left: 4px;
                                    margin-right: 5px;
                                }
                                #filter_fields > label{
                                    font-weight: bold;
                                }
                                .filter-title{
                                    font-weight: bold;
                                    font-size: 18px;
                                }
                                

                            </style>

                             <div id="filter_result" class="entry-content post-inner thin ">

                             <form method="POST">
                             <div id="flex_Image">
                                 <?php foreach ($array as $key => $value) {
                echo '<div>';
                $aux = str_replace('#038;', '', $array[$key]->guid);
                echo "<p><a href='".$aux."'>".get_the_post_thumbnail($array[$key]->id, array(120,200))."</a></p>";
                echo '<p class="filter-title"><a href="'.$aux.'">'.$array[$key]->post_title.'</a></p>';
                echo '<p class="filter-title">Cadeira: '.$array[$key]->cadeiras.'</p>';
                echo '<p class="filter-title">Posição: '.$array[$key]->posicaocadeira.'</p>';
                echo '<p class="filter-title">'.$array[$key]->posicoes.'</p>';
                echo '</div>';
            } ?>
                    </div>
                            <div id="filter_fields">
                                <input name="receive-text" type="text" placeholder="digite aqui..." />
                                <label for="name">Nome</label>
                                <input type="radio" id="name" name="select-filter" value="1">
                                <label for="chair">Cadeira</label>
                                <input type="radio" id="chair" name="select-filter" value="2">
                                <label for="position">Posição</label>
                                <input type="radio" id="position" name="select-filter" value="3">                
                                <button type="submit">Aplicar</button>
                            </div>
                      
                </form>
            
        </div>

            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"
                integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg=="
                crossorigin="anonymous"></script>

            <script>
            $(document).ready(function() {
                var x = $('#filter_result').get();
                console.log(x);
                $(x).appendTo('.elementor-widget-wrap');

            });
            </script>
            <?php
        }
    }
}
//**nyan~desu */
