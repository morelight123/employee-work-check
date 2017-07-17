<?php
/**
 *@author huangfengneng<657278268@qq.com>
 *@function 考核结果分析
 *@date 2017/07/15
 */
class Result extends Controller{
    //考核权重分析
    public function weight(){
        $this->model('Task');
        $data['taskinfo'] = $this->TaskModel->getInfo(array('id'=>$_SESSION['task_id']),array('id','title','start_time','end_time'));//考核名称 与时间
        $this->model('UserScore');
        $data['list']=$this->UserScoreModel->getList();
        //var_dump($data['list']);
        $this->view($data);
    }

    /**
    *@author huangfengneng<657278268@qq.com>
    *@function 考核指标分析
    */
    public function indication(){
        $this->model('result');
        $filter['task_id']=empty($_SESSION['task_id'])?'':$_SESSION['task_id'];
        $filter['org_id']=empty($_GET['org_id'])?'':$_GET['org_id'];
        $filter['username']=empty($_GET['username'])?'':$_GET['username'];
        $result['org_id']=$filter['org_id'];
        $result['username']=$filter['username'];
        $filter['place']=empty($_GET['place'])?3:$_GET['place'];
        $result['list']=$this->ResultModel->kpiScore($filter);
        //var_dump($result);
        $result['org']=$this->ResultModel->selectOrg();
        $this->view($result);
    }

    /**
    *@author huangfengneng<657278268@qq.com>
    *@function 考核细目表
    */ 
    public function details(){
        $filter['username']=empty($_GET['username'])?'':$_GET['username'];
        $data=array();
        $data['username']=$filter['username'];  
            if(!empty($_GET['user_id'])){
                $this->model('TaskUser');
                $where['user_id']=$_GET['user_id'];
                $data['info']=$this->TaskUserModel->getAll($where);
                $this->model('result');
                $filter=$this->ResultModel->getusername($_GET['user_id']);
            }
            if(!empty($filter['username'])){    
            $this->model('result');
            $filter['task_id']=empty($_SESSION['task_id'])?'':$_SESSION['task_id'];//考核任务ID
            $data['list']=$this->ResultModel->particulars($filter);
        }
        $this->view($data);      
    }
    /*
     * function 打分情况统计搜索界面，查找打分者打分情况和被考核者的被打分情况
     * author Kaixuan Meng
     * date 2017/07/15
     */
    public function normal(){
		$task_id=empty($_SESSION['task_id'])?'':$_SESSION['task_id'];
		$finalList=array();
        $username=empty($_GET['username'])?'':$_GET['username'];//用户名
        $data['username']=$username;
        $distinction=empty($_GET['like']['write'])?'':$_GET['like']['write'];//选中打分按钮或考核按钮的值
        $data['distinction']=$distinction;
		$this->model('Resultnormal');
		$res=$this->ResultnormalModel->searchbyName($username); //返回'id', 'org_id', 'place' 且就一个值
		if($res==false) {
			$data['list']=false;
			$this->view($data);
		}else {
			$res1=$this->ResultnormalModel->searchlist($res[0]['id'], $distinction,$task_id);//返回'kpi_user.user_id', 'user.org_id','user.username','user.place', 'kpi_user.status'
    		if ($distinction==1) {$temp="user_id";}
    		else {$temp="assess_id";}

    		foreach ($res1 as $key => $item){
    			$res1[$key]['place']=$this->ResultnormalModel->return_place($item['place']);
				$res1[$key]['status']=$item['status']?"√":"";
			}
            //var_dump($res1);
    		/*foreach ($res1 as $item) {
    			$temp99=$this->ResultnormalModel->searchbyID($item[$temp]);//返回'username','org_id','place'
    			if($temp99==false) continue;
    			$names=$temp99[0]['username'];
    			$temp2=$this->ResultnormalModel->return_org($temp99[0]['org_id']);
    			$temp3=$this->ResultnormalModel->return_place($temp99[0]['place']);
    			array_push($finalList, array($item[$temp],$temp2,$names , $temp3, $item['status']?"√":"")); //分别是id，部门，姓名，职业，打分状态
    		}	
    		*/	
    		$data['list'] = $res1;
            $this->view($data);
		}
    }


