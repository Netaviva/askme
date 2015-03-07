<?php


class Mobile_Controller_Index extends Linko_Controller
{
    public function main()
    {
        $sUri = $this->getParam('uri');

        Linko::Router()->setKey('mobile')
            ->setBase('mobile');

        $aRoutes = Linko::Router()->getRoutes('page');

        foreach($aRoutes as $sId => $oRoute)
        {
            if($sId == 'mobile:core')
            {
                continue;
            }

            /**
             * @var $oRoute Linko_Route
             */
            Linko::Router()->add($oRoute->getRawRegex(), array(
                'id' => $sId,
                'controller' => $oRoute->getController(),
                'rules' => $oRoute->getRules()
            ));
        }

        Linko::Router()->add('/', array(
            'id' => 'mobile:home',
            'controller' => 'mobile/home'
        ));

        Linko::Router()->add('dashboard', array(
            'id' => 'mobile:dashboard',
            'controller' => 'mobile/dashboard'
        ));

        $oRoute = Linko::Router()->route($sUri);

        Linko::Module()->set($oRoute->controller, $oRoute->args);

        Linko::Template()->setType('mobile');
        Linko::Template()->setStyle('mobile.css', 'module_mobile');

        if(!Linko::Template()->isLayout('template'))
        {
            Linko::Template()->setLayoutDirectory('module_mobile');
            Linko::Template()->clearStyle('style.css', 'theme_css');
            Linko::Template()->clearStyle('common.css', 'theme_css');
            Linko::Template()->setStyle('reset.css', 'asset_css');
            Linko::Template()->setStyle('style.css', 'module_mobile');
            Linko::Template()->setType(null);
        }
    }
}