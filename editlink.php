<?php
/**
 * EditLink v0.1.0
 *
 * This plugin adds a link to the admin edit form
 *
 * @package     Edit Link
 * @version     0.1.0
 * @link        <https://github.com/hugoaf/grav-plugin-editlink>
 * @author      Hugo Avila <hugoavila@sitioi.com>
 * @copyright   2015, Hugo Avila
 * @license     <http://opensource.org/licenses/MIT>        MIT
 */
 
namespace Grav\Plugin;

use Grav\Common\Plugin;
use Grav\Common\Page\Page;
use RocketTheme\Toolbox\Event\Event;

class EditLinkPlugin extends Plugin
{

    public static function getSubscribedEvents() {
        return [
            'onPluginsInitialized' => ['onPluginsInitialized', 0],
        ];
    }



    public function onPluginsInitialized()
    {
        if ($this->isAdmin()) 
        {
            $this->active = false;
            return;
        }

        if ($this->config->get('plugins.editlink.enabled'))
        {
            $this->enable([ 'onPageContentProcessed' => ['onPageContentProcessed', 0] ]);
        }
    }


    public function onPageContentProcessed(Event $event)
     {

        $content    = '';
        $top        = '';
        $page       = $event['page'];
        $align      = $this->config->get('plugins.editlink.align'). " :10px;";
        $url        = $this->grav['base_url_relative'].'/admin/pages'.$page->route();

        if ( $this->config->get('plugins.editlink.wraper') )
        {
            $content    = "<div class=\"editlink_wraper\" style=\"position:relative;\">";
            $top        = " top:-10px; ";
        }
        
        $content    .= "
            <div class=\"editlink\" style=\"position:absolute; " . $align . $top ." z-index:1000;\">
                <a class=\"btn btn-default btn-small\" style= \"background-color:#EEE;\" target=\"_blank\"  href=\"". $url . "\">
                    <i class=\"fa fa-edit fa-lg\"></i>
                    <small>" . $page->route() ."</small>
                </a>
            </div>
        "; 

        $content    .= $page->getRawContent();

        if ( $this->config->get('plugins.editlink.wraper') )
        {
           $content .=  "</div>";
        }

        $page->setRawContent( $content );
    }

}
