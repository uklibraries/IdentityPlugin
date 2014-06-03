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
class IdentityPlugin extends Omeka_Plugin_AbstractPlugin
{
    public function aftersave($args)
    {
        if ($args['post'])
        {
            // Do someting with the POST data.
            // get a list of items

            $item = $item ? $item : get_current_item();

            // Check to see if the item has no CleanUrl ARK and no proper ARK
            // #^ark:/\d{5}/[0-9bcdfghjkmnpqrstvwxz]+$# (proper ARK)
            // #^ark:\d{5}_[0-9bcdfghjkmnpqrstvwxz]+$# (CleanUrl ARK)

            if (strpos($item,'^ark:/\d{5}/[0-9bcdfghjkmnpqrstvwxz]+$') == false and
                (strpos($item, '^ark:\d{5}_[0-9bcdfghjkmnpqrstvwxz]+$') == false))
            {
                // minting an ARK using NOID
                $str = exec("noid -f $path mint 1");
                // strip out the warning and just include the ark information
                $del = "id:";
                $ark = strpos($str, $del);

                // bind the title of the item into the noid metadata cache
                $title = item('Dublic Core', 'Title');
                $str_bind = exec("noid bind set $ark $title");

                // convert the ARK to CleanUrl ARK

                $clear_url_ark = ltrim($clear_url_ark, '/');
                $clear_url_ark = str_replace("/", "_", $ark);

                $identifier_field = $clear_url_ark;

                // set the identifier field
                set_current_item($identifier_field);

                // save the record
                //Omeka_Record->save();
            } // if item has no cleanUrl ARK but has a proper ARK
            elseif (strpos($item,'^ark:/\d{5}/[0-9bcdfghjkmnpqrstvwxz]+$')== true and
                    (strpos($item, '^ark:\d{5}_[0-9bcdfghjkmnpqrstvwxz]+$') == false))
            {
                $clear_url_ark = ltrim($clear_url_ark, '/');
                $clear_url_ark = str_replace("/", "_", $ark);

                $identifier_field = $clear_url_ark;

                // set the identifier field
                set_current_item($identifier_field);

                // save the record
                //Omeka_Record->save();

            } // if the iteam has a CleanUrl Ark, do nothing proceed to save
            elseif (strpos($item, '^ark:\d{5}_[0-9bcdfghjkmnpqrstvwxz]+$') == true)
            {
                // proceed to save
                //Omeka_Record->save();
            }
        }
    }
}
?>
