<?php
/**
* MintIdentifier 
*
* @copyright Copyright 2014 Richard Maiti
* @license http://opensource.org/licenses/MIT MIT
*/

/**
 * The background job that mints an identifier.
 *
 * @package Omeka\Plugins\Identity
 */


// read the noid path from the properties file
$ini_array = parse_ini_file("plugin.ini");
$noid_path = $ini_array['noid_path'];

class MintIdentifier extends Omeka_Job_AbstractJob
{

	public function mint()
	{
	        // minting an ARK using NOID
                Zend_Registry::get('job_dispatcher')->sendLongRunning(
                'Neatline_ImportItems', array('noid', '-f', '$noid_path', 'mint', '1')
               ); 

	}

}

?>

