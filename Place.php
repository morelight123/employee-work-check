<?php
/**
 *@����������λ����
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
//function ����ְλ
	public function addPlace() {
		//��Ӻ���
		$this->model('PlaceTableModel');
		
		/*
		$this->load->helper('form');
		$this->load->library('form_validation');

		//�����û�������򣬲���Ϊ��
		$this->form_validation->set_rules('code', 'Code', 'required', 'required' => 'ְ�����벻��Ϊ��'); 
		$this->form_validation->set_rules('place', 'Place', 'required'�� 'required' => 'ְ�����Ʋ���Ϊ��');

		
		if ($this->form_validation->run() === FALSE) {
			//�û���������
			$this->view('base/table', $data); //ˢ��ҳ��
			}
		else {
			$this->PlaceTableModel->addPlace('code'=>$_POST['code'], 'place'=>$_POST['place']);  //�ÿ�����������ݵ����ݿ�
		}
		
//ɾ������
	public function deleteByPlace() {
		$this->model('PlaceTableModel');

		$this->PlaceTableModel->deleteByAttributes();
		*/
