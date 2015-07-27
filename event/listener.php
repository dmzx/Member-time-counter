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
	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;
	
	/**
	* Constructor
	*
	* @param \phpbb\template\template $template
	* @param \phpbb\user $user
	*/
	
	public function __construct(\phpbb\template\template $template, \phpbb\user $user)
	{
		$this->template = $template;
		$this->user = $user;
	}
	
	static public function getSubscribedEvents()
	{
		return array(
			'core.user_setup'	=> 'load_language_on_setup',
			'core.memberlist_view_profile'	=> 'memberlist_view_profile',
		);
	}

	public function memberlist_view_profile($event)
	{

		$reg_date = phpbb_gmgetdate($event['member']['user_regdate']);
		$member_for = $reg_date['mday'] . ' ' . $reg_date['month'] . ' ' . $reg_date['year'] . ', ' . $reg_date['hours'] . ':' . $reg_date['minutes'] . ':' . $reg_date['seconds'];

		$this->template->assign_vars(array(
			'MEMBER_FOR'	 => $member_for,
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