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
                //$str = exec("noid -f $path mint 1");

                Zend_Registry::get('job_dispatcher')->sendLongRunning(
                'Neatline_ImportItems', array(
                'noid'    => $noid,
                '-f'      => $f, 
                '$path'   => $path,
                'mint'    => $mint,
                '1'       => $one  
                )
               );
	}

}

?>

