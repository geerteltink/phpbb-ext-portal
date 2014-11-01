<?php
/**
 * @package phpBB Extension - Portal
 * @copyright (c) Geert Eltink
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 */

namespace xtreamwayz\portal\event;

/**
 * @ignore
 */
use phpbb\controller\helper;
use phpbb\template\template;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Event listener
 */
class main_listener implements EventSubscriberInterface
{
    /* @var \phpbb\controller\helper */
    protected $helper;

    /* @var \phpbb\template\template */
    protected $template;

    protected $news_forum_id = 3;

    /**
     * Constructor
     *
     * @param \phpbb\controller\helper $helper Controller helper object
     * @param \phpbb\template\template $template Template object
     */
    public function __construct(helper $helper, template $template)
    {
        $this->helper = $helper;
        $this->template = $template;
    }

    static public function getSubscribedEvents()
    {
        return array(
            'core.page_header' => 'add_portal_link'
        );
    }

    public function add_portal_link()
    {
        $this->template->assign_vars(array(
            'U_PORTAL' => $this->helper->route('portal'),
            'U_NEWS' => append_sid('viewforum.php', 'f=' . $this->news_forum_id)
        ));
    }
}
