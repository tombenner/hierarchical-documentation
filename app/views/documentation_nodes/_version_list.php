<div class="documentation-version-list">
	<strong>Version: <?php echo $current_version->name; ?></strong>
	<ul>
		<?php
			$default_public_version_id = mvc_setting('DocumentationSettings', 'public_version_id');
			foreach ($versions as $version) {
				$name = $default_public_version_id == $version->id ? '__default__' : $version->name;
				if ($current_version->id != $version->id) {
					echo '<li>'.$this->html->object_link($version->related_node, array('text' => $version->name, 'documentation_version_name' => $name)).'</li>';
				}
			}
		?>
	</ul>
</div>