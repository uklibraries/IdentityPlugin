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

class MintIdentifier extends Omeka_Job_AbstractJob
{

	public function mint()
	{
	        // minting an ARK using NOID
                Zend_Registry::get('job_dispatcher')->sendLongRunning(
                'Neatline_ImportItems', array('noid', '-f', '$path', 'mint', '1')
               ); 

	}

}

?>

