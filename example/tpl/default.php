<?php
/**
 * @var \Former\Form\Form $form
 */

/** @var $elem \HtmlObject\Element */
foreach ($form->getChildren() as $elem) {
	print $elem;
}
