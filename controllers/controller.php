<?php
/** The parent class for each controller,  defining base functionality
 *  @package    Controllers
 *  @version    0.1
 *  @author     Jos Nienhuis
 *  @copyright  Copyright (c) 2013 Jos Nienhuis
 *  @since      04-04-2014
 */

abstract class Controller {

    protected $view;
    protected $settings;
    protected $data     = array();
    protected $styles   = array('default.css',
                                'jquery.fancybox.css',
                                'imageflow.packed.css');
    protected $scripts  = array('js/jquery-3.5.0.min.js',
                                'js/jquery.fancybox.pack.js',
                                'js/imageflow.js',
                                'js/jquery.autocomplete.js',
                                'js/coverflow.js');

    private $controller = 'video';
    private $cmd        = 'index';

    /** The constructor for each controller, sets some basics and calls the correct function
     *  @param      array       $settings       All the settings defined in config.php
     *  @version    0.1
     *  @author     Jos Nienhuis
     *  @since      04-04-2014
     */
    public function Controller($settings){
        $this->settings = $settings;
        $this->setControllerProperties();
        $this->{$this->cmd}();
    }

    /** Sets the $_GET var with parts of the URL. Each part defined in the URL (so /part/) is assigned an index in $_GET.
     *  Also determines the controller, function and view
     *  @version    0.1
     *  @author     Jos Nienhuis
     *  @since      04-04-2014
     */
    final private function setControllerProperties() {
        $tempUrl = substr_replace($_SERVER['REQUEST_URI'], '', 0, strlen(WWWBASE));

        //Get all the directories being requested and put them into $_GET[] starting with 0
        $DIRvars = explode('/', $tempUrl);

        foreach ($DIRvars AS $var) {
            if (($pos = strpos($var, '?')) !== false) {
                $_GET[] = substr($var, 0, $pos);
            }
            else {
                $_GET[] = $var;
            }
        }

        //Get all the GET requests and put them into $_GET['key'] = 'value'
        $GETvars = explode('?', $tempUrl);
        if (isset($GETvars[1])) {
            $GETvars = explode('&', $GETvars[1]);
            $GETvarCount = count($GETvars);

            for ($i = 0; $i < $GETvarCount; $i++) {
                if ($i % 2 == 0) {
                    $key = $GETvars[$i];
                }
                else {
                    $_GET[$key] = $GETvars[$i];
                }
            }
        }

        //Set the controller name, start with get[0] if !empty
        if (!empty($_GET[0])) {
            $this->controller = $_GET[0];
        }

        //Set the function to be called defaults to index
        if (!empty($_GET[1])) {
            $this->cmd = $_GET[1];
        }

        $this->view = strtolower($this->cmd);
    }

    /** Loads the view and template and sends the generated HTML out to the browser
     *  @version    0.1
     *  @author     Jos Nienhuis
     *  @since      04-04-2014
     */
    public function __tostring(){
        ob_start();
        extract($this->data);
        require_once(getcwd() . '/views/' . strtolower($this->controller) . '/' . $this->view . '.php');
        $content = ob_get_contents();
        ob_clean();

        ob_start();
        $headerFiles['scripts'] = $this->scripts;
        $headerFiles['styles'] = $this->styles;
        require_once(getcwd() . '/views/template.php');
        $html = ob_get_contents();
        ob_clean();

        return $html;
    }
}
?>
