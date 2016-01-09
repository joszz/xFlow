<?php
/** The video controller
 *  @package    Controllers
 *  @version    0.1
 *  @author     Jos Nienhuis
 *  @copyright  Copyright (c) 2013 Jos Nienhuis
 *  @since      04-04-2014
 */
class VideoController extends Controller{

    private $videoModel;

    /** The constructor loading the videoModel
     *
     *  @param      array       $settings       All the settings defined in config.php
     *  @version    0.1
     *  @author     Jos Nienhuis
     *  @since      04-04-2014
     */
    public function VideoController($settings){
        $this->videoModel = new VideoModel($settings);
        parent::__construct($settings);
    }

    /** Shows a carrousel with DVD covers retrieved from XBMC databases
     *  @version    0.1
     *  @author     Jos Nienhuis
     *  @since      04-04-2014
     */
    public function index(){
        $this->data['movies'] = $this->videoModel->getMovies();
    }

    /** Shows movie information called from fancybox when clicked on DVD cover
     *  @version    0.1
     *  @author     Jos Nienhuis
     *  @since      04-04-2014
     */
    public function movie(){
        if(!isset($_GET[2])) die();

        $this->styles[] = 'moviedetails.css';
        $this->data['movie'] = $this->videoModel->getMovieById($_GET[2]);
        $this->data['trailer'] = substr($this->data['movie']['c19'], $start = strpos($this->data['movie']['c19'], 'videoid=') + 8);
    }

    /** Called by jquery.autocomplete to retrieve automcomplete suggestions
     *  @version    0.1
     *  @author     Jos Nienhuis
     *  @since      04-04-2014
     */
    public function autocomplete(){
        die(json_encode(array('query'        => $_GET['query'],
                              'suggestions'  => $this->videoModel->autocompleteMovieSearch($_GET['query']),
                              'data'         => array())));
    }

    public function search(){
        if($_SERVER['REQUEST_METHOD'] != 'POST') redir(WWWBASE);

        $this->view = 'search';

		$this->data['movies'] = $this->videoModel->getMovies();
        $this->data['searchedMovies'] = $this->videoModel->movieSearch($_POST['searchfor']);
        dump($this->data['searchedMovies']);
    }
}
?>