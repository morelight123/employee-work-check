<?php
/**
 * @author mengkaixuan
 *@function 
 *@date 2017/7/15
 */
class ResultnormalModel extends Model{
	/**
	 * �����ֲ�ѯid��ְ��id������id
	 * author  mengkaixuan
	 * date 2017/07/15
	 */
	 public function searchbyName($name){
		$field=array('id', 'org_id', 'place');
		$where['username']=$name;
		$result=$this->db->select("user",$field, $where);
		//var_dump($result);
		
		return $result;

	 }

	 public function return_org($org_id) {      //��ְλid����֯id���ؾ���ֵ
		 $field=array('name');
		 $returnvalue=array();
		 $where=array('id'=>$org_id);
		$result=$this->db->select("organization",$field,$where);
		$res=$result[0]['name'];
		return $res;  //�������
	 }
	 public function return_place($place_id) {

		
		$data=$this->cfg('place','place');
		return $data[$place_id];  //���ְ��
	 }

	public function searchlist($id,$i) {
		
		if ($i==1) {
			$field=array('user_id', 'status');
			$where=array('assess_id'=>$id);
			$result=$this->db->select('kpi_user',$field, $where);
			return $result;
		}


		else {
			$field=array('assess_id', 'status');
			$where=array('user_id'=>$id);
			$result=$this->db->select('kpi_user',$field,$where);
			return $result;
		}
	}

	public function searchbyID($id) {
		$field=array('username','org_id','place');
		$where=array('id'=>$id);
		$result=$this->db->select('user',$field,$where);
		return $result;
}
}