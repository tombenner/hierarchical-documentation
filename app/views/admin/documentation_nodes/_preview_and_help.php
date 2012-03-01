<div id="DocumentationNodePreviewContainer">
	<h3>Preview</h3>
	<div id="DocumentationNodePreviewResult"></div>
</div>

<br />

<h3>Syntax Help</h3>

<h4>Markdown</h4>

<p>
	<a href="http://daringfireball.net/projects/markdown/syntax" target="_blank">Markdown syntax documentation</a>
</p>

<h4>Links to Documentation Pages</h4>

<p>
	To insert a link to a documentation page, use a [link] tag with the ID of the documentation node:
</p>

<pre>
[link id="3"]My link text[/link]
</pre>

<h4>Lists of Children Nodes' Content</h4>

<p>
	To insert a list of the content of all of the current node's children nodes (<a href="http://wpmvc.org/documentation/37/controller-methods/" target="_blank">example</a>), use a [children_list] tag:
</p>

<pre>
[children_list]
</pre>

<h4>Code</h4>

<p>
	To insert a block of syntax-highlighted code, use a [code] tag:
</p>

<?php
$example_markup = '[code language="ruby"]
	@my_var = 5;	
[/code]';
$documentation_helper;
?>

<pre>
<?php echo $example_markup; ?>
</pre>

<p>
	This will produce:
</p>

<?php echo $this->documentation->parse_documentation_string($example_markup); ?>

<p>
	If no language is specified, PHP is used by default. Any language that <a href="http://qbnz.com/highlighter/" target="_blank">GeSHi</a> supports is supported.
</p>