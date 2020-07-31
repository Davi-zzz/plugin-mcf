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
                    echo "<p> Não foi encontrado nenhum resultado na busca </p>"; ?>
                             <div id="filter_result" class="entry-content post-inner thin">
                             <form method="POST">
                             
                             <select name="select-filter" >
                             <option value >Selecione o Tipo de Filtro</option>
                             <option value="1" selected>Buscar por Nome</option>
                             <option value="2">Buscar por Cadeira</option>
                             <option value="3">Buscar por Posição</option>
                             </select>
                              <input name="receive-text"type="text" placeholder="Filtro"/>
                              
                            
                             <button type="submit">Aplicar</button>
                             </form>
                             </div>
                             <?php
                } else {
                    $query = new WP_Query(array( 'post_type' => 'membros' ));
     
                    $query->the_post(); ?>
                             <div id="filter_result" class="entry-content post-inner thin ">
                             <form method="POST">
                                 <?php foreach ($results as $key => $value) {
                        $aux = str_replace('#038;', '', $results[$key]->guid);
                        echo '<a href="'. $aux .'" target="_BLANK" >LINK DO CARA</a>';
         
                        echo $results[$key]->post_title;
                    } ?>
         <!--  nyan  -->
                            
                             <select name="select-filter" >
                             <option value>Selecione o Tipo de Filtro</option>
                             <option value="1" selected>Buscar por Nome</option>
                             <option value="2">Buscar por Cadeira</option>
                             <option value="3">Buscar por Posição</option>
                             </select>
                              <input name="receive-text"type="text" placeholder="Filtro"/>
                              
                            
                             <button type="submit">Aplicar</button>
                             </form>
                             </div>
                             <?php
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
                    echo "<p> Não foi encontrado nenhum resultado na busca</p>"; ?>
                             <div id="filter_result" class="entry-content post-inner thin ">
                             <form method="POST">
                             
                             <select name="select-filter" >
                             <option value>Selecione o Tipo de Filtro</option>
                             <option value="1">Buscar por Nome</option>
                             <option value="2" selected>Buscar por Cadeira</option>
                             <option value="3">Buscar por Posição</option>
                             </select>
                             
                              <input name="receive-text"type="text" placeholder="Filtro"/>
                              
                            
                             <button type="submit">Aplicar</button>
                             </form>
                             </div>
                             <?php
                } else {
                    $query = new WP_Query(array( 'post_type' => 'membros' ));
            
                    $query->the_post(); ?>
                                    <div id="filter_result" class="entry-content post-inner thin ">
                                    <form method="POST">
                                        <?php foreach ($results as $key => $value) {
                        $aux = str_replace('#038;', '', $results[$key]->guid);
                        echo '<a href="'. $aux .'" target="_BLANK" >LINK DO CARA</a>';
                
                        echo $results[$key]->post_title;
                    } ?>
                            <select name="select-filter" >
                             <option value>Selecione o Tipo de Filtro</option>
                             <option value="1">Buscar por Nome</option>
                             <option value="2" selected>Buscar por Cadeira</option>
                             <option value="3">Buscar por Posição</option>
                             </select>
                            
                              <input name="receive-text"type="text" placeholder="Filtro"/>
                              
                            
                             <button type="submit">Aplicar</button>
                             </form>
                             </div>
                             <?php
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
                    echo "<p> Não foi encontrado nenhum resultado na busca</p>"; ?>
                             <div id="filter_result" class="entry-content post-inner thin ">
                             <form method="POST">
                             
                             <select name="select-filter" >
                             <option value>Selecione o Tipo de Filtro</option>
                             <option value="1">Buscar por Nome</option>
                             <option value="2">Buscar por Cadeira</option>
                             <option value="3" selected>Buscar por Posição</option>
                             </select>
                             
                              <input name="receive-text"type="text" placeholder="Filtro"/>
                              
                            
                             <button type="submit">Aplicar</button>
                             </form>
                             </div>
                             <?php
                } else {
                    $query = new WP_Query(array( 'post_type' => 'membros' ));
     
                    $query->the_post(); ?>
                             <div id="filter_result" class="entry-content post-inner thin ">
                             <form method="POST">
                                 <?php foreach ($results as $key => $value) {
                        $aux = str_replace('#038;', '', $results[$key]->guid);
                        echo '<a href="'. $aux .'" target="_BLANK" >LINK DO CARA</a>';
         
                        echo $results[$key]->post_title;
                    } ?>
         
                             <select name="select-filter" >
                             <option value>Selecione o Tipo de Filtro</option>
                             <option value="1">Buscar por Nome</option>
                             <option value="2">Buscar por Cadeira</option>
                             <option value="3" selected>Buscar por Posição</option>
                             </select>


                              <input name="receive-text"type="text" placeholder="Filtro"/>
                              
                            
                             <button type="submit">Aplicar</button>
                             </form>
                             </div>
                             <?php
                }
            } else {
                $sql = 'SELECT DISTINCT wp_posts.id as id , imagem.guid as imagem , wp_posts.post_title, wp_posts.guid, cadeiras.meta_value,posicoes.meta_value as posicoes, posicaocadeira.meta_value as posicaocadeira
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
                    echo "<p> Não foi encontrado nenhum resultado na busca</p>"; ?>
                             <div id="filter_result" class="entry-content post-inner thin ">
                             <form method="POST">
                            
                             <!--get_the_post_thumbnail_url(get_the_id(), 'full') -->


                             <select name="select-filter" >
                             <option value selected>Selecione o Tipo de Filtro</option>
                             <option value="1">Buscar por Nome</option>
                             <option value="2">Buscar por Cadeira</option>
                             <option value="3">Buscar por Posição</option>
                             </select>
                             
                              <input name="receive-text"type="text" placeholder="Filtro"/>
                              
                            
                             <button type="submit">Aplicar</button>
                             </form>
                             </div>
                             <?php
                } else {
                    $query = new WP_Query(array( 'post_type' => 'membros' ));
     
                    $query->the_post(); ?>
                            <style>
                                #filter_results{
                                    display: flex;
                                    flex-wrap: wrap;
                                    max-width: 800px;

                                }
                                #filter_results > div{
                                    flex: 1 1 200px;
                                    margin: 10px;
                                }
                                
                            </style>

                             <div id="filter_result" class="entry-content post-inner thin ">

                             <form method="POST">
                                 <?php foreach ($results as $key => $value) {
                                    echo '<div>';
                                    $aux = str_replace('#038;', '', $results[$key]->guid);
                                    echo "<a href='".$aux."'>".get_the_post_thumbnail($results[$key]->id, array(100,100))."</a>";
                                    echo '<a href="'.$aux.'">'.$results[$key]->post_title.'</a>';
                                    echo '</div>';
                    } ?>


                            <select name="select-filter" >
                             <option value selected>Selecione o Tipo de Filtro</option>
                             <option value="1">Buscar por Nome</option>
                             <option value="2">Buscar por Cadeira</option>
                             <option value="3">Buscar por Posição</option>
                             </select>


                              <input name="receive-text"type="text" placeholder="Filtro"/>


                             <button type="submit">Aplicar</button>
                             </form>
                             </div>


                            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>

                            <script>
                            $( document ).ready(function() {
                                var x = $('#filter_result').get();
                                console.log(x);
                                $(x).appendTo   ('.elementor-widget-wrap');

                            });

                            </script>
                             <?php
                             
                }
            }
        }
    }
}
//**nyan~desu */
