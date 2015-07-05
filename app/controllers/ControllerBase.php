<?php

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{

    protected function initialize()
    {
        $this->result = array('errno'  => 0,
                              'errmsg' => 'successful');
        // 暂时先不用，后续会迁移过来。
        //$this->initRequestParams();
    }

    protected function forward($uri)
    {
        $uriParts = explode('/', $uri);
        $params = array_slice($uriParts, 2);
    	return $this->dispatcher->forward(
    		array(
    			'controller' => $uriParts[0],
    			'action' => $uriParts[1],
                'params' => $params
    		)
    	);
    }

    protected function initRequestParams() {
        $uri        = $this->request->getURI();
        $routerInfo = $this->getRouterInfo($uri);

        $uriKey     = $routerInfo['controller'] . '_' . $routerInfo['action'] . '_keys';
        $this->requestParams = array();
        foreach ($this->uriParams[$uriKey] as $key=>$castFunction) {
            $$key = $this->request->getPost($key);
            if (empty($$key)) {
                $$key = $this->request->get($key);
            }  
            $this->requestParams[$key] = $$key;
        }
    }

    /**
     * @breif 获取请求中的请求信息获取请求的phalcon默认路由信息。
     *        uri: /board/feature/new?projectid=13&content=%E6%88%91%E4%BB%AC
     * @params $uri 请求的url地址。
     * @return {module, controller, action}
     */
    protected function getRouterInfo($uri) {
        $uri    = trim($uri, '/');
        $arrURI = explode('?', $uri);
        $path   = $arrURI[0];
        $routerInfo = explode('/', $path);
        
        return array('module'     => $routerInfo[0],
                     'controller' => $routerInfo[1],
                     'action'     => $routerInfo[2]);
    }

    protected $requestParams = array();
    protected $result        = array();

    // 用户注册接口需要的字段.后续会放到配置里。
    private $uriParams  = array(
                                'feature_new_keys' => 
                                        array('projectid' => 'intval',
                                               'content'   => 'strval',
                                               'uid'       => 'intval'),
                                'user_register_keys' => 
                                        array('username'  => 'strval', 
                                              'password'  => 'md5', 
                                              'nickname'  => 'strval', 
                                              'email'     => 'strval', 
                                              'role'      => 'intval',),);
}
