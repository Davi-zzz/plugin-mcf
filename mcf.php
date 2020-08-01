<?php
/*
Plugin Name: DIXBPO CS-A
Plugin URI: http://exemple.com
Description: Plugin desenvolvido para Academia de Letras Palmense
Version: 1.0
Author: <a href="https://www.linkedin.com/in/davi-silva-moraes-979595148/">Davi-SM, </a><a href=""https://www.linkedin.com/in/yhan-nunes-8666ba198/>Yhan Nunes</a>
Text Domain: dixbpo_csa
License: GPLv2
*/
//instancia a class do plugin
include("one-of-two-filtering.php");
include("CPT.php");
class dixbpo_csa_new
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
    private function __construct()
    {
        add_action('init', function () {
            $cpt = new CPT;
            $cpt->register_post_type();
        });
        add_action('init', function () {
            $filter_instance = new dixbpo_filter_solution;
            $filter_instance->filtering_results();
        });
        add_action('save_post', 'dixbpo_csa_new::save_details');
        add_action("admin_init", "dixbpo_csa_new::admin_init");
    }

    public static function admin_init()
    {
        add_meta_box("year_completed-meta", "Datas", "dixbpo_csa_new::year_completed", "membros", "side", "low");
        add_meta_box("credits_meta", "Hierarquia", "dixbpo_csa_new::credits_meta", "membros", "normal", "low");
    }

    public static function year_completed()
    {
        global $post;
        $custom = get_post_custom($post->ID);
        $ano_posse = $custom["ano_posse"][0];
        $ano_falecimento = $custom["ano_falecimento"][0];
        $ano_entrada = $custom["ano_entrada"][0];
        $ano_eleicao = $custom["ano_eleicao"][0];
        $ano_nascimento = $custom["ano_nascimento"][0]; ?>

        <label>Ano de Posse:</label><br /> 
        <input type="date" name="ano_posse" value="<?php echo $ano_posse; ?>" /><br /> 
        <label>Ano de Falecimento:</label><br /> 
        <input type="date" name="ano_falecimento" value="<?php echo $ano_falecimento; ?>" /><br /> 
        <label>Ano de Entrada na Academia:</label><br /> 
        <input type="date" name="ano_entrada" value="<?php echo $ano_entrada; ?>" /><br /> 
        <label>Ano de Eleição:</label><br /> 
        <input type="date" name="ano_eleicao" value="<?php echo $ano_eleicao; ?>" /><br /> 
        <label>Ano de Nascimento:</label><br /> 
        <input type="date" name="ano_nascimento" value="<?php echo $ano_nascimento; ?>" />
        <?php
    }

    public static function credits_meta()
    {
        global $post;
        $custom = get_post_custom($post->ID);
        $cadeiras = $custom["cadeiras"][0];
        $posicoes = $custom["posicoes"][0];
        $posicaocadeira = $custom["posicaocadeira"][0]; ?>
       
     <div id="CF1" style="display: flex"> 
        <label style="font-size: 20px;align-self: center; margin-right: 10px;">Cadeiras:<u style="font-size: 20px"></u></label><br />
        
        <select placeholder="Selecione a Cadeira" style="width: 30%; height: 50%; align-self: center;" name='cadeiras' id='cadeiras'>
        <?php
            if ($cadeiras == null) {
                echo '<option value selected >Selecione a Cadeira</option>';
            } else {
                echo '<option value="'.$cadeiras.'" selected>'.$cadeiras.'</option>';
            } ?>
            
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        <option value="6">6</option>
        <option value="7">7</option>
        <option value="8">8</option>
        <option value="9">9</option>
        <option value="10">10</option>                       
        <option value="11">11</option>
        <option value="12">12</option>
        <option value="13">13</option>
        <option value="14">14</option>
        <option value="15">15</option>
        <option value="16">16</option>
        <option value="17">17</option>
        <option value="18">18</option>
        <option value="19">19</option>
        <option value="20">20</option>                       
        <option value="21">21</option>
        <option value="22">22</option>
        <option value="23">23</option>
        <option value="24">24</option>
        <option value="25">25</option>
        <option value="26">26</option>
        <option value="27">27</option>
        <option value="28">28</option>
        <option value="29">29</option>
        <option value="30">30</option>                       
        <option value="31">31</option>
        <option value="32">32</option>
        <option value="33">33</option>
        <option value="34">34</option>
        <option value="35">35</option>
        <option value="36">36</option>
        <option value="37">37</option>
        <option value="38">38</option>
        <option value="39">39</option>
        <option value="40">40</option>                       
        </select>
        <label style="font-size: 20px;  align-self: center; margin-right: 10px; margin-left: 10px;">Posições: </label><br/>
        
        <select style="width: 30%; height: 50%; align-self: center  " name='posicoes' id='posicoes'> 
        <?php
            if ($posicoes == null) {
                echo '<option value selected >Selecione a Posição</option>';
            } else {
                echo '<option value="'.$posicoes.'" selected>'.$posicoes.'</option>';
            } ?>
        
        <option value="">--</option>
        <option value="Atual">Atual</option>
        <option value="Patrono">Patrono</option>
        <option value="Fundador">Fundador</option>
                           
        </select>

        <br><label style="font-size: 20px; align-self: center; margin-right: 10px; margin-left: 10px; display: table">Insira sua vez na Cadeira:</label>
        <input type="number" style="width: 30%; height: 50%; align-self: center;" name="posicaocadeira" id='posicoes' min="1" value=<?php echo $posicaocadeira ?>></input></br>

    </div>
        <?php
    }
    
    public static function save_details()
    {
        global $post;
        
        if ($_POST["posicoes"] != null) {
            $_POST["posicaocadeira"] = null;
        } elseif ($_POST["posicaocadeira"] != null) {
            $_POST["posicoes"] = null;
        }
        
        update_post_meta($post->ID, "ano_posse", $_POST["ano_posse"]);
        update_post_meta($post->ID, "ano_falecimento", $_POST["ano_falecimento"]);
        update_post_meta($post->ID, "ano_entrada", $_POST["ano_entrada"]);
        update_post_meta($post->ID, "ano_eleicao", $_POST["ano_eleicao"]);
        update_post_meta($post->ID, "ano_nascimento", $_POST["ano_nascimento"]);
        update_post_meta($post->ID, "cadeiras", $_POST["cadeiras"]);
        update_post_meta($post->ID, "posicoes", $_POST["posicoes"]);
        update_post_meta($post->ID, "link_antecessor", $_POST["link_antecessor"]);
        update_post_meta($post->ID, "link_sucessor", $_POST["link_sucessor"]);
        update_post_meta($post->ID, "posicaocadeira", $_POST["posicaocadeira"]);
    }
}
dixbpo_csa_new::getInstance();
