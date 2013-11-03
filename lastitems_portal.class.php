<?php
 /*
 * Project:		EQdkp-Plus
 * License:		Creative Commons - Attribution-Noncommercial-Share Alike 3.0 Unported
 * Link:		http://creativecommons.org/licenses/by-nc-sa/3.0/
 * -----------------------------------------------------------------------
 * Began:		2008
 * Date:		$Date: 2012-08-22 23:19:08 +0200 (Mi, 22. Aug 2012) $
 * -----------------------------------------------------------------------
 * @author		$Author: godmod $
 * @copyright	2006-2011 EQdkp-Plus Developer Team
 * @link		http://eqdkp-plus.com
 * @package		eqdkp-plus
 * @version		$Rev: 11957 $
 * 
 * $Id: lastitems_portal.class.php 11957 2012-08-22 21:19:08Z godmod $
 */

if ( !defined('EQDKP_INC') ){
	header('HTTP/1.0 404 Not Found');exit;
}

class lastitems_portal extends portal_generic {
	public static function __shortcuts() {
		$shortcuts = array('pdh', 'core', 'config', 'user', 'routing');
		return array_merge(parent::$shortcuts, $shortcuts);
	}

	protected $path		= 'lastitems';
	protected $data		= array(
		'name'			=> 'LastItems Module',
		'version'		=> '2.0.0',
		'author'		=> 'Corgan',
		'icon'			=> 'fa-trophy',
		'contact'		=> EQDKP_PROJECT_URL,
		'description'	=> 'Show last items',
	);
	protected $positions = array('left1', 'left2', 'right');
	protected $settings	= array(
		'pk_last_items_limit'	=> array(
			'name'		=> 'pk_last_items_limit',
			'language'	=> 'pk_last_items_limit',
			'property'	=> 'text',
			'size'		=> '2',
			'help'		=> 'pk_help_lastitems_limit',
		),
	);
	protected $install	= array(
		'autoenable'		=> '1',
		'defaultposition'	=> 'right',
		'defaultnumber'		=> '2',
	);

	public function output() {
		$limit = ($this->config->get('pk_last_items_limit') > 0) ? $this->config->get('pk_last_items_limit') : '5' ;
		$allitems = $this->pdh->aget('item', 'date', 0, array($this->pdh->get('item', 'id_list')));
		arsort($allitems);
		$items = array_keys(array_slice($allitems, 0, $limit, true));
		if (is_array($items) && count($items) > 0) {
			$out = '<table width="100%" class="colorswitch hoverrows">';
			infotooltip_js();
			foreach ($items as $item) {
				$buyer = $this->pdh->get('item', 'buyer', array($item));
				$out .= '<tr class="nowrap">'.
								"<td>
									".$this->pdh->get('item', 'link_itt', array($item, $this->routing->simpleBuild('item'), '', false, false, false,false,false,true)).' <br />'.
									$this->pdh->get('member', 'html_memberlink', array($buyer, $this->routing->simpleBuild('character'), '', false, false, true, true));
					if (!$this->config->get('disable_points')){
									$out .= ' ('.$this->pdh->get('item', 'html_value', array($item))." ".$this->config->get('dkp_name').")";
					}
				$out .=	"			</td>
							</tr>";
			}
			$out .= '</table>';
		} else {
			$out = $this->user->lang('pk_last_items_noitems');
		}
		return $out;
	}
}
?>