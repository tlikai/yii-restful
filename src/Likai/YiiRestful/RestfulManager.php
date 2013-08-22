<?php
/**
 * Yii RESTful URL Manager
 *
 * @author Likai<youyuge@gmail.com>
 * @link http://youyuge.com/
 */

class RestfulManager extends \CUrlManager
{
    public $resources;

    protected $actions = array('index', 'show', 'create', 'update', 'delete'); 

    protected $resourcePatterns = array(
        'index'  => array('<controller>/index', 'pattern' => '<controller:({resources})>', 'verb' => 'GET'),
        'show'   => array('<controller>/show', 'pattern' => '<controller:({resources})>/<id:\d+>', 'verb' => 'GET'),
        'create' => array('<controller>/create', 'pattern' => '<controller:({resources})>', 'verb' => 'POST'),
        'update' => array('<controller>/update', 'pattern' => '<controller:({resources})>/<id:\d+>', 'verb' => 'PUT'),
        'delete' => array('<controller>/delete', 'pattern' => '<controller:({resources})>/<id:\d+>', 'verb' => 'DELETE'),
    );

    protected $subResourcePatterns = array(
        'index'  => array('<controller>/index', 'pattern' => '<relation:({resources})>/<relation_id:\d+>/<controller:({subresources})>', 'verb' => 'GET'),
        'show'   => array('<controller>/show', 'pattern' => '<relation:({resources})>/<relation_id:\d+>/<controller:({subresources})>/<id:\d+>', 'verb' => 'GET'),
        'create' => array('<controller>/create', 'pattern' => '<relation:({resources})>/<relation_id:\d+>/<controller:({subresources})>', 'verb' => 'POST'),
        'update' => array('<controller>/update', 'pattern' => '<relation:({resources})>/<relation_id:\d+>/<controller:({subresources})>/<id:\d+>', 'verb' => 'PUT'),
        'delete' => array('<controller>/delete', 'pattern' => '<relation:({resources})>/<relation_id:\d+>/<controller:({subresources})>/<id:\d+>', 'verb' => 'DELETE'),
    );

    public function init()
    {
        $this->initRules();
        parent::init();
    }

    public function initRules()
    {
        $resourceActions = $subResourceActions = array();
        foreach ($this->resources as $options) {
            if (is_string($options)) {
                $options = array($options);
            }

            $actions = $this->parseActions($options);
            $subResource = false;
            if (strpos($options[0], '.') !== false) {
                list($resource, $subResource) = explode('.', $options[0]);
            } else {
                $resource = $options[0];
            }
            foreach ($actions as $action) {
                if ($subResource) {
                    $subResourceActions[$action][$resource] = $subResource;
                } else {
                    $resourceActions[$action][] = $options[0];
                }
            }
        }

        foreach ($resourceActions as $action => $resources) {
            $this->rules[] = str_replace('{resources}', implode('|', $resources), $this->resourcePatterns[$action]);
        }

        foreach ($subResourceActions as $action => $resources) {
            $this->rules[] = str_replace(array('{resources}', '{subresources}'), array(implode('|', array_keys($resources)), implode('|', $resources)), $this->subResourcePatterns[$action]);
        }
    }

    public function parseActions($options)
    {
        $actions = $this->actions;

        if (isset($options['only'])) {
            $actions = array_intersect($this->actions, $options['only']);
        }

        if (isset($options['except'])) {
            $actions = array_diff($this->actions, $options['except']);
        }

        return $actions;
    }
}
