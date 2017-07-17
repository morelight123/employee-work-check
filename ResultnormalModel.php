<?php
/**
 * @author mengkaixuan
 *@function 
 *@date 2017/7/15
 */
class ResultnormalModel extends Model{
	/**
	 * 用名字查询id，职务id，部门id
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

	 public function return_org($org_id) {      //用职位id，组织id返回具体值
		 $field=array('name');
		 $returnvalue=array();
		 $where=array('id'=>$org_id);
		$result=$this->db->select("organization",$field,$where);
		$res=$result[0]['name'];
		return $res;  //输出部门
	 }
	 public function return_place($place_id) {

		
		$data=$this->cfg('place','place');
		return $data[$place_id];  //输出职务
	 }

	public function searchlist($id,$i,$task_id) {
		
		if ($i==1) {
			$field=array('ku.user_id','org.name','u.username','u.place','ku.status');
			$join =array('[><]user(u)'=>array('ku.user_id'=>'id'),'[><]organization(org)'=>array('u.org_id'=>'id'));
			$where['assess_id']=$id;
			$where['task_id']=$task_id;
			$where['ORDER']=array('u.org_id'=>'ASC','u.place'=>'ASC');
			$result=$this->db->select('kpi_user(ku)',$join,$field,$where);
			//echo $this->db->last();
			//var_dump($result);
			// $field=array('kpi_user.user_id as user_id', 'organization.name as org_name','user.username as username','user.place as place', 'kpi_user.status as status');
			// $where=array('assess_id'=>$id, 'task_id'=>$task_id);
			// $where['ORDER']=['org_id' => "DESC",'place'=> "DESC"];

			// $this->db->from('kpi_user');
			// $this->db->join('user', 'user.id = kpi_user.user_id');
			// $this->db->join('organization', 'organization.id = user.org_id');
			// $result=$this->db->select('kpi_user',$field, $where);
			return $result;
		}


		else {
			$field=array('ku.assess_id','org.name','u.username','u.place','ku.status');
			$join =array('[><]user(u)'=>array('ku.assess_id'=>'id'),'[><]organization(org)'=>array('u.org_id'=>'id'));
			$where['user_id']=$id;
			$where['task_id']=$task_id;
			$where['ORDER']=array('u.org_id'=>'ASC','u.place'=>'ASC');
			$result=$this->db->select('kpi_user(ku)',$join,$field,$where);
			//$field=array('assess_id', 'status');
			//$where=array('user_id'=>$id);
			//$result=$this->db->select('kpi_user',$field,$where);
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