<?php 
class resultset {
    private $results = array();
    private $numberOfItems = 0;
    private $numberOfPages = 1;
    private $numberOfItemsOnLastPage = 0;
    var $itemsPerPage = 10;

    
    function __construct() {

    
    }
    
    function add($item) {
        //Automatic Paging
        if ($this->numberOfItemsOnLastPage + 1 > $this->itemsPerPage) {
            $this->numberOfPages++;
            $this->numberOfItemsOnLastPage = 0;
        }
        
        $this->results[$this->numberOfPages][$this->numberOfItemsOnLastPage] = $item;
        $this->numberOfItems++;
        $this->numberOfItemsOnLastPage++;
        
    }
    
    function clear() {
        $this->results = null;
        $this->numberOfItems = 0;
        $this->numberOfPages = 1;
        $this->numberOfItemsOnLastPage = 0;
    }
    
    function readPage($pageNumber) {
        if (isset($this->results[$pageNumber])) {
            return $this->results[$pageNumber];
        } else {
            return null;
        }
        
    }
    
    /**
     * Returns $numberOfItems.
     * @see resultset::$numberOfItems
     */
    public function getNumberOfItems() {
        return $this->numberOfItems;
    }
    
    /**
     * Returns $numberOfPages.
     * @see resultset::$numberOfPages
     */
    public function getNumberOfPages() {
        return $this->numberOfPages;
    }
}

?>
