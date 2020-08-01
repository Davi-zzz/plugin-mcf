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
        wp_enqueue_style( "style", plugin_dir_url(__FILE__)."/estilos/stylePlugin.css", "all");
        $var1 = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $mypost_id = url_to_postid($var1);
        
        // echo $mypost_id;
            
        if ($mypost_id == 450) {
            $input = isset($_POST['receive-text']) ? $_POST['receive-text'] : '';
            $input2 = isset($_POST['select-filter']) ? $_POST['select-filter'] : '';
            
            if ($input != '' && $input2 == '1') {
                $aux = 'AND wp_posts.post_title LIKE "%'.$input.'%"';
                $sql = 'SELECT DISTINCT wp_posts.post_title, wp_posts.guid, cadeiras.meta_value as cadeiras,posicoes.meta_value as posicoes, posicaocadeira.meta_value as posicaocadeira
                     FROM wp_posts 
                     JOIN wp_postmeta ON (wp_posts.id = wp_postmeta.post_id)
                     JOIN wp_postmeta as cadeiras on (wp_posts.id = cadeiras.post_id AND cadeiras.meta_key ="cadeiras") 
                     JOIN wp_postmeta as posicoes on (wp_posts.id = posicoes.post_id AND posicoes.meta_key = "posicoes")
                     JOIN wp_postmeta as posicaocadeira on (wp_posts.id = posicaocadeira.post_id AND posicaocadeira.meta_key = "posicaocadeira")
                     WHERE (wp_posts.post_type = "membros" AND wp_posts.post_status = "publish")';
                     
                $sql = $sql.$aux;
                $results = $wpdb -> get_results($sql);
                
                
                if (sizeof($results = $wpdb -> get_results($sql)) == 0) {
                    self::display_fields($results, 1);
                    echo "<p> Não foi encontrado nenhum resultado na busca </p>";
                } else {
                    $query = new WP_Query(array( 'post_type' => 'membros' ));
     
                    $query->the_post();
                    self::display_fields($results, 2);
                }
            } elseif ($input != '' && $input2 == '2') {
                $aux = 'AND cadeiras.meta_value LIKE "%'.$input.'%"';
                $sql = 'SELECT DISTINCT wp_posts.post_title, wp_posts.guid, cadeiras.meta_value as cadeiras,posicoes.meta_value as posicoes, posicaocadeira.meta_value as posicaocadeira
                     FROM wp_posts 
                     JOIN wp_postmeta ON (wp_posts.id = wp_postmeta.post_id)
                     JOIN wp_postmeta as cadeiras on (wp_posts.id = cadeiras.post_id AND cadeiras.meta_key ="cadeiras") 
                     JOIN wp_postmeta as posicoes on (wp_posts.id = posicoes.post_id AND posicoes.meta_key = "posicoes")
                     JOIN wp_postmeta as posicaocadeira on (wp_posts.id = posicaocadeira.post_id AND posicaocadeira.meta_key = "posicaocadeira")
                     WHERE (wp_posts.post_type = "membros" AND wp_posts.post_status = "publish")';
                     
                $sql = $sql.$aux;
                $results = $wpdb -> get_results($sql);
                
                if (sizeof($results = $wpdb -> get_results($sql)) == 0) {
                    self::display_fields($results, 1);
                    echo "<p> Não foi encontrado nenhum resultado na busca</p>";
                } else {
                    $query = new WP_Query(array( 'post_type' => 'membros' ));
            
                    $query->the_post();
                    self::display_fields($results, 2);
                }
            } elseif ($input != '' && $input2 == '3') {
                $aux = 'AND posicoes.meta_value LIKE "%'.$input.'%" OR posicaocadeira.meta_value LIKE "%'.$input.'%" ';
                $sql = 'SELECT DISTINCT wp_posts.post_title, wp_posts.guid, cadeiras.meta_value as cadeiras,posicoes.meta_value as posicoes, posicaocadeira.meta_value as posicaocadeira
                     FROM wp_posts 
                     JOIN wp_postmeta ON (wp_posts.id = wp_postmeta.post_id)
                     JOIN wp_postmeta as cadeiras on (wp_posts.id = cadeiras.post_id AND cadeiras.meta_key ="cadeiras") 
                     JOIN wp_postmeta as posicoes on (wp_posts.id = posicoes.post_id AND posicoes.meta_key = "posicoes")
                     JOIN wp_postmeta as posicaocadeira on (wp_posts.id = posicaocadeira.post_id AND posicaocadeira.meta_key = "posicaocadeira")
                     WHERE (wp_posts.post_type = "membros" AND wp_posts.post_status = "publish")';
                     
                $sql = $sql.$aux;
                $results = $wpdb -> get_results($sql);
                
                if (sizeof($results = $wpdb -> get_results($sql)) == 0) {
                    self::display_fields($results, 1);
                    echo "<p> Não foi encontrado nenhum resultado na busca</p>";
                } else {
                    $query = new WP_Query(array( 'post_type' => 'membros' ));
     
                    $query->the_post();
                    self::display_fields($results, 2);
                }
            } else {
                $page = isset($_POST['pagination']) ?  $_POST['pagination'] :  '1';
                $page = ($page - 1) * 9;
                $aux = 'OFFSET'. $page .'ORDER BY wp_posts.post_title DESC';
                $sql = 'SELECT DISTINCT wp_posts.id as id , imagem.guid as imagem , wp_posts.post_title, wp_posts.guid, cadeiras.meta_value as cadeiras, posicoes.meta_value as posicoes, posicaocadeira.meta_value as posicaocadeira
                FROM wp_posts 
                JOIN wp_postmeta ON (wp_posts.id = wp_postmeta.post_id)
                JOIN wp_postmeta as cadeiras on (wp_posts.id = cadeiras.post_id AND cadeiras.meta_key ="cadeiras") 
                JOIN wp_postmeta as posicoes on (wp_posts.id = posicoes.post_id AND posicoes.meta_key = "posicoes")
                JOIN wp_postmeta as posicaocadeira on (wp_posts.id = posicaocadeira.post_id AND posicaocadeira.meta_key = "posicaocadeira")
                LEFT JOIN wp_posts as imagem on (wp_posts.id = imagem.post_parent AND imagem.post_type = "attachment")
                WHERE (wp_posts.post_type = "membros" AND wp_posts.post_status = "publish") 
                LIMIT 9';
                $sql = $sql . $aux;

                
                $results = $wpdb -> get_results($sql);
                if (sizeof($results = $wpdb -> get_results($sql)) == 0) {
                    self::display_fields($results, 1);
                    echo "<p> Não foi encontrado nenhum resultado na busca</p>";
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
            
            <div id="filter_result" class="entry-content post-inner thin" style="width:100%">
                <form method="POST">
                            <div id="filter_fields">
                                <label for="name">Nome</label>
                                <input type="radio" id="name" name="select-filter" value="1">
                                <label for="chair">Cadeira</label>
                                <input type="radio" id="chair" name="select-filter" value="2">
                                <label for="position">Posição</label>
                                <input type="radio" id="position" name="select-filter" value="3"> 
                                <input name="receive-text" type="text" placeholder="digite aqui..." />
                                               
                                <button id="apply_button" type="submit">Aplicar</button>
                            </div>
                        
                  
                </form>
            
            </div>
            <?php
        } else {
            ?>
                           

                             <div id="filter_result" class="entry-content post-inner thin ">

                             <form method="POST">

                             <div id="filter_fields">
                                    <!-- <div id="border-field"> -->
                                        <label for="name">Nome</label>
                                        <input type="radio" id="name" name="select-filter" value="1">
                                        <label for="chair">Cadeira</label>
                                        <input type="radio" id="chair" name="select-filter" value="2">
                                        <label for="position">Posição</label>
                                        <input type="radio" id="position" name="select-filter" value="3">
                                    <!-- </div> -->
                                <input name="receive-text" type="text" placeholder="digite aqui..." />
                                             
                                <button type="submit">Aplicar</button>
                            </div>

                             <div id="flex_Image">
                                 <?php foreach ($array as $key => $value) {
                echo '<div>';
                $aux = str_replace('#038;', '', $array[$key]->guid);
                echo "<p id='img-style'><a href='".$aux."'>".get_the_post_thumbnail($array[$key]->id, array(150,150),array("align" => 'middle'))."</a></p>";
                echo '<p class="filter-title"><a href="'.$aux.'">'.$array[$key]->post_title.'</a></p>';
                echo '<p class="filter-title-propertie">Cadeira: '.$array[$key]->cadeiras.'</p>';
                echo '<p class="filter-title-propertie">Posição: ';
                echo  $array[$key]->posicoes == null ||$array[$key]->posicoes == '' ? $array[$key]->posicaocadeira : $array[$key]->posicoes;
                echo '</p>';
                echo '</div>';
            } ?>
                    </div>

                      
                </form>
            
        </div>
            <div style="float: right;">
            <form method="POST">
                <ul style="display: inline; list-style-type: none">
                    <li>
                        <input name="pagination" type="submit" value="1" />
                    </li>
                    <li>
                        <input name="pagination" type="submit" value="2" />
                    </li>
                </ul>
            </form>
            </div>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"
                integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg=="
                crossorigin="anonymous"></script>

            <script>
            $(document).ready(function() {
                var x = $('#filter_result').get();
                
                $(x).appendTo('#teste1234');
                // $($('#filter_result').css('display','flex').get()).appendTo('#teste1234');

            });
            </script>
            <?php
        }
    }
}
//**nyan~desu */
