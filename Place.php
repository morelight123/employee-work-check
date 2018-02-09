<?php
/**
 *@控制器：岗位设置
 *author: mengkaixuan
 *@date 2017/7/10
 */
class Place extends Controller{

	public function index() {
		
		$data['list']=$this->cfg('place','place');
		$this->temp('base/table', $data);


	}
}
/*
//function 新增职位
	public function addPlace() {
		//添加函数
		$this->model('PlaceTableModel');
		
		/*
		$this->load->helper('form');
		$this->load->library('form_validation');

		//设置用户输入规则，不能为空
		$this->form_validation->set_rules('code', 'Code', 'required', 'required' => '职级代码不能为空'); 
		$this->form_validation->set_rules('place', 'Place', 'required'， 'required' => '职级名称不能为空');

		
		if ($this->form_validation->run() === FALSE) {
			//用户输入有误
			$this->view('base/table', $data); //刷新页面
			}
		else {
			$this->PlaceTableModel->addPlace('code'=>$_POST['code'], 'place'=>$_POST['place']);  //用控制器添加数据到数据库
		}
		
//删除功能
	public function deleteByPlace() {
		$this->model('PlaceTableModel');

		$this->PlaceTableModel->deleteByAttributes();
		*/
