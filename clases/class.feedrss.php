<?php
class FeedRSS{
	public $title;
	private $atomLink;
	public $link;
	private $language;
	private $description;
	private $image = array();
	private $items = array();
	
	function setTitle($title){
		$this->title = $title;
	}
	function setAtomLink($atomLink){
		$this->atomLink = $atomLink;
	}
	function setLink($link){
		$this->link = $link;
	}
	function setLanguage($language){
		$this->language = $language;
	}
	function setDescription($description){
		$this->description = $description;
	}
	function setImage($title, $url, $link){
		$this->image['title'] = $title;
		$this->image['url'] = $url;
		$this->image['link'] = $link;
	}
	function createNewItem(){
		$item = new FeedRSSItem();
		return $item;
	}
	function addItem($item){
		$this->items[] = $item;
	}
	function generateFeed(){
		header('Content-Type: text/xml');
		echo '<?xml version="1.0" encoding="UTF-8"?>
			<rss version="2.0"
			xmlns:content="http://purl.org/rss/1.0/modules/content/"
			xmlns:dc="http://purl.org/dc/elements/1.1/"
			xmlns:atom="http://www.w3.org/2005/Atom"
			>
				<channel>
					<title>'.$this->title.'</title>
					<atom:link href="'.$this->atomLink.'" rel="self" type="application/rss+xml" />
					<link>'.$this->link.'</link>
					<description>'.$this->description.'</description>
					<pubDate>'.date(DATE_RSS, time()).'</pubDate>
					<generator>http://vaope.com/</generator>
					<language>'.$this->language.'</language>
					<image>
						<url>'.$this->image['url'].'</url>
						<title>'.$this->image['title'].'</title>
						<link>'.$this->image['link'].'</link>
					</image>';
		foreach($this->items as $item){
			echo '
					<item>
						<title><![CDATA['.$item->title.']]></title>
						<link>'.$item->link.'</link>
						<comments>'.$item->comments.'</comments>
						<pubDate>'.$item->pubDate.'</pubDate>
						<dc:creator>'.$item->creator.'</dc:creator>
						<category><![CDATA['.$item->category.']]></category>
						<guid isPermaLink="false">'.$item->link.'</guid>
						<description><![CDATA['.$item->description.']]></description>
					</item>
			';
		}
		echo '</channel>
			</rss>';
	}
}

class FeedRSSItem{
	public $title;
	public $link;
	public $comments;
	public $pubDate;
	public $creator;
	public $category;
	public $description;
	
	function setTitle($title){
		$this->title = $title;
	}
	function setLink($link){
		$this->link = $link;
	}
	function setComments($comments){
		$this->comments = $comments;
	}
	function setPubDate($pubDate){
		if(is_numeric($pubDate))
			$this->pubDate = date(DATE_RSS, $pubDate);
		else
			$this->pubDate = $pubDate;
	}
	function setCreator($creator){
		$this->creator = $creator;
	}
	function setCategory($category){
		$this->category = $category;
	}
	function setDescription($description){
		$this->description = $description;
	}
}
?>