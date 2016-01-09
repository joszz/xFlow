<?php
/** The video model
 *  @package    Models
 *  @version    0.1
 *  @author     Jos Nienhuis
 *  @copyright  Copyright (c) 2013 Jos Nienhuis
 *  @since      04-04-2014    
 */
class VideoModel Extends Model {
    
    /** Selects the video database for querying
     *  @version    0.1
     *  @author     Jos Nienhuis
     *  @since      04-04-2014    
     */
    protected function setDatabaseName(){
        mysql_select_db($this->settings['db']['dbname']['video']) or die (mysql_error());
    }
    
    /** Gets all movies from the XBMC database
     *  @return     array                           An array containing all movies 
     * 
     *  @version    0.1
     *  @author     Jos Nienhuis
     *  @since      04-04-2014    
     */
    public function getMovies(){
        return $this->extractImagesFromXML($this->fetchall($this->query("SELECT * FROM movie_view ORDER BY c10")));
    }
    
    /** Gets all movie information for a movie by ID
     *  @param      int             $id             the XBMC movie ID
     *  @return     array                           A single Movie as array containing all the columns defined in the XBMC video database
     * 
     *  @version    0.1
     *  @author     Jos Nienhuis
     *  @since      04-04-2014    
     */
    public function getMovieById($id){
        return current($this->extractImagesFromXML(array($this->fetch($this->query("SELECT * FROM movie_view WHERE idMovie = " . intval($id))))));
    }
    
    /** Retrieves autocomplete suggestions with a LIKE
     *  @param      string          $searchFor      The search string to match movie titles with
     *  @return     array                           An array with movie titles matchin the search criteria
     * 
     *  @version    0.1
     *  @author     Jos Nienhuis
     *  @since      04-04-2014    
     */
    public function autocompleteMovieSearch($searchFor){
        $movies = $this->fetchall($this->query("SELECT c00
                                                  FROM movie_view
                                                 WHERE c00 LIKE '%" . $this->escape($searchFor) . "%'"));

        $return = array();                                  
        foreach($movies AS $movie){
            $return[] = utf8_encode($movie['c00']);
        }
        return $return;
    }
    
    public function movieSearch($searchFor){
        $moviesSearchedFor = $this->fetchall($this->query("SELECT c00, idMovie
                                                             FROM movie_view                                               
                                                            WHERE c00 LIKE '%" . $this->escape($searchFor) . "%'
                                                 "));


        $surroundingMovies = $this->fetchall($this->query("(SELECT c00, idMovie
                                                                     FROM movie_view                                               
                                                                    WHERE c00 < '" . $moviesSearchedFor[0]['c00'] . "'
                                                                    ORDER BY c00 DESC
                                                                    LIMIT 0, 4)
                                                                    
                                                                    
                                                                    UNION ALL
                                                                    
                                                                    (SELECT c00, idMovie
                                                                     FROM movie_view                                               
                                                                    WHERE c00 > '" . $moviesSearchedFor[count($moviesSearchedFor) - 1]['c00'] . "'
                                                                    ORDER BY c00 ASC
                                                                    LIMIT 0, " . (4 - (count($moviesSearchedFor) - 1)) . ")"));
                                                 dump($surroundingMovies);
        $return = array();                                  
        foreach($movies AS $movie){
            $return[] = utf8_encode($movie['c00']);
        }
        return $return;
    }
    
    /** Parses the XML coming from the XBMC video database to retrieve the images (posters and fanart)
     *  @param      array           $movies         The array of movies to extract images from the XML field from
     *  @return     array                           The array of movies with the addition of 'fanart' and 'thumb' indexes for the fanart and poster images respectively
     * 
     *  @version    0.1
     *  @author     Jos Nienhuis
     *  @since      04-04-2014    
     */
    private function extractImagesFromXML($movies){
        $movieCount = count($movies);
        
        for($i = 0; $i < $movieCount; $i++){
            $movies[$i]['thumb'] = substr($movies[$i]['c08'], $start = strpos($movies[$i]['c08'], 'preview=') + 9, strpos($movies[$i]['c08'], '"', $start) - $start);
            
            if(!empty($movies{$i}['c20']))
                $movies[$i]['fanart'] = substr($movies[$i]['c20'], $start = strpos($movies[$i]['c20'], '>http://') + 1, strpos($movies[$i]['c20'], '</', $start) - $start);
            else $movies[$i]['fanart'] = '';
        }
        
        return $movies;
    }
}
?>
