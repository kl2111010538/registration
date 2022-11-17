<?php

use Slim\Http\Request; //namespace
use Slim\Http\Response; //namespace

//include classProc.php file
include __DIR__. '/../function/classProc.php';

//allow cors
$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});

$app->add(function ($req, $res, $next) {
    $response = $next($req, $res);
    return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});
//end


//read table class
$app->get('/class', function (Request $request, Response $response, array
$arg){
 return $this->response->withJson(array('data' => 'success'), 200);
});

// read all data from table class
$app->get('/allclass',function (Request $request, Response $response,array $arg)
{
 $data = getAllclass($this->db);
if (is_null($data)) {
 return $this->response->withHeader('Access-Control-Allow-Origin', '*')->withJson(array('error' => 'no data'), 404);
}
return $this->response->withJson(array('data' => $data), 200);
});

//request table class by condition (class id)
$app->get('/class/[{id}]', function ($request, $response, $args){
 
 $classId = $args['id'];
 if (!is_numeric($classId)) {
 return $this->response->withJson(array('error' => 'numeric paremeter required'), 500);
 }
 $data = getClass($this->db,$classId);
 if (empty($data)) {
 return $this->response->withJson(array('error' => 'no data'), 500);
}
 return $this->response->withJson(array('data' => $data), 200);

});


/////////////////////////////////////////////////
$app->post('/class/add', function ($request, $response, $args) {
    $form_data = $request->getParsedBody();
    $data = createClass($this->db, $form_data); 
    if ($data <= 0) {
        return $this->response->withJson(array('error' => 'add data fail'), 500);
    }
    return $this->response->withJson(array('add data' => 'success'), 200);
    }
);

///////////////////////////////////////////////////////////////////////////////

//delete row
$app->delete('/class/del/[{id}]', function ($request, $response, $args){
    
    $classId = $args['id'];
if (!is_numeric($classId)) { 
        return $this->response->withJson(array('error' => 'numeric paremeter required'), 422);
}
$data = deleteClass($this->db,$classId); 
if (empty($data)) {
    return $this->response->withJson(array($classId=> 'is successfully deleted'), 202);};
});
 //////////////////////////////////////////////////////////////////////////////////////   
    
//put table products
$app->put('/class/put/[{id}]', function ($request,  $response,  $args){
    $classId = $args['id'];
    $date = date("Y-m-j h:i:s");
    
    if (!is_numeric($classId)) { 
        return $this->response->withJson(array('error' => 'numeric paremeter required'), 422);
    }
    $form_dat=$request->getParsedBody();
    
$data=updateClass($this->db,$form_dat,$classId,$date);
    if ($data <=0)
    return $this->response->withJson(array('data' => 'successfully updated'), 200);
});