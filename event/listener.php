<?php

/**
*
* @package Member time counter
* @author dmzx (www.dmzx-web.net)
* @copyright (c) 2014 by dmzx (www.dmzx-web.net)
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
* 
*/

namespace dmzx\membertimecounter\event;

/**
* Event listener
*/
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
	protected $template;

	static public function getSubscribedEvents()
	{
		return array(
			'core.user_setup' => 'load_language_on_setup',
			'core.memberlist_view_profile'		=> 'memberlist_view_profile',
		);
	}

	public function __construct(\phpbb\template\template $template)
	{
		$this->template = $template;
	}

	public function memberlist_view_profile($event)
	{
	    $member_for = date('d M Y, H:i:s', ($event['member']['user_regdate']));
	
		$this->template->assign_vars(array(
			'MEMBER_FOR'     => $member_for,
		));
	}
	public function load_language_on_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = array(
			'ext_name' => 'dmzx/membertimecounter',
			'lang_set' => 'membertimecounter',
		);
		$event['lang_set_ext'] = $lang_set_ext;
	}
}
