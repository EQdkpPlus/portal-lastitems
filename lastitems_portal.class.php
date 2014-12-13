<?php
/*	Project:	EQdkp-Plus
 *	Package:	Last item Portal Module
 *	Link:		http://eqdkp-plus.eu
 *
 *	Copyright (C) 2006-2015 EQdkp-Plus Developer Team
 *
 *	This program is free software: you can redistribute it and/or modify
 *	it under the terms of the GNU Affero General Public License as published
 *	by the Free Software Foundation, either version 3 of the License, or
 *	(at your option) any later version.
 *
 *	This program is distributed in the hope that it will be useful,
 *	but WITHOUT ANY WARRANTY; without even the implied warranty of
 *	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *	GNU Affero General Public License for more details.
 *
 *	You should have received a copy of the GNU Affero General Public License
 *	along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

if ( !defined('EQDKP_INC') ){
	header('HTTP/1.0 404 Not Found');exit;
}

class lastitems_portal extends portal_generic {

	protected static $path		= 'lastitems';
	protected static $data		= array(
		'name'			=> 'LastItems Module',
		'version'		=> '2.0.0',
		'author'		=> 'Corgan',
		'icon'			=> 'fa-trophy',
		'contact'		=> EQDKP_PROJECT_URL,
		'description'	=> 'Show last items',
		'lang_prefix'	=> 'lastitems_'
	);
	protected static $positions = array('left1', 'left2', 'right');
	protected $settings	= array(
		'limit'	=> array(
			'type'		=> 'text',
			'size'		=> '2',
		),
	);
	protected static $install	= array(
		'autoenable'		=> '1',
		'defaultposition'	=> 'right',
		'defaultnumber'		=> '2',
	);
	
	protected static $apiLevel = 20;

	public function output() {
		$limit = ($this->config('limit') > 0) ? $this->config('limit') : '5' ;
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
									".$this->pdh->get('item', 'link_itt', array($item, $this->routing->simpleBuild('items'), '', false, false, false,false,false,true)).' <br />'.
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