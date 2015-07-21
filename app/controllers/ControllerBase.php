<?php

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{

    protected function initialize()
    {
        $this->result = array('errno'  => 0,
                              'errmsg' => 'successful',
                              'data'   => '');

        $this->initRequestParams();
        $this->userInfo = $this->session->get('auth');
    }
    
    protected function forward($uri)
    {
        $uriParts = explode('/', $uri);
        $params = array_slice($uriParts, 2);
    	  return $this->dispatcher->forward(
    		    array(
    			      'controller' => $uriParts[0],
    			      'action'     => $uriParts[1],
                'params'     => $params
    		    )
    	  );
    }

    protected function initRequestParams() {
        $uri        = $this->request->getURI();
        $routerInfo = $this->getRouterInfo($uri);
        $requestKey = $routerInfo['controller'] . '_' . $routerInfo['action'] . '_keys';

        $this->requestParams = array();
        if (!isset($this->uriParams[$requestKey])) {
            return;
        }
        foreach ($this->uriParams[$requestKey] as $key=>$castFunction) {
            $$key = $this->request->getPost($key);
            if (empty($$key)) {
                $$key = $this->request->get($key);
            }  
            $this->requestParams[$key] = $castFunction($$key);
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
        if (empty($routerInfo[0])) {
            $routerInfo[0] = 'board';
        }
        if (empty($routerInfo[1])) {
            $routerInfo[1] = 'index';
        }
        if (empty($routerInfo[2])) {
            $routerInfo[2] = 'index';
        }
        
        return array('module'     => $routerInfo[0],
                     'controller' => $routerInfo[1],
                     'action'     => $routerInfo[2]);
    }

    protected $requestParams = array();
    public $result        = array();

    // 用户注册接口需要的字段.后续会放到配置里。
    protected $uriParams  = array(
                                'project_new_keys' => 
                                        array('name'   => 'strval',
                                              'type'   => 'intval',
                                              'member' => 'strval',),
                                'project_update_keys' => 
                                        array('createUid' => 'intval',
                                              'member'    => 'strval',),
                                'feature_new_keys' => 
                                        array('projectid'  => 'intval',
                                               'content'   => 'strval',),
                                'feature_update_keys' => 
                                        array('sort'    => 'intval',
                                              'content' => 'strval',), 
                                'user_register_keys' => 
                                        array('username'  => 'strval', 
                                              'password'  => 'strval', 
                                              'nickname'  => 'strval', 
                                              'email'     => 'strval', 
                                              'role'      => 'intval',),
                                'user_login_keys' => 
                                        array('username' => 'strval',
                                              'password' => 'strval',
                                              'remember' => 'intval',),
                            );
  // 登录用户信息；
  protected $userInfo = array();
}
