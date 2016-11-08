<?php

require_once('vendor/autoload.php');

Requests::register_autoloader();


class EhriShortcodePlugin extends Omeka_Plugin_AbstractPlugin
{

    protected $_hooks = array('public_head');

    private $twig;

    private $TEMPLATES = array(
        'Repository'      => 'institution.twig',
        'HistoricalAgent' => 'authority.twig',
        'DocumentaryUnit' => 'unit.twig'
    );

    const API_MIMETYPE = 'application/vnd.api+json';
    const API_BASE = 'https://portal.ehri-project.eu/api/v1/';

    const DEBUG = true;

    public function __construct()
    {
        $loader = new Twig_Loader_Filesystem( array(
            dirname( __FILE__ ) . '/views/public/templates'
        ) );

        $this->twig = new Twig_Environment( $loader, array(
            'debug' => self::DEBUG,
            'cache' => self::DEBUG ? false : dirname(__FILE__) . '/cache',
        ) );
        $this->twig->addExtension(new Twig_Extensions_Extension_Text());
        $this->twig->addExtension(new Twig_Extensions_Extension_Date());
    }


    public function hookPublicHead($args)
    {
        queue_css_file('ehri-shortcode');
    }

    public function setUp()
    {
        add_shortcode('ehri_item_data', array($this, 'ehri_item_data'));
        parent::setUp();
    }

    public function ehri_item_data($args, $view)
    {
        $id = $args["id"];

        $headers = ['Accept' => self::API_MIMETYPE];
        $response = Requests::get(self::API_BASE . $id, $headers);

        if (!$response->success) {
            return '<pre>Error requesting EHRI API data: [' . $response->status_code . ']: ' . $response->body . '</pre>';
        }

        $json = json_decode($response->body, true);
        $type = $json['data']['type'];
        $data = $json['data'];

        // If there is 'included' data at the top level, move it
        // into the main data array...
        if (array_key_exists("included", $json)) {
            $data["included"] = $json["included"];
        }

        return $this->twig->render( $this->TEMPLATES[ $type ], $data );
    }
}