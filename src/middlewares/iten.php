<?php
namespace Middlewares;
class Iten {
    /**
     * ドメイン転送用 invoke
     *
     * @param  \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
     * @param  \Psr\Http\Message\ResponseInterface      $response PSR7 response
     * @param  callable                                 $next     Next middleware
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function __invoke($request, $response, $next)
    {
        $host = null;
        $host = !empty($_SERVER['HTTP_X_FORWARDED_HOST'])? $_SERVER['HTTP_X_FORWARDED_HOST'] : $host;
        $host = empty($host)? $_SERVER['HTTP_HOST'] : $host;
        $target_domain = $GLOBALS['container']['db']->table('redirects')->where('from_domain_name', $host)->get();
        if (count($target_domain) == 1) {
            header('Location: https://'. $target_domain[0]->to_domain_name);
            exit;
        }
        $response = $next($request, $response);
        return $response;
    }
    
    /**
     * リダイレクト用メソッド
     * 
     * @param 
     * @param
     * 
     * @return String
     */
}
