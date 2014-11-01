<?php
/**
 * @package phpBB Extension - Portal
 * @copyright (c) Geert Eltink
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 */

namespace xtreamwayz\portal\controller;

use xtreamwayz\portal\service\portal_service;
use phpbb\controller\helper;
use phpbb\template\template;

class main
{
    /**
     * @var helper
     */
    protected $helper;

    /**
     * @var template
     */
    protected $template;

    /**
     * @var portal_service
     */
    protected $portal_service;

    /**
     * Constructor
     *
     * @param helper $helper
     * @param template $template
     * @param portal_service $portal_service
     */
    public function __construct(helper $helper, template $template, portal_service $portal_service)
    {
        $this->helper = $helper;
        $this->template = $template;
        $this->portal_service = $portal_service;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle()
    {
        $news = $this->portal_service->get_news();

        // Assign activity stream to the template
        $this->template->assign_var('news_posts', $news);

        // Render the template
        return $this->helper->render('portal_body.html');
    }
}
