<?php

/**
 * NamespaceHTML - allows raw HTML in specified namespaces
 *
 * To activate this extension, add the following into your LocalSettings.php file:
 * require_once( "$IP/extensions/NamespaceHTML/NamespaceHTML.php" );
 * #$wgRawHTMLNamespaces = array(); #must be set!
 *
 * @ingroup Extensions
 * @author Ike Hecht
 * @version 0.1
 * @link https://www.mediawiki.org/wiki/Extension:NamespaceHTML Documentation
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */
if ( !defined( 'MEDIAWIKI' ) ) {
	echo ( "This is an extension to the MediaWiki package and cannot be run standalone.\n" );
	die( -1 );
}

// Extension credits that will show up on Special:Version
$wgExtensionCredits['parserhook'][] = array(
	'path' => __FILE__,
	'name' => 'NamespaceHTML',
	'version' => '0.1',
	'author' => 'Ike Hecht for [http://www.wikiworks.com/ WikiWorks]',
	'url' => 'https://www.mediawiki.org/wiki/Extension:NamespaceHTML',
	'descriptionmsg' => 'namespacehtml-desc',
);

$wgAutoloadClasses['NamespaceHTML'] = __DIR__ . '/NamespaceHTML.class.php';
$wgHooks['ParserFirstCallInit'][] = 'NamespaceHTML::addNamespaceHTML';
$wgExtensionMessagesFiles['NamespaceHTML'] = __DIR__ . '/NamespaceHTML.i18n.php';

# After extension inclusion, in LocalSettings.php, set to namespaces where
# raw html should be allowed.
$wgRawHtmlNamespaces = array();
