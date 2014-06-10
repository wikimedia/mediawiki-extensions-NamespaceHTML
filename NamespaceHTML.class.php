<?php

/**
 * Description of NamespaceHTML
 *
 * @author Ike Hecht
 */
class NamespaceHTML {

	/**
	 * Where secure and relevant, adds support for <html> tag
	 *
	 * @param $parser Parser
	 * @return boolean
	 */
	static function addNamespaceHTML( Parser &$parser ) {
		global $wgRawHtml, $wgRawHtmlNamespaces;

		# If raw HTML allowed wiki-wide, don't do anything.
		if ( $wgRawHtml ) {
			return true;
		}

		$title = $parser->getTitle();
		if ( !isset( $title ) ) {
			return true;
		}

		/**
		 * Pass everything to core parser tag hook function for 'html'.
		 * Enabled even when $wgRawHtml is disabled.
		 *
		 * This is potentially unsafe and should be used only in protected
		 * namespaces, as the contents are emitted as raw HTML.
		 */
		$namespace = $title->getNamespace();
		# Note: This code prevents transcluding from a $wgRawHtmlNamespace
		# to another namespace. Is that ideal?
		if ( in_array( $namespace, $wgRawHtmlNamespaces ) ) {
			$wgRawHtml = true;
			$parser->setHook( 'html', array( 'CoreTagHooks', 'html' ) );
		}

		return true;
	}

}
