<?php
    final class Pagination {
        
        // Maximum number of page links
        public $max_page_links = 0;

        // the total number of pages
        public $total_pages = 0;

        // Maximum number of items per page
        public $max_page_items = 0;

        // Maximum number of items in table
        public $max_db_items = 0;

        // Current page we're at
        public $current_page = 1;

        // Initialized page counter to 1
        public $page_counter = 1;

        // The last page possible
        public $last_page = 0;

        // The database object
        public static $dbInstance = null;
        
        public function __construct($config) {
            $this->max_page_items = $config['max-page-items'];
            $this->max_page_links = $config['max-page-links'];
            $this->table = $config['table'];

            if( is_object($config['db']) ) {
                self::$dbInstance = $config['db'];
            }

            $this->InitItemsCount();
            $this->InitLastPage();
            $this->SetCurrentPage($config['current-page']);
        }

        /*
         * Used for page links generation
         * Get the next page link
         */
        public function Next() {
            return $this->page_counter++;
        }

        /*
         * Used for page links generation
         * Get the last page link
         */
        public function Last() {
            return $this->last_page;
        }

        /*
         * Set the current page we're at
         */
        public function SetCurrentPage($page) {
            if($page <= 0) {
                $this->current_page = 1;
            }
            else if($page > $this->last_page) {
                $this->current_page = $this->last_page;
            }
            else {
                $this->current_page = $page;
            }
        }

        /*
         * Get the count of all items in the table
         */
        public function InitItemsCount() {
            $result = self::$dbInstance->setFetchMode(FetchModes::$modes['assoc'])->rawQuery("select count(id) as items_count from " . $this->table, [], true, DB::ALL_ROWS);
            if(_Array::size($result) > 0){
                $this->max_db_items = $result[0]['items_count'];
            } else {
                $this->max_db_items = 0;
            }
        }

        /***/
        public function InitLastPage() {
            $this->last_page = ceil($this->max_db_items / $this->max_page_items);
        }

        /*
         * Retrieve the $max_db_items count
         */
        public function GetItemsCount() {
            return $this->max_db_items;
        }

        /*
         * Retrieve the maximum number of page links
         */
        public function GetMaxPageLinks() {
            return $this->max_page_links;
        }

        /*
         * Retrieve the current page
         */
        public function GetCurrentPage() {
            return $this->current_page;
        }
    }
?>