    /*
     * function 考核结果分析界面，判断是否需要更新
     * author zhangqixiang
     * date 2017/07/13
     */
    public function modifyData(){

        $this->model('Task');
        $taskinfo = $this->TaskModel->getInfo(array('id'=>$_SESSION['task_id']));
        $taskinfo['start_time'] = date('Y.m.d',strtotime($taskinfo['start_time']));
        $taskinfo['end_time'] = date('Y.m.d',strtotime($taskinfo['end_time'])); 

        //判断是否需要去更新数据
        if(empty($taskinfo['is_new_data'])){ //不需要去更新数据
            $this->go('result/indication');
            exit();
        }elseif($taskinfo['is_start_count']==1){ //需要去更新数据，已有人在统计，判断统计有效期
            if(strtotime($taskinfo['count_time'])>strtotime("-5 minute")){ //时间未过期
                $this->temp('result/transit',$taskinfo);
                exit();
            }else{ //时间已过期，可以去统计
                $this->TaskModel->update($_SESSION['task_id'],array('count_time'=>date('Y-m-d H:i:s',time())));
            }           
        }

        //获取当前当前任务被考核人id
        $this->model('TaskUser');
        $userIds = $this->TaskUserModel->getUserId($_SESSION['task_id'],'user_id');

        $data['taskinfo'] = $taskinfo;
        $data['userIds'] = json_encode($userIds); //被考核人id数组
        $data['total'] = count($userIds); //被考核人总数
        $this->View($data);
    }

    /*
     * function 检测统计情况
     * author zhangqixiang
     * date 2017/07/14
     */
    public function survey(){
        $this->model('Task');
        $taskinfo = $this->TaskModel->getInfo(array('id'=>$_SESSION['task_id']));

        if(empty($taskinfo['is_new_data'])){ //不需要去更新数据
            $this->Out(array('flag'=>0,'msg'=>'已统计完数据！跳转到指标结果分析！','status'=>201));
        }elseif($taskinfo['is_start_count']==1){ //需要去更新数据，已有人在统计，判断统计有效期
            if(strtotime($taskinfo['count_time'])>strtotime("-5 minute")){ //时间未过期
                $this->Out(array('flag'=>0,'msg'=>'不可以统计数据，继续等待！','status'=>202));
            }else{ //时间已过期，可以去统计
                $this->Out(array('flag'=>1,'msg'=>'可以去统计数据！'));
            }           
        }
    }


    /*
     * function 统计数据
     * author zhangqixiang
     * date 2017/07/13
     */
    public function statistics(){
        if(empty($_POST['user_id'])) $this->Out(array('flag'=>0,'msg'=>'被考核人id为空！'));
        if(empty($_POST['num'])) $this->Out(array('flag'=>0,'msg'=>'当前步骤为空！'));
        if(empty($_POST['total'])) $this->Out(array('flag'=>0,'msg'=>'总步骤为空！'));
        
        $this->model('Task');
        if($_POST['num']==1) $this->TaskModel->update($_SESSION['task_id'],array('is_start_count'=>1));

        $next_num = intval($_POST['num'])+1;

        $this->model('UserKpiScore');
        $this->UserKpiScoreModel->countAction(array('task_id'=>$_SESSION['task_id'],'user_id'=>$_POST['user_id']));    

        if($next_num>$_POST['total']){
            //修改当前任务为不需要更新统计
            $res = $this->TaskModel->update($_SESSION['task_id'],array('is_new_data'=>0,'is_start_count'=>0));
            if(!$res) $this->Out(array('flag'=>0,'msg'=>'修改数据更新统计状态失败！'));
        }

        $this->Out(array('flag'=>1,'msg'=>'ok!','data'=>array('next_num'=>$next_num)));
    }    
}