<?php
/**
* IdentityPlugin
*
* @copyright Copyright 2014 Richard Maiti
* @license http://opensource.org/licenses/MIT MIT
*/

/**
 * The Identity plugin.
 *
 * @package Omeka\Plugins\Identity
 */

include 'MintIdentifier.php'; 

class IdentityPlugin extends Omeka_Plugin_AbstractPlugin  
{

    // Add a hook
    protected $_hooks = array('after_save_item'); 

    public function afterSaveItem($item)
    {
        if ($item['post'])
        {
            // Do someting with the POST data.
            // get a list of items

            $item = $item ? $item : get_current_item();
            $elements = $item->getItemTypeElements();
            foreach ($elements as $element) {
               $elementText[$element->name] = item(ELEMENT_SET_ITEM_TYPE, $element->name);
               if ($element->name == 'Identifier')
               {
                   $identifier_field = $element->value;  
               }
            }


            // Check to see if the item has no CleanUrl ARK and no proper ARK
            // #^ark:/\d{5}/[0-9bcdfghjkmnpqrstvwxz]+$# (proper ARK)
            // #^ark:\d{5}_[0-9bcdfghjkmnpqrstvwxz]+$# (CleanUrl ARK)


            if (preg_match('^ark:\d{5}_[0-9bcdfghjkmnpqrstvwxz]+$', $identifier_field) == true)
            {
                // do nothing if the item has a CleanUrl Ark 
            } // if item has no cleanUrl ARK but has a proper ARK
            elseif (preg_match('^ark:/\d{5}/[0-9bcdfghjkmnpqrstvwxz]+$', $identifier_field)== true and
                    (preg_match('^ark:\d{5}_[0-9bcdfghjkmnpqrstvwxz]+$', $identifier_field) == false))
            {
                $clear_url_ark = ltrim($clear_url_ark, '/');
                $clear_url_ark = str_replace("/", "_", $ark);

                $identifier_field = $clear_url_ark;

                // set the identifier field
                set_current_item($identifier_field);
                $s = new Omeka_AbstractRecord(); 
                $s->save();
            }
            else 
            {
                // calling background job to mint an ARK using NOID
                $mint_ark = new MintIdentifier;
                $ark = $mint_ark->mint();
                // strip out the warning and just include the ark information
                $del = "id:";
                $ark = strpos($str, $del);

                // bind the title of the item into the noid metadata cache
                $title = item('Dublic Core', 'Title');
                $str_bind = exec("noid bind set $ark $title");

                // convert the ARK to CleanUrl ARK

                $clear_url_ark = ltrim($clear_url_ark, '/');
                $clear_url_ark = str_replace("/", "_", $clean_url_ark);

                $identifier_field = $clear_url_ark;

                // set the identifier field
                set_current_item($identifier_field);
                $s = new Omeka_AbstractRecord();
                $s->save(); 
            } 
        }
    }
}
?>
