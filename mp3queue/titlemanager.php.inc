<?php

// Title Manager class (essentially a queue) that uses a simple text file for storage
class TitleManager {
	private $filename = "titlemanager.txt";
	private $queueLimit = 75;
	private $titles;
	
	// Upon creation, load up our titles from the file
	public function __construct() {
		$this->titles = array();
		$this->loadTitles();
	}
	

	private function loadTitles() {
		if (file_exists($this->filename)) {
			$this->titles = file($this->filename, FILE_SKIP_EMPTY_LINES);
		}
	}
	
	// Add a title to the queue and if we are at our limit, drop one off the end.
	public function enqueue($strTitle) {
		if (!empty($strTitle)) {
			array_unshift($this->titles, $strTitle . "\n"); 
			
			if (count($this->titles) > $this->queueLimit) {
				$this->dequeue();
			}	
		}
	}
	
	// Remove a title item from the end of our list
	public function dequeue() {
		if (count($this->titles) > 0) {
			return trim(array_pop($this->titles));
		}
		return "";
	}
	
	// Save the contents of our array back to the file.
	public function save() {				
		if (file_put_contents($this->filename, $this->titles)) {
			return true;
		}
		return false;
	}


	// Check if an item is already in our list. 
	// Note: We could have also used in_array here instead of a loop.
	public function isTitlePresent($strTitle = "") {
		if (!empty($strTitle)) {
			foreach ($this->titles as $title) {
				$trimmedTitle = trim($title);
				$strTitle = trim($strTitle);
				if (strtolower($strTitle) == strtolower($trimmedTitle)) { return true; }
			}
			
			return false;
		}
		return -1;
	}
	
	
	// Mainly a debug function to print our values to screen.
	public function printValues() {
		foreach ($this->titles as $value) {
			echo "$value<br/>";
		}
	}
}
?>
