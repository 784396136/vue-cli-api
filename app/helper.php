<?php
function ok($data)
{
    return [
        'status_code' => 200,
        'message'=>'ok',
        'data' => $data
    ];
}
function error($error, $code)
{
    static $_http_code = [
        400 => "Bad Request",                  // 请求数据有问题
        401 => "Unauthorized",                 // 未登录
        403 => "Forbidden",                    // 登录但没有权限
        404 => "Not Found",                    // 请求数据没找到
        422 => "Unprocessable Entity",         // 无法处理输入的数据
        500 => "Internal Server Error",         // 服务器内部错误
    ];
    return [
        'status_code' => $code,
        'message' => $_http_code[$code],
        'errors' => $error
    ];
}