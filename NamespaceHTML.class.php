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
		global $wgRawHtml;

		# If raw HTML allowed wiki-wide, don't do anything.
		if ( $wgRawHtml ) {
			return true;
		}

		$parser->setHook( 'html', array( __CLASS__, 'html' ) );

		return true;
	}

	/**
	 * Pass everything to core parser tag hook function for 'html'.
	 * Enabled even when $wgRawHtml is disabled.
	 *
	 * This is potentially unsafe and should be used only in protected
	 * namespaces, as the contents are emitted as raw HTML.
	 *
	 * Uses undocumented extended tag hook return values, introduced in r61913.
	 *
	 * @param string $content
	 * @param array $attributes
	 * @param Parser $parser
	 * @return array
	 */
	static function html( $content, $attributes, $parser ) {
		global $wgRawHtml, $wgRawHtmlNamespaces;

		$title = $parser->getTitle();
		if ( !isset( $title ) ) {
			return htmlspecialchars( $content );
		}
		$namespace = $title->getNamespace();

		# Ideally, this check should take place in function 'addNamespaceHTML'
		# but for some reason, $parser->getTitle() often returns null there.
		# Note: This code prevents transcluding from a $wgRawHtmlNamespace
		# to another namespace. Is that ideal?
		if ( in_array( $namespace, $wgRawHtmlNamespaces ) ) {
			$wgRawHtml = true;
			return CoreTagHooks::html( $content, $attributes, $parser );
		}

		# raw HTML not allowed here so just send out escaped text
		return htmlspecialchars( Html::rawElement( 'html', $attributes, $content ) );
	}

}
