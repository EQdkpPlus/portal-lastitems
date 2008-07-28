<?php
/*
 * Project:     EQdkp-Plus
 * License:     Creative Commons - Attribution-Noncommercial-Share Alike 3.0 Unported
 * Link:		http://creativecommons.org/licenses/by-nc-sa/3.0/
 * -----------------------------------------------------------------------
 * Began:       2008
 * Date:        $Date$
 * -----------------------------------------------------------------------
 * @author      $Author$
 * @copyright   2006-2008 Corgan - Stefan Knaak | Wallenium & the EQdkp-Plus Developer Team
 * @link        http://eqdkp-plus.com
 * @package     eqdkp-plus
 * @version     $Rev$
 * 
 * $Id$
 */

if ( !defined('EQDKP_INC') ){
    header('HTTP/1.0 404 Not Found');exit;
}


$portal_module['lastitems'] = array(
			'name'			    => 'LastItems Module',
			'path'			    => 'lastitems',
			'version'		    => '1.0.0',
			'author'        => 'Corgan',
			'contact'		    => 'http://www.eqdkp-plus.com',
			'description'   => 'Show last items',
			'positions'     => array('left1', 'left2', 'right'),
      'install'       => array(
                            'autoenable'        => '1',
                            'defaultposition'   => 'right',
                            'defaultnumber'     => '2',
                          ),
    );

$portal_settings['lastitems'] = array(
  'pk_last_items_limit'     => array(
        'name'      => 'pk_last_items_limit',
        'language'  => 'pk_last_items_limit',
        'property'  => 'text',
        'size'      => '2',
      ),
);

if(!function_exists(lastitems_module)){
  function lastitems_module(){
  	global $eqdkp_root_path , $user, $eqdkp,$tpl,$conf_plus,$html, $plang;

		include_once($eqdkp_root_path.'pluskernel/bridge/bridge_class.php');
		$br = new eqdkp_bridge();
		$limit = ($conf_plus['pk_last_items_limit'] > 0) ? $conf_plus['pk_last_items_limit'] : '5' ;
		$lastitems = $br->get_last_items($limit);

		if (is_array($lastitems))
		{
			$out = '<table width="100%" border="0" cellspacing="1" cellpadding="2" class="noborder">';

			foreach ($lastitems as $item)
			{
				$class = $eqdkp->switch_row_class();
				$out .= '<tr class="'.$class.'" nowrap onmouseover="this.className=\'rowHover\';" onmouseout="this.className=\''.$class.'\';">'.
							"<td>
								<a href='".$eqdkp_root_path."viewitem.php?i=". $item['id']."'>".$html->itemstats_item(stripslashes($item['name']),false,false)."</a> <br>".
								get_coloredLinkedName($item['looter']).' ('.$item['value'].' DKP)
							</td>
						</tr>';
			}
			$out .= '</table>';

			return $out;
		}
  }
}
?>
