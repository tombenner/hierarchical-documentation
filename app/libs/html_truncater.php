<?php 

class HtmlTruncater {
	
	private $tag_array = array();
	
	private $string_index = 0;
	
	private $more_href =  null;
	
	private $more_text = '...';
		
	private $string_length = 0;
		
	private $raw_string = '';
		
	private $final_index = 0;
	
	public function __construct(){}
	
	public function resetClass(){
		
		$this -> tag_array = array();
	
		$this -> string_index = 0;
	
		$this -> more_href =  null;
		
		$this -> more_text =  '...';
		
		$this -> string_length = 0;
		
		$this -> raw_string = '';
		
		$this -> final_index = 0;
		
	}
	
	public function getSubstring($string, $length, $more_href = null, $more_text = null){
		
		$this -> resetClass();
		
		$this -> setString($string);
		
		$this -> setTerminalLength($length);
		
		$this -> setMoreHREF($more_href);
		
		$this -> setMoreText($more_text);
		
		if($this -> string_length > $length){
			
			for($i = 0; $i < $this -> string_length; $i++){
				
				if(!$this -> terminationConditionsMet($i)){
				
					$case = $this -> determineCase($i);
					
					switch($case){
						
						case 'openclose':
							
							$this -> addTagTypeToArray($i);
							
							break;
							
						case 'closeclose':
						
							$this -> removeTagTypeFromArray($i);
							
							break;
							
						case 'component':
							
							break;
							
						case 'normal':
							
							$this -> string_index++;
							
					}
					
					$this -> final_index = $i;
					
				}else{
					
					$this -> final_index = $i;
					
					break;
					
				}
				
				
				
			}
			
			$return_string = $this -> assembleAbbreviatedString();
			
		}else{
			
			$return_string = $string;
			
		}
		
		return $return_string;
		
	}
	
	private function setMoreHREF($more_href){
	
		if(!is_null($more_href) && !empty($more_href)){
		
			$this -> more_href = $more_href;
			
		}
	
	}
	
	private function setMoreText($more_text){
	
		if(!is_null($more_text) && !empty($more_text)){
		
			$this -> more_text = $more_text;
			
		}
	
	}
	
	private function assembleAbbreviatedString(){
		
		$return_string = substr($this -> raw_string, 0, $this -> final_index);
		
		//echo substr($this -> raw_string,0,100); exit;
		
		foreach($this -> tag_array as $tag){
		
			$return_string .= '</'.$tag.'>';
		
		}
		
		if($return_string != $this -> raw_string){
			
			//echo $return_string."\n".$this -> raw_string;
			
			if(!empty($this -> more_href)){
			
				$return_string .= ' <a href="'.$this -> more_href.'" class="read-more">'.$this -> more_text.'</a>';
			
			}else{
				
				$return_string .= '...';
				
			}
			
		}
		
		return $return_string;
		
	}
	
	private function addTagTypeToArray($i){
		
		$tag_to_add = $this -> getPreviousTagType($i);
		
		array_unshift($this -> tag_array, $tag_to_add);
		
	}
	
	private function removeTagTypeFromArray($i){
		
		array_shift($this -> tag_array);
		
	}
	
	private function terminationConditionsMet($index){
		
		if($this -> terminal_length <= $this -> string_index){
			
			$case = $this -> determineCase($index - 1);
			
			if($case != 'component'){
				
				return true;
			
			}
			
		}
		
		return false;
		
	}
	
	private function determineCase($index){
		
		if($this -> openingTagClose($index)){
			
			return 'openclose';
			
		}
		
		if($this -> closingTagClose($index)){
			
			return 'closeclose';
			
		}
		
		if($this -> tagComponent($index)){
			
			return 'component';
			
		}
		
		return 'normal';
		
	}
	
	private function getPreviousTagType($index){
		
		$substring = substr($this -> raw_string, 0, ($index + 1));
		
		preg_match('/.*<([a-zA-Z0-9\-_]+)[^>]*[^>\/]?>.*?$/si', $substring, $matches);
		
		if(isset($matches[1])){
			
			return $matches[1];
			
		}else{
			
			$this -> return_error('Failed to determine previous tag type from string '.$substring);
			
		}
		
		return false;
		
	}
	
	private function openingTagClose($index){
	
		$substring = substr($this -> raw_string, 0, ($index + 1));
		// The pattern below wasn't working with self-closing tags, but is kept here as reference for now, in case
		// issues with the new pattern pop up. 
		/*return preg_match('/<[a-zA-Z0-9\-_]+[^>]*[^\/>]?>$/si', $substring);*/
		return preg_match('/<[a-zA-Z0-9\-_]+[^>]*[^\/]>$/si', $substring);
		
	}
	
	private function closingTagClose($index){
		
		$substring = substr($this -> raw_string, 0, ($index + 1));
		
		// This assumes well formed HTML - aka a tag doesn't close within a child tag
		// example <a href= ""><i></a> ...  
		
		if(isset($this -> tag_array[0])){
			
			return preg_match('/<\/'.$this -> tag_array[0].'[^>]*>$/si', $substring);
			
		}
		
		return false;
		
	}
	
	private function tagComponent($index){
	
		$substring = substr($this -> raw_string, 0, ($index + 1));
		
		if(preg_match('/<[^>]*.?$/si', $substring)){
			
			$second_substring = substr($this -> raw_string, $index, $this -> string_length);
			
			// fringe case: where the '<' character is included in the tag but not the start of a new tag definition 
			// like 'onclick="javascript:div.html(<whatever>)"'
			// in these cases it will always we encapsulated in quotes, me thinks
			
			if(preg_match('/[^<]*?>.*/si', $second_substring)){
				
				return true;
				
			}
			
		}
		
		return false;
	
	}
	
	private function setString($string){
		
		$this -> raw_string = $string;
		
		$this -> string_length = strlen($string);
		
	}
	
	private function setTerminalLength($length){
		
		$this -> terminal_length = $length;
		
	}
	
	private function return_error($string){
		
		die($string);
		
	}
	
}

?>