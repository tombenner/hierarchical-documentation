<?php

class DocumentationHelper extends MvcHelper {

	private $node_local_id = null;
	private $documentation_node_model = null;
	
	public function init() {
		$this->version = displayed_documentation_version();
		$this->documentation_node_model = MvcModelRegistry::get_model('DocumentationNode');
	}
	
	public function parse_documentation_with_id($string, $id) {
		$node = $this->documentation_node_model->find_by_id($id);
		if (!empty($node->local_id)) {
			$this->node_local_id = $node->local_id;
		}
		$string = $this->parse_documentation_string($string);
		return $string;
	}
	
	public function parse_documentation_with_local_id($string, $local_id) {
		$this->node_local_id = $local_id;
		$string = $this->parse_documentation_string($string);
		return $string;
	}
	
	public function parse_documentation_string($string) {
		$string = $this->parse_shortcodes($string);
		$string = $this->parse_markdown($string);
		return $string;
	}
	
	public function parse_markdown($string) {
		$string = str_replace('_', '\_', $string);
		$string = parse_markdown($string);
		$string = str_replace('\_', '_', $string);
		return $string;
	}
	
	public function parse_shortcodes($string) {
		$string = preg_replace_callback('/\[([\w_-]+)(.*?)\](.*?)\[\/\1\]/s', array($this, 'parse_shortcodes_callback'), $string);
		$string = preg_replace_callback('/\[([\w_-]+)(.*?)\]/s', array($this, 'parse_self_closing_shortcodes_callback'), $string);
		return $string;
	}
	
	public function parse_shortcodes_callback($match) {
		$code = $match[1];
		$text = $match[3];
		$attributes = $this->parse_shortcode_attributes($match[2]);
		$result = '['.$match[1].$match[2].']'.$match[3].'['.$match[1].']';
		switch ($code) {
			case 'code':
				$language = empty($attributes['language']) ? 'php' : $attributes['language'];
				$geshi = new GeSHi($text, $language);
				$result = $geshi->parse_code();
				break;
			case 'link':
				if (!empty($attributes['id'])) {
					$object = $this->documentation_node_model->find_one(array('conditions' => array('local_id' => $attributes['id'], 'documentation_version_id' => $this->version->id)));
					$result = '<a href="'.mvc_public_url(array('object' => $object)).'" title="'.esc_attr($text).'">'.$text.'</a>';
				}
				break;
			default:
				break;
		}
		return $result;
	}
	
	public function parse_self_closing_shortcodes_callback($match) {
		$code = $match[1];
		$attributes = $this->parse_shortcode_attributes($match[2]);
		$result = '['.$match[1].$match[2].']';
		switch ($code) {
			case 'children_list':
				$parent_node_id = $this->node_local_id;
				$documentation_node = new DocumentationNode();
				$children = $documentation_node->find(array('conditions' => array('parent_id' => $parent_node_id, 'documentation_version_id' => $this->version->id)));
				$html = '';
				foreach($children as $node) {
					$url = mvc_public_url(array('controller' => 'documentation_nodes', 'action' => 'show', 'object' => $node));
					$html .= '<h3 class="section-header">'.$node->title.'</h3>';
					$html .= '<div class="view-single-page"><a href="'.$url.'" title="View this page">View this page</a></div>';
					$html .= $this->parse_documentation_with_local_id($node->content, $node->local_id);
				}
				$this->id = $parent_node_id;
				$result = $html;
				break;
			default:
				break;
		}
		return $result;
	}
	
	private function parse_shortcode_attributes($string) {
		$attributes = array();
		if(preg_match_all('/([\w_-]+)=([^\s]*)/', $string, $matches, PREG_SET_ORDER)) {
			foreach($matches as $match) {
				$attributes[$match[1]] = trim($match[2], '\'" ');
			}
		}
		return $attributes;
	}
	
	public function truncate_html($string, $options=array()) {
		$defaults = array(
			'length' => 300,
			'more_href' => null,
			'more_text' => null
		);
		$options = array_merge($defaults, $options);
		$html_truncater = new HtmlTruncater();
		$string = $html_truncater->getSubstring($string, $options['length'], $options['more_href'], $options['more_text']);
		return $string;
	}
	
}

?>