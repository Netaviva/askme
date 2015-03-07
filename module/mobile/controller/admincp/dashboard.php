<?php defined('LINKO') or exit;

/**
 * @package Mobile
 * @author Morrison Laju <morrelinko@gmail.com>
 */
class Mobile_Controller_Admincp_Dashboard extends Linko_Controller
{
    public function main()
    {
        Linko::Template()->setTitle('Dashboard Manager');
        Linko::Template()->setBreadcrumbTitle('Dashboard Manager');
    }
